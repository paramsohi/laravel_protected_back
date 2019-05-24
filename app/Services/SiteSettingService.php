<?php

namespace App\Services;

use App\Model\SiteSetting;
use App\Model\Countries;
use App\Model\States;
use App\Model\Cities;
use App\Model\Currency;


class SiteSettingSerrvice 
    {

    public $successStatus = 200;
    protected $model;


    public function __construct(SiteSetting $SiteSetting){
      $this->model = $SiteSetting;

    }

    public function show($id) {
        $data = $this->model->where('id',$id)->first();
        return $data;
      }

    public function delete($id) { 
      $LostFoundDelete = $this->model->findOrFail($id)->first();
       if(!$LostFoundDelete){
      return response()->json(['message' => ' not exist'], 400);
        }
      $LostFoundDelete = $this->model->findOrFail($id)->delete();
      return $LostFoundDelete;
      }

    public function update($id, $data) {
        $siteSettingUpdate = $this->model->where('id',$id); 
        $siteSettingUpdate->update($data);
        return $siteSettingUpdate;
    }

    public function lists() {
       $SiteSetting = SiteSetting::get();
        return $SiteSetting;
     }

    public function countrieslist() {
       $countrieslist = Countries::get();
        return $countrieslist;
     }

    public function statelist($id) {
       $statelist = States::where('country_id',$id)->get();
        return $statelist;
      }

    public function Citieslist($id) {
        $Citieslist = Cities::where('state_id',$id)->get();
      return $Citieslist;
     }

    public function currencieslist() {
         $currencieslist = Currency::get();
         return $currencieslist;
       }

    public function currenciesget($id,$data) {
        $currenciesget = Currency::where('id',$id)->update(['status' => $data['status'],]);
        return $currenciesget;
      }


     
    }

  
            