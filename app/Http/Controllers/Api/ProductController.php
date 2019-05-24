<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Model\Product;
use App\Model\ProductImage;
use Auth;
use Validator;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use App\Http\Resources\ProductCategoriesResource;
use App\Model\ProductCategoryLinks;

class ProductController extends Controller
{     
    public $successStatus = 200 ;
    private $ProductService ;

    public function __construct(ProductService $ProductService){
        $this->ProductService = $ProductService;
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
                'name' => 'required',
                'description' => 'required',
                'tags' => 'required|unique:product_live',
                'price' => 'required',
                'sale_price' => 'required',
                'position' => 'required',
                'meta_title' => 'required',
                'gallery_img' => 'required|image|mimes:jpg,png,jpeg',
                'position' => 'required',
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
        $product = Product::create($input);
        $productid = $product->id ;
      if ($request->hasFile('gallery_img')) {
              
            $imageName = time().'.'.$request->gallery_img->getClientOriginalExtension();
            $image = $request->file('gallery_img'); 
            $destinationPath   = public_path('uploads/'.$productid.'/products');
            $imagePath = $destinationPath. "/". $imageName;
            $image->move($destinationPath, $imageName);
            $image_url = "products/".$imageName;
            $input['image_url'] = $image_url ;
            $input['gallery_img'] = '1';
             }

        $input['product_id'] = $productid;
        $product = ProductImage::create($input);

        $input['product_id'] = $productid;
        $product = ProductCategoryLinks::create($input);
       return response()->json(['product'=>$product, 'message'=>'success', 'status'=>200],200);
          }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
       $product = $this->ProductService->show($id);
       return response()->json(['product'=>$product]); 
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
       // print_r($request); dd();
       $productupdate = $this->ProductService->update($id, $request); 
       return response()->json(['productupdate'=>$productupdate]);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
       $productupdate = $this->ProductService->show($id);
        if(empty($productupdate)){
        return response()->json(['message'=> 'product not exist','status'=>400],400);
        }
       else 
       $productupdate = $this->ProductService->delete($id); 
      return response()->json(['productupdate'=>'Delete','status'=>200],200); 
    }
 
    public function productList(){
       $productList = $this->ProductService->lists();
       return response()->json(['productList' => $productList, 'status'=>200], 200);
     }
}
