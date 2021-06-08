<?php

namespace App\Http\Controllers;

use App\Constants\StockistConstants;
use App\Helpers\CommonHelper;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    protected  $productService = null;
    public function __construct(){
        $this->productService = New ProductService();
    }


    /**
     * Show Product List
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        try {
            $pageData = array();
            $pageData['title'] = 'Users';
            return view('products.productlist',compact('pageData'));
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }

    /**
     * Add Product
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addProductAction(Request $request){
        try {
            session()->forget(['error','success']);
            $productInfo =[];
            if($request->getMethod() == 'POST'){
                $validator = $this->validateProduct($request);
                if(!$validator->fails()){
                    $this->productService->addProduct($request->all());
                    session()->flash('success','Product Has Been Added Successfully.');
                }   else{
                    $messages = $validator->errors()->all();
                    $productInfo = $request->all();
                    session()->flash('error',$messages);
                }
            }
            return view('products.newproduct',compact('productInfo'));
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }
    /**
     * Add Product
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateProductAction(Request $request,$uuid){
        try {
            session()->forget(['error','success']);
            $productInfo = Product::where('uuid',$uuid)->first();
            if($request->getMethod() == 'POST' && CommonHelper::isNotNullOrEmpty($uuid)){
                $validator = $this->validateProduct($request);
                if(!$validator->fails()){
                    $data = $request->all();
                    $data['uuid'] = $uuid;
                    $this->productService->updateProduct( $data);
                    session()->flash('success','Product Has Been Updated Successfully.');
                }   else{
                    $messages = $validator->errors()->all();
                    $productInfo = $request->all();
                    session()->flash('error',$messages);
                }
            }
            return view('products.newproduct',compact('productInfo'));
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }
    /**
     * Add Product
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function archiveProductAction(Request $request,$uuid){
        try {
            session()->forget(['error','success']);
            if($request->getMethod() == 'POST' && CommonHelper::isNotNullOrEmpty($uuid)){
                $validator = $this->validateProduct($request);
                if(!$validator->fails()){
                    $this->productService->archivedProduct(uuid);
                    session()->flash('success','Product Has Been Archived Successfully.');
                }   else{
                    $messages = $validator->errors()->all();
                    session()->flash('error',$messages);
                }
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }
    /**
     * validate Product
     * @param Request $request
     * @return  $validator
     */
    private function validateProduct(Request $request){
     return  $validator =   Validator::make($request->all(), [
            "name" => ['required'],
            "sku" => ['required'],
            "description" => ['max:255'],
            "price" => ['numeric',"min:0"],
            "points" => ['numeric','min:0'],
        ]);
    }


    /**
     * getProductTableList
     *
     * @param  array $userInfo
     * @return array
     */
    public function getProductTableListAction(array $userInfo = null){
        try{
            $products = Product::whereNull('archived_at')->get();
            $array=array();
            $array['draw']=1;
            $array['recordsTotal']= $products->count();
            $array['recordsFiltered']= $products->count();
            $array['data']= array();

            foreach( $products as $key=>$value)
            {
                $ActionElements ='<a target="_blank"  class="btn btn-default" href="'.route('product.update',['uuid'=>$value->uuid]).'" title="Edit"><i class="fa fa-pen"></i></a>
                                      <a target="_blank" class="btn btn-default" href="'.route('product.archive').'" title="Archive"><i class="fas fa-archive"></i></a>
                              ' ;
                $array['data'][] = array(
                    $value->sku,
                    $value->name,
                    $value->description,
                    $value->price,
                    $value->points,
                    $ActionElements);
            }
            return $array;
        }catch (\Exception $e){
         Log::error($e->getMessage());
        }

    }
}
