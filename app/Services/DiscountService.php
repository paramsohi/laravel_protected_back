<?php

namespace App\Services;

use App\Model\Discount;



class DiscountService 
    {

    public $successStatus = 200;
    protected $model;


    public function __construct(Discount $Discount){
       $this->model = $Discount;
     }

    public function show($id){
        $data = $this->model->where('id',$id)->first();
        return $data;
      }

    public function delete($id){ 
       $DiscountDelete = $this->model->findOrFail($id)->first();
       if(!$DiscountDelete){
      return response()->json(['message' => 'discount not exist'], 400);
       }
      $DiscountDelete = $this->model->findOrFail($id)->delete();
      return $DiscountDelete;
       }

    public function update($id, $data) {  
       $DiscountUpdate = $this->model->findOrFail($id);
       $DiscountUpdate->update($data);
      return $DiscountUpdate;
     }

     public function lists() {
        $discountList = Discount::select('id','code','value','expiry_date','single_use','is_deleted')->get();
        return $discountList;
      }
          public function frontdiscountlist($userId, $code)
      {
     
     $DiscountCode = Discount::where('code',$code)->first();

      //echo $userId.'==='.$code; die;      
     if($DiscountCode != null){

      //dd($DiscountCode);
     $DiscountHistory = DiscountCodeHistory::where([['discount_code', $code],['user_id', $userId]])->first();
    // dd($DiscountHistory);
     if($DiscountHistory != null){

      return response()->json(['messsage'=>'discount code not valid!', 'status'=>400 ],400);
    }
    
     else{

          $Discount = new DiscountCodeHistory();
          $Discount->user_id = $userId;
          $Discount->discount_code = $code;
          $Discount->save();

     }
   }
  
     return $DiscountCode;

    }
     
    }

  
            