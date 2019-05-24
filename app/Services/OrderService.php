<?php

namespace App\Services;

use App\User;
use App\Model\Order;
use App\Model\OrderCustomerAddresse;
use App\Model\OrderItem;
use App\Model\Product;
use App\Model\BasketProduct;
use App\Model\Basket;
use App\Model\ProductCategories;
use App\Model\Currency;
use App\Model\Countries;
use App\Model\UserAddresses;
use App\Model\UserCurrency;
use DB;

  class OrderService 
  {

    public $successStatus = 200;
    protected $model;
    protected $OrderCustomerAddresse;
    protected $OrderItem;


    public function __construct(Order $Order, OrderCustomerAddresse $OrderCustomerAddresse, OrderItem $OrderItem){
      $this->model = $Order;
      $this->OrderCustomerAddresse = $OrderCustomerAddresse;
      $this->OrderItem = $OrderItem;
      }

  public function find($id) {
     $Userid = $this->model->where('id',$id)->first();
     if($Userid == ""){
     return response()->json(['error' => 'User not exist'], 200);     
      }
     return $Userid;
  }

  public function show($id){
  
     $data = $this->model->with('OrderItem')->where('id',$id)->first();
     return $data;
     }

  public function shows($id){
  
     $data = $this->model->with('OrderItem')->where('id',$id)->get()->toArray();
     // echo "<pre>"; print_r($data); 
      return $data;
     }

  public function delete($id){ 
     $Orderid = $this->model->findOrFail($id)->first();
    if(!$Orderid){
      return response()->json(['error' => 'User not exist'], 200);
       }
      $Orderid = $this->model->findOrFail($id)->delete();
      $Orderid = $this->OrderItem->findOrFail($id)->delete();
      $Orderid = $this->OrderCustomerAddresse->findOrFail($id)->delete();
      return $Orderid;
    }

  public function update($id,$data) {
     $OrderUpdate = $this->model->findOrFail($id);
     $OrderUpdate->update($data);

    $OrderUpdate = $this->OrderItem->findOrFail($id);

    $OrderUpdate->update([

      'vat_rate' => $data['vat_rate'],
      'qty' => $data['qty'],
      // 'framing_options_id' => $data['framing_options_id'],
      'colour' => $data['colour'],
      'size' => $data['size'],
      'price' => $data['price'],
      ]);

      $OrderUpdate = $this->OrderCustomerAddresse->findOrFail($id);

      $OrderUpdate->update([
      'address_type' => $data['address_type'],
      'telephone' => $data['telephone'],
      'email_address' => $data['email_address'],
      'county' => $data['county'],
      'home_telephone' => $data['home_telephone'],
      'work_telephone' => $data['work_telephone'],
      'mobile' => $data['mobile'],
      ]);
      $OrderUpdate = $this->model->where('id',$id)->with(['OrderItem','OrderCustomerAddresse'])->first();
      return $OrderUpdate;
    }

  public function lists() {
    $orderList = Order::select('id','firstname','address1','address2','status','total_paid')->get();
    return $orderList;
    }

  public function frontorderlist($user_id){
    // dd($user_id);
    $frontorderlist =Order::select('id','total_paid','created_at','address1','city','postcode','country')->where('customer_id',$user_id)->get();
    return $frontorderlist;
    }

  public function frontcartorderlist($user_id){

      $frontcartorderlist =BasketProduct::select('id','product_id','category_id','quantity')->where('user_id',$user_id)->get();

      foreach ($frontcartorderlist as $key => $value) {
      $Product_name = Product::select('name')->where('id', $value->product_id)->value('name');
      $ProductCategories = ProductCategories::select('name')->where('id', $value->category_id)->value('name');
      $value->category = $ProductCategories;
      $value->Product = $Product_name;
      }
      return $frontcartorderlist;

    }
public function storeusercurrency($user_id, $Currency_id)
    {

      $Currency_id = Currency::select('id')->where('id',$Currency_id)->value('id');
       // dd($Currency_id);
      $UserCurrency = UserCurrency::where('user_id',$user_id)->get()->toArray();

   if($Currency_id == null){

      return response()->json(['message'=>'Currency not exist', 'status'=>400],400);  
    }else{
      
          if(count($UserCurrency) != 0){
           
            $Currency = UserCurrency::where('user_id',$user_id)->update(['curreny_id' => $Currency_id]);   
          }else{
          
            $Currency = new UserCurrency();
            $Currency->user_id = $user_id;
            $Currency->curreny_id = $Currency_id;
            $Currency->save();            
          }

          return$Currency;
        } 
    }

   public function updateOrderItems($id,$order_id,$data)
       {
        $OrderUpdate = $this->model->findOrFail($id);
         $OrderUpdate->update([
          'status' => 'cart',
          'ip_address' => \Request::ip(),
         ]);
     
    $OrderItem = OrderItem::where([['product_id', $id],['order_id', $order_id]]);

    $OrderItem->update([
      'qty' => $data['qty'],
      'colour' => $data['colour'],
      'size' => $data['size'],
      'price' => $data['price'],
         ]);
    
    return new $OrderUpdate;
      } 
 
  }


