<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Model\Discount;
use App\Http\Resources\DiscountResource;
use App\Services\DiscountService;

class DiscountController extends Controller
{
    public $successStatus = 200;
    private $DiscountService;

    public function __construct(DiscountService $DiscountService){
        $this->DiscountService =$DiscountService;
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
    public function store(DiscountRequest $request){
      $input =$request->all();
      $discount = Discount::create($input);
      return new DiscountResource($discount); 
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
       $discount =  $this->DiscountService->show($id);
       return Response()->json(['discont'=>$discount, 'status'=>200],200);
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
       $discountUpdate = $this->DiscountService->update($id,$request->all());
       return response()->json(['$discountUpdate'=>$discountUpdate, 
            'messsage'=>'Discount updated successfully',
             'status'=>200],200);
       }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
       $discountDelete = $this->DiscountService->show($id);
       if(empty($discountDelete)){
      return response()->json(['messsage'=>'discount not exist', 'status'=>400 ],400);
       }
      $discountDelete = $this->DiscountService->delete($id);
    return response()->json(['message'=>'Discount deleted successfully', 'status'=>200],200);
      }

    public function discountList(){
       $discountList = $this->DiscountService->lists();
       return response()->json(['discountList'=>$discountList,'status'=>200],200);
      }

    public function frontDiscountList($code){
        $user = Auth::user();
        $userId = $user->id;

        $frontDiscountList = $this->DiscountService->frontdiscountlist($userId,$code);
       
      
        return response()->json(['frontDiscountList'=>$frontDiscountList,'status'=>200],200);
      }

}
