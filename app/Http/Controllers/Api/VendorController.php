<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLinkRequest;
use App\Model\ApiLink;
use App\Http\Resources\ApiLinkResource;
use Auth;
use App\Services\ApiLinkService;


class VendorController extends Controller
{
    public $successStatus = 200;
    private $ApiLinkService;
	public function __construct(ApiLinkService $ApiLinkService){
		$this->ApiLinkService = $ApiLinkService;
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
    public function store(ApiLinkRequest $request){    
       $input = $request->all();
       $user = Auth::user();
       $addvendor = ApiLink::create($input);
       return new ApiLinkResource($addvendor);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
       $vendor = $this->ApiLinkService->show($id); 
	   if(empty($vendor)){
	   return response()->json(['error'=>'vendor not exist','status'=>400],400);
		}
		else
	   return response()->json(['vendor'=>$vendor, 'status'=>200],200);
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
       $vendorUpdate =$this->ApiLinkService->show($id); 
       if(empty($vendorUpdate)){
      return response()->json(['error' => 'vendor not exist', 'status'=>400], 400);
          }
      else 
  	   $vendorUpdate =  $this->ApiLinkService->update($id, $request->all());
       return response()->json(['vendorUpdate' => $vendorUpdate, 'status'=>200], 200);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) { 
       $VendorDelete = $this->ApiLinkService->show($id); 
      if(empty($VendorDelete)){
     return response()->json(['error' => 'vendor not exist', 'status'=>400], 400);
          }
       else
       $VendorDelete =  $this->ApiLinkService->delete($id);
       return response()->json(['VendorDelete' => 'Delete', 'status'=>200], 200);
        }
}
