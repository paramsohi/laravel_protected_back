<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChipsRequest;
use Auth;
use Validator;
use App\Model\Chips;
use App\Model\Chipsets;
use App\Http\Resources\ChipsResource;
use App\Services\ChipsService;

class ChipsController extends Controller
  { 
  public $successStatus = 200;
  private $ChipsService ;

  public function __construct(ChipsService $ChipsService)
    {
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
  public function store(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($request->all(), [
      'serial_no' => 'required',
      'count' => 'required',
      'chipset_type' => 'required',
      'first_chip_no' => 'required',
      // 'last_chip_no' => 'required',
      'notes' => 'required',

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
         
          $input['first_chip_no'] = $input['first_chip_no'];
          $total = $input["count"]-1;
          $input["last_chip_no"] = ($input['first_chip_no']+$total);
          $chips = Chipsets::create($input);
          $chipsetId = $chips->id;
          
          $first = $input['first_chip_no'];
          $last = $first + $total;
         for ($i=$first; $i <= $last ; $i++) { 
             $input['chip_number'] = $i;
              $input['owner_id'] = $request->owner_id;
              $input['chipset_id'] = $chipsetId;
              $input['IId'] = '0';
              $input['is_free'] = $request->is_free ? $request->is_free : 0;
              $input['hide_search'] = $request->hide_search ? $request->hide_search : 0;
              $input['price'] = $request->price;

              $chips = Chips::create($input);

         }
       
          return new ChipsResource($chips);

    }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id){
  $chip = $this->ChipsService->show($id);
  return response()->json(['chip'=>$chip, 'status'=>200],200);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {

  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id){
  $chipUpdate = $this->ChipsService->update($id, $request->all());
  return response()->json(['chipUpdate'=>$chipUpdate,
  'message'=> 'chips updated successfully',   
  'status'=>200],200);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id){
  $chipDelete = $this->ChipsService->show($id);
  if(empty($chipDelete)){ 
  return response()->json(['message'=>'chip not exist','status'=>400],400);
  }
  $chipDelete = $this->ChipsService->delete($id);
  return response()->json(['message'=>'chip deleted','status'=>200],200);
  }

  public function chipList(){
  $chipList = $this->ChipsService->lists();
  return response()->json(['chipList'=> $chipList, 'status'=>200],200);
  }

  public function petChipList(){
  $petChipList = $this->ChipsService->petChipList();
  return response()->json(['petChipList'=>$petChipList,'status'=>200],200);
  }
  }
