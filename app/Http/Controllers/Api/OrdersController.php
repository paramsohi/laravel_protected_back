<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Model\Order;
use App\Model\OrderCustomerAddresse;
use App\Model\OrderItem;
use App\Model\Product;
use Auth;
use App\Http\Resources\OrederResource;
use App\Services\OrderService;
use Storage;
use PDF;

class OrdersController extends Controller
{   
      public $successStatus = 200;
      private $OrederResource ;


    public function __construct(OrderService $OrderService){
        $this->OrderService = $OrderService;
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
                    'firstname' => 'required|string',
                    'lastname' => 'required|string',
                    'company_name' => 'required|string',
                    'email' => 'required|string|email|max:255|unique:orders',
                    'telephone'=> 'required',
                    'address1' => 'required|string',
                    'address2' => 'required',
                    'city' => 'required',
                    'postcode' => 'required',
                    'country' => 'required',
                    'total_paid' => 'required',
                    'status' => 'required',
                    'price' => 'required',
                    'vat_rate' => 'required',
                    'qty' => 'required',
                    'colour' => 'required',
                    'size' => 'required',
                    'address_type' => 'required|string',
                    'telephone' => 'required',
                    'email_address' => 'required|string|email|max:255|unique:order_customer_addresse',
                    'county' => 'required',
                    'home_telephone' => 'required',
                    'work_telephone' => 'required',
                    'mobile' => 'required',
            
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
         $Order = Order::create($input);
         
         $Orderid = $Order->id;
         $product = '1|5,2|9,3|2';
         $productdetail = explode (",", $product); 
         foreach ($productdetail as $key => $value) {
             //echo  $key . ':' . $value ;
        $productdetail1 = explode ("|", $value);
           // echo "<pre>";print_r( $productdetail1);
         $input['product_id'] = $productdetail1['0'];
         $input['qty'] = $productdetail1['1'];
         $input['order_id'] = $Orderid;
         $input['vat_rate'] = '20';
         $Order = OrderItem::create($input);
        
         }

         $Order = OrderCustomerAddresse::create($input);

        return new OrederResource($Order);
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
    public function update(Request $request, $id){
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

    public function orderList(){
        $orderList = $this->OrderService->lists();
        return response()->json(['orderList'=> $orderList, 'status'=>200],200);
     }

     public function orderGeneratePDF($id){
        $data = $this->OrderService->shows($id);
        $Item = OrderItem::where('order_id', $id)->with('Product')->first();           
        $pdf = PDF::loadView('order',['data'=>$data,'Item'=>$Item->Product]);
       return $pdf->download('order.pdf');
      
      }

  
}
