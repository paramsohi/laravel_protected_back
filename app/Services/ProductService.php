<?php

namespace App\Services;

use App\Model\Product;
use App\Model\ProductImage;
use Illuminate\Support\Facades\Storage;
use File;
use App\Model\ProductCategoryLinks;
use App\Model\ProductCategories;
use App\Model\UserAddresses;
use App\Model\Currency;
use App\Model\UserCurrency;


class ProductService 
{

public $successStatus = 200;
protected $model;
protected $ProductImage;
protected $ProductCategoryLinks;



public function __construct(Product $Product, ProductImage $ProductImage, ProductCategoryLinks $ProductCategoryLinks){
        $this->model = $Product;
        $this->ProductImage = $ProductImage;  
        $this->ProductCategoryLinks = $ProductCategoryLinks;
    }

 public function show($id) {
      $data = $this->model->where('id',$id)->with(['ProductImage','ProductCategoryLinks'])->first();
      return $data;     
     }

  public function delete($id){ 
     $productid = $this->model->where('id',$id)->first();
        if(!$productid){
    return response()->json(['error' => 'product not exist'], 200);
        }
     $productid = $this->model->where('id', $id)->delete();
     $productid = $this->ProductImage->where('product_id', $id)->delete();
     $productid = $this->ProductCategoryLinks->where('product_id', $id)->delete();
      return $productid;
      }
             
  public function update($id, $data) {
      $productUpdate = $this->model->findOrFail($id);
      $productUpdate->update($data->all());

      $productImageUpdate = $this->ProductImage->Where('product_id', $id)->first();    
      if($data->hasFile('gallery_img')){
        $image = $data->file('gallery_img');
        $name = $image->getClientOriginalName();

        $destinationPath   = public_path('uploads/'.$id.'/products');
        $imagePath = $destinationPath. "/".  $name;

        $image->move($destinationPath, $name);
         $image_url = "products/".$name;
        if($productImageUpdate->image_url != ""){
         $oldContractFile = public_path('uploads/'.$id.'/'.$productImageUpdate->image_url); // get previous image from folder
          if (file_exists($oldContractFile)) {
             //dd('File is exists.');
             unlink($oldContractFile);
          }
        }
        $productImageUpdate['image_url'] = $image_url;
        $productImageUpdate['gallery_img'] = 1;          
        $productImageUpdate->update();
       }
      $productCatUpdate = $this->ProductCategoryLinks->Where('product_id', $id)->first();
      $productCatUpdate->update([
      'product_id' => $id,
       'cat_id' => '1',
       'position' =>$data['position'],
     ]);
       $productCatUpdate = $this->model->where('id',$id)->with(['ProductImage','ProductCategoryLinks'])->first();
       return $productCatUpdate;
    }

  public function lists() {
     $productList = Product::select('id','name','description','price')->paginate(10);
     foreach ($productList as $key ) {
      $catId = ProductCategoryLinks::select('cat_id')->where('product_id',$key->id)->value('cat_id');
      $category_name = ProductCategories::select('name')->where('id',$catId)->value('name');
       $key->category = $category_name;
     }
    return $productList; 
      }

     public function frontproductcatlist(){
      $frontproductcatlist = ProductCategories::orderBy('position', 'ASC')->get();
       return $frontproductcatlist;
       }

   public function frontproductlist($id,$user_id){

      $productCat = ProductCategoryLinks::select('product_id','id')->where('cat_id',$id)->get();
      $Currency_id = null;
      if($user_id != null){
        $Currency_id = UserCurrency::select('curreny_id')->where('user_id',$user_id)->value('curreny_id');  
      }
     foreach ($productCat as  $value) {

      if($Currency_id != null){
        $Product = Product::select('currency_id','name','description','vat','price')->with('UserCurrency')->where('id',$value->product_id)->get();   
      }else{
        $Product = Product::select('currency_id','name','description','vat','price')->where('id',$value->product_id)->get();
      }
     
     $ProductImage  = ProductImage::select('image_url')->where('id',$value->product_id)->value('image_url');
     
     $Product[0]['image']= url('uploads/'.$value->product_id.'/'.$ProductImage);
     $Product[0]['product_id']= $value->product_id;
      // dd($Product[0]['image']);
      $value->product = $Product;
     
       }

    return $productCat;
  
  }

}