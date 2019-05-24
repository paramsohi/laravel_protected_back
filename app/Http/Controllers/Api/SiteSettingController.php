<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SiteSetting;
use App\Http\Requests\SiteSettingRequest;
use App\Http\Resources\SiteSettingResource;
use App\Services\SiteSettingSerrvice;
use App\Model\Currency;

class SiteSettingController extends Controller
{
     public $successStatus = 200;
     private $SiteSettingSerrvice;

     public function __construct(SiteSettingSerrvice $SiteSettingSerrvice){
        $this->SiteSettingSerrvice = $SiteSettingSerrvice;
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
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
   
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
       $siteSettingUpdate = $this->SiteSettingSerrvice->update($id,$request->all());
       return response()->json(['siteSettingUpdate' => $siteSettingUpdate ,
            'message' => 'update successfully','status' => 200],200);
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function siteSettingList(){ 
       $siteSettingList = $this->SiteSettingSerrvice->lists();
       return response()->json(['siteSettingList'=>$siteSettingList, 'status'=>200],200);
     }

    public function countriesList(){   
        $countriesList = $this->SiteSettingSerrvice->countrieslist();
        return response()->json(['countriesList'=>$countriesList, 'status'=>200],200);
      }

    public function stateList($id){  
       $stateList = $this->SiteSettingSerrvice->statelist($id);
       return response()->json(['stateList'=>$stateList, 'status'=>200],200);
      }

    public function citiesList($id){
       $CitiesList = $this->SiteSettingSerrvice->Citieslist($id);
       return response()->json(['CitiesList'=>$CitiesList, 'status'=>200],200);
     }

    public function currenciesList(){ 
       $currenciesList = $this->SiteSettingSerrvice->currencieslist();
       return response()->json(['currenciesList'=>$currenciesList, 'status'=>200],200);
        }

    public function currenciesGet(Request $request, $id) { 
       $currencies = $this->SiteSettingSerrvice->currenciesget($id, $request->all());
       return response()->json(['currencies'=>$currencies, 'status'=>200],200);
     }
}
