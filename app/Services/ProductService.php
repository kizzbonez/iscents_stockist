<?php


namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(){

    }

    public function addProduct($data){
        DB::beginTransaction();
        try {
            $product  = New Product();
            $product->uuid = Str::uuid()->toString();;
            $product->name = $data['name'];
            $product->sku = $data['sku'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->points = $data['points'];
            $product->created_by = Auth::user();
            $product->created_at = Carbon::now();
            $product->updated_by = NULL;
            $product->updated_at = NULL;
            $product->archived_by = NULL;
            $product->archived_at = NULL;
            $product->save();
            DB::commit();
            return  $product;
        } catch (Exception $e) {
            DB::rollback();
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            Log::error($e->getMessage());
        }
        catch (Throwable $e) {
            DB::rollback();
        }
    }


    public function updateProduct($data){
        DB::beginTransaction();
        try {
            $product  = Product::where('uuid',$data['uuid'])->first();
            $product->name = $data['name'];
            $product->sku = $data['sku'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->points = $data['points'];
            $product->updated_by = Auth::user()->id;
            $product->updated_at = Carbon::now();
            $product->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }
        catch (Throwable $e) {
            DB::rollback();
        }
    }


    public function archiveProduct($uuid){
        DB::beginTransaction();
        try {
            $product  = Product::where('uuid',$uuid)->first();
            $product->archived_by = Auth::user()->id;
            $product->archived_at = Carbon::now();
            $product->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }
        catch (Throwable $e) {
            DB::rollback();
        }
    }
}
