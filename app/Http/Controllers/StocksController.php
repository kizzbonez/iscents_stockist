<?php

namespace App\Http\Controllers;

use App\Constants\StockistConstants;
use App\Helpers\CommonHelper;
use App\Models\Product;
use App\Models\Stocks;
use App\Services\StocksService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StocksController extends Controller
{
    //
    protected $stockService = null;
    public function __construct(){
        $this->stockService = New StocksService();
    }


    public function index(){

        try {
            $pageData = array();
            $pageData['title'] = 'Users';

            return view('stocks.stockslist');
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }


    public function addStocksAction(Request $request){
        try {
            session()->forget(['error','success']);
            $products = Product::whereNull('archived_at')->get();
            $stockInfo = $request->all();
            if($request->getMethod() == 'POST'){
                $validator = $this->validateProduct($request);
                if(!$validator->fails()){
                    $data = $request->all();
                    if($data['trans_type'] == StockistConstants::TRANS_TYPE_OUT){
                        $data['qty'] = -abs($data['qty'] );
                    }
                    $stockData =$this->stockService->addStockTransactionUser($data['product_id'],
                        null,
                        $data['qty'],
                        Auth::user()->id,
                        Auth::user()->id,
                        $data['trans_type'],
                        $data['remarks']);
                    if(CommonHelper::isNotNullOrEmpty($stockData)){
                        session()->flash('success','Stock successfully added for the Product.');
                    }
                }   else{
                    $messages = $validator->errors()->all();
                    $stockInfo = $request->all();
                    session()->flash('error',$messages);
                }
            }
            return view('stocks.stocktransaction',compact('stockInfo','products'));
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
            "product_id" => ['required'],
            "qty" => ['required','min:0','numeric'],
            "trans_type" => ['required'],
        ],[
            "qty.min"=>"Quantity value must not be 0",
            "qty.required"=>"Quantity value must have a value",
            "qty.numeric"=>"Quantity value must be a number",
            "product_id.required"=>"Please choose the product"
        ]);
    }


    public function getStockTableListAction(){
        try{
            $products = Stocks::select('stocks_transaction.*',DB::raw('sum(qty) as quantity'))->where('to_id',Auth::user()->id)->orWhere('from_id',Auth::user()->id)->with('product')->groupBy('product_id')->get();
            $array=array();
            $array['draw']=1;
            $array['recordsTotal']= $products->count();
            $array['recordsFiltered']= $products->count();
            $array['data']= array();
            foreach( $products as $key=>$value)
            {
                $ActionElements ='<a target="_blank" class="btn btn-default" href="" title="Stock History"><i class="fas fa-list"></i></a>
                              ' ;
                $array['data'][] = array(
                    $value->product->sku,
                    $value->product->name,
                    $value->product->description,
                    $value->product->price,
                    $value->product->points,
                    $value->quantity,
                    $ActionElements);
            }
            return $array;
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }

    }



    public function getStockHistoryAction($product_id){
        try {
            $productHistory = Product::find($product_id);
            if(CommonHelper::isNotNullOrEmpty($productHistory)){

                return view('stocks.stockhistory',compact("product_id"));
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());

        }
    }

    public function getStockTransactionsTableListAction($product_id){
        try {
            if(CommonHelper::isNotNullOrEmpty($product_id)){
                $productHistory = Stocks::where('product_id',$product_id)
                    ->where(function($queryContainer){
                        $queryContainer-> where('to_id',Auth::user()->id)->orWhere('from_id',Auth::user()->id);
                    })->with('from','to')
                    ->get();

                $array=array();
                $array['draw']=1;
                $array['recordsTotal']=  $productHistory->count();
                $array['recordsFiltered']=  $productHistory->count();
                $array['data']= array();
                foreach( $productHistory as $key=>$value)
                {

                    $array['data'][] = array(
                        $value->from['name'] ,
                        $value->to['name'] ,
                        StockistConstants::TRANS_TYPE[$value->trans_type],
                        $value->qty,
                        Carbon::parse($value->created_at)->format(StockistConstants::GMT_DATE_FORMAT));
                }
                return $array;
            }
            return view('stocks.stockhistory',compact("{$product_id}"));
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }

}
