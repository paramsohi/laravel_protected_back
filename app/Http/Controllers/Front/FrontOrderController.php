<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Model\Order;
use App\Model\OrderCustomerAddresse;
use App\Model\OrderItem;
use App\Model\Product;
use App\Model\BasketProduct;
use App\Model\Basket;
use Auth;
use Validator;
use App\Http\Resources\OrederResource;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\ChipsService;
use App\Model\UserAddresses;
use PDF;
use Session;

class FrontOrderController extends Controller
 { 
      public $successStatus = 200;
      private $OrederResource ;
      private $ChipsService ;
      private $ProductService;


    public function __construct(OrderService $OrderService, ProductService $ProductService, ChipsService $ChipsService){
        $this->OrderService = $OrderService;
        $this->ProductService = $ProductService;
        $this->ChipsService = $ChipsService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 public function store(Request $request){
         $input = $request->all();
         $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|string|email|max:255|unique:orders',
                'telephone'=> 'required',
                'billing_address1' => 'required',
                'billing_address2' => 'required',
                'billing_city' => 'required',
                'billing_postcode' => 'required',
                'billing_country' => 'required'
                // 'product_id' =>'required',
                // 'category_id'=>'required',   
          ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $key => $value) {
                $msg = $value;
                break;
            }
            return response()->json(['msg' => $msg, 'status' => 400], 400);
        }
         
            $user_id = Auth::user()->id;
            $userAddress = UserAddresses::select('street1','street2','city','country','postcode')->where('user_id', $user_id)->first();

             DB::beginTransaction();            
  
             $input['customer_id'] = $user_id;
             $input['ip_address'] = \Request::ip();
             $input['address1'] = $userAddress->street1;
             $input['address2'] = $userAddress->street2;
             $input['city'] = $userAddress->city;
             $input['country'] = $userAddress->country;
             $input['postcode'] = $userAddress->postcode;
             $OrderData = Order::create($input);
             $Orderid = $OrderData->id;
          
            $productItems = $request->productItems;

            foreach ($productItems as $item) {
              $data['order_id']= $Orderid;
              $data['product_id']= $item['product_id'];
              $data['price']= $item['price'];
              $data['vat_rate']= isset($item['vat_rate']) ? $item['vat_rate'] : '0' ;
              $data['qty']= $item['quantity'];
              $data['colour']= isset($item['colour']) ? $item['colour'] : '0' ;
              $data['size']= isset($item['size']) ? $item['size'] : '0' ;
              $OrderItemQuery = OrderItem::create($data);
            }
          if( !$OrderData || !$OrderItemQuery )
          {
              DB::rollbackTransaction();
          } else {
              // Else commit the queries
              DB::commit();
          }            
                   
            return response()->json(['order'=>$OrderData, 'status'=>200],200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
       $order = $this->OrderService->show($id);
       return response()->json(['order'=>$order, 'status'=>200],200); 
       }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){ 
      $orderUpdate = $this->OrderService->update($id,$request->all());
       return response()->json(['orderUpdate'=>$orderUpdate, 
        'message'=> 'order updated successfully', 
        'status'=>200],200);
       }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
      $orderDelete = $this->OrderService->show($id);
       if(empty($orderDelete)){
      return response()->json(['message'=> 'Order does not exist', 'status'=>400],400);
        }
      else 
      $orderDelete = $this->OrderService->delete($id); 
    return response()->json(['orderDelete'=>'order deleted', 'status'=>200],200);
      }

    public function frontOrderList(){  
       $user = Auth::user();
       $user_id = $user->id;
       $frontOrderList = $this->OrderService->frontorderlist($user_id );
      return response()->json(['frontOrderList'=>$frontOrderList, 'status'=>200],200);
       }

    public function frontCartOrderList(){ 
      $user = Auth::user();
      $user_id = $user->id;
      $frontCartOrderList = $this->OrderService->frontcartorderlist($user_id );
     return response()->json(['frontCartOrderList'=>$frontCartOrderList, 'status'=>200],200);
       }

    public function frontProductCatList(){
      $frontProductCatList = $this->ProductService->frontproductcatlist();
     return response()->json(['frontProductCatList'=>$frontProductCatList, 'status'=>200],200);
       }

   public function frontProductList($id){
       $user = Auth::user();
        // dd($user);
        if(!empty($user)){
       $frontProductList = $this->ProductService->frontproductlist($id, $user->id);
        }
     else{
       $frontProductList = $this->ProductService->frontproductlist($id); 
      }
    return response()->json(['frontProductList'=>$frontProductList, 'status'=>200],200);
    }

    public function checkChip(Request $request, $chip_number){
        $user = Auth::user();
        $user_id = $user->id;
        $checkChip = $this->ChipsService->checkchip($chip_number);
        return response()->json(['checkChip'=>$checkChip, 'status'=>200],200);
      }

    public function storeUserCurrency($Currency_id){
        $user = Auth::user();
        $user_id = $user->id;
        $Currency_id = $Currency_id;
        $storeUserCurrency = $this->OrderService->storeusercurrency($user_id, $Currency_id);
        return response()->json(['storeUserCurrency'=>$storeUserCurrency, 'status'=>200],200);
     }

       public function updateOrderItems(Request $request,$id,$order_id){ 
        // $user = Auth::user();
        // $id = $user->id;
       $updateOrderItems = $this->OrderService->updateOrderItems($id,$order_id,$request->all());
       return response()->json(['updateOrderItems'=>$updateOrderItems, 
        'message'=> 'order items updated successfully', 
        'status'=>200],200);
       }


     public function frontOrderGeneratePDF($id){
        $data = $this->OrderService->shows($id);
        $Item = OrderItem::where('order_id', $id)->with('Product')->first();           
        $pdf = PDF::loadView('order',['data'=>$data,'Item'=>$Item->Product]);
       return $pdf->download('order.pdf');
      
      }
}
