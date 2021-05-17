<?php


namespace App\Services;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'email_verified_at' => now(),
                'city' => $data['city'],
                'province' => $data['province'],
                'address' => $data['address'],
                'contact_number' => $data['contact_number'],
                'stockist_type_id' => $data['stockist_type'],
                'password' => bcrypt($data['password']), // password
                'remember_token' => Str::random(10),
                'menuroles' => 'user'
            ]);
            $user->assignRole('user');
                DB::commit();
                return $user;
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
