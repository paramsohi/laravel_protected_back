<?php

namespace App\Services;

use App\Model\ProductCategories;
use App\Model\ProductCategoryExtras;
use App\Model\ProductCategoryLinks;
use File;
use Auth;


class ProductCategoriesService 
{

public $successStatus = 200;
protected $model;
protected $ProductCategoryExtras;



public function __construct(ProductCategories $ProductCategories, ProductCategoryExtras $ProductCategoryExtras) {
        $this->model = $ProductCategories;
        $this->ProductCategoryExtras = $ProductCategoryExtras; 
     }

    public function find($id) {
        $Catid = $this->model->where('id',$id)->first();
        if($Catid == ""){
            return response()->json(['error' => 'User not exist'], 200);     
        }
        return $Catid;
    }

    public function show($id){
        $data = $this->model->where('id',$id)->first();
        return $data;
     }

    public function delete($id){ 
        $Catid = $this->model->where('id',$id)->first();
       if(!$Catid){
       return response()->json(['error' => 'User not exist'], 200);
            }
        $Catid = $this->model->where('id', $id)->delete();
        $Catid = $this->ProductCategoryExtras->where('cat_id', $id)->delete();
         return $Catid;
      }
     
    public function update($id, $data) {
        $user = Auth::user();
        $userid = $user->id;
        $productCatUpdate = $this->model->findOrFail($id);         
        $input = $data->all();
         if($data->hasFile('image_url')){
            $image = $data->file('image_url');
            $name = $image->getClientOriginalName();
            // $destinationPath   = public_path('CatUploads/'.$userid.'/Catproducts');
            $destinationPath   = public_path('CatUploads');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $input['image_url'] = "Catproducts/".$name;
            $input['new_image'] = 1; 
         if($productCatUpdate->image_url != ""){
              // $oldContractFile = public_path('CatUploads/'.$userid.'/'.$productCatUpdate->image_url); 
               $oldContractFile = public_path('CatUploads/'.'/'.$productCatUpdate->image_url); 
          if (file_exists($oldContractFile)) {
                unlink($oldContractFile);              
              }
            }

         }
        $productCatUpdate->update($input);
        $ProductCategoryExtras = $this->ProductCategoryExtras->Where('cat_id', $id)->first(); 

        $ProductCategoryExtras->update(['vet_only' => $data['vet_only']]);

        return $ProductCategoryExtras;
     }

    public function productcatlist()
       {
         $ProductCategories = ProductCategories::select('id','name')->get();

         return $ProductCategories;
       }
}