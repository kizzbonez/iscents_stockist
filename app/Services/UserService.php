<?php


namespace App\Services;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(){

    }

    public function getUserById($id){
        return  User::find($id);
    }

    public function registerUser($data){
        DB::beginTransaction();
        try {
                $user  = new User();
                $user->name = $data['name'];
                $user->email = $data['address'];
                $user->city = $data['city'];
                $user->province = $data['province'];
                $user->address = $data['address'];
                $user->password = $data['password'];
                $user->menuroles = 'user';
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

    public function updateUser($data,$userId){
        DB::beginTransaction();
        try {
            $user  = $this->getUserById($userId);
            $user->name = $data['name'];
            $user->email = $data['address'];
            $user->city = $data['city'];
            $user->province = $data['province'];
            $user->address = $data['address'];
            $user->password = $data['password'];
            $user->menuroles = 'user';
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
