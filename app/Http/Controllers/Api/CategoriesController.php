<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoriesRequest;
use App\Model\ProductCategories;
use App\Model\ProductCategoryExtras;
use App\Model\ProductCategoryLinks;
use Auth;
use App\Http\Resources\ProductCategoriesResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use App\Services\ProductCategoriesService;
use App\Model\Product;

class CategoriesController extends Controller
  {   
        public $successStatus = 200 ;
        private $ProductCategoriesService ;

     public function __construct(ProductCategoriesService $ProductCategoriesService){
        $this->ProductCategoriesService = $ProductCategoriesService;
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
                 'name'=>'required',
                 'description'=>'required',
                 'parent_id'=>'required',
                 'is_show'=>'required',
                 'position'=>'required',
                 'is_master'=>'required',
                 'meta_title'=>'required',
                 'meta_tags'=>'required',
                 'is_featured'=>'required',
                 'parent_path'=>'required',
                 'image_url'=>'required|image|mimes:jpg,png,jpeg',
                 'is_featured'=>'required',
                 'vet_only'=>'required',
                 'position'=>'required',
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
            if ($request->hasFile('image_url')) {

                $imageName = time().'.'.$request->image_url->getClientOriginalExtension();
                $image = $request->file('image_url'); 
                $destinationPath   = public_path('CatUploads');
                $imagePath = $destinationPath. "/". $imageName;
                $image->move($destinationPath, $imageName);
                $image_url = "Catproducts/".$imageName;
                // $input['image'] = $name;
                // $url = url('uploads/'.$productid.'/products/'.$imageName);
                $input['image_url'] = $image_url ;
                $input['new_image'] = '1';
            }

            $ProductCategories = ProductCategories::create($input);
            $ProductCategoriesid = $ProductCategories->id ;

            $input['cat_id'] = $ProductCategoriesid;
            $ProductCategories = ProductCategoryExtras::create($input);
           return new ProductCategoriesResource($ProductCategories);
        }

        /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function show($id){
          $productCat = $this->ProductCategoriesService->show($id);
         return response()->json(['productCat'=>$productCat, 'status'=>200],200);  
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
          $productCatupdate = $this->ProductCategoriesService->update($id, $request); 
         return response()->json(['productCatupdate'=>$productCatupdate, 'status'=>200],200);
        }

        /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function destroy($id){
          $productCatDelete = $this->ProductCategoriesService->show($id);
           if(empty($productCatDelete)){
         return response()->json(['error'=> 'product not exist', 'status'=>400],400);
           }
        else {
          $productCatDelete = $this->ProductCategoriesService->delete($id); 
         return response()->json(['productCatDelete'=>'product deleted', 'status'=>200],200); 
            }
          }

        public function productCatList()
          {
            $productCatList = $this->ProductCategoriesService->productcatlist();
            return response()->json(['productCatList'=>$productCatList,'status'=>200],200); 
          }

}
