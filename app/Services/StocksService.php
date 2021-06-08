<?php


namespace App\Services;


use App\Helpers\CommonHelper;
use App\Models\Product;
use App\Models\Stocks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StocksService
{
    public function __construct(){

    }


    public function addStockTransactionUser($productId,$orderId=null,$qty = 0,$from=null,$to=null,$trans_type = 0,$remarks=null){
        DB::beginTransaction();
        try {

            if(CommonHelper::isNotNullOrEmpty($productId)){
                $stocks = Stocks::create([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'qty' => $qty,
                    'from_id' => $from,
                    'to_id' => $to,
                    'trans_type' => $trans_type,
                    'remarks' => $remarks,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                DB::commit();

                return $stocks;
            }
            return null;

        } catch (Exception $e) {
            DB::rollback();
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        catch (Throwable $e) {
            DB::rollback();
        }
    }

    public function updateUser($data,$userId){
        DB::beginTransaction();
        try {
            $user  = $this->getUserById($userId);
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->city = $data['city'];
            $user->province = $data['province'];
            $user->address = $data['address'];
            $user->stockist_type_id = $data['stockist_type'];
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        catch (Throwable $e) {
            DB::rollback();
        }
    }

    public function updateUserPassword($data,$userId){
        DB::beginTransaction();
        try {
            $user  = $this->getUserById($userId);
            $user->password = Hash::make($data['password']);
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        catch (Throwable $e) {
            DB::rollback();
        }
    }

    public function unarchiveOrArchiveUser($isArchive = false,$userId){
        DB::beginTransaction();
        try {
            $date = ($isArchive) ? null: Carbon::now()  ;
            $user  = $this->getUserById($userId);
            $user->deleted_at = $date;
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        catch (Throwable $e) {
            DB::rollback();
        }
    }


}
