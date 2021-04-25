<?php


namespace App\Services;


use App\Models\User;

class UserService
{
    public function __construct(){

    }

    public function getUserById($id){
        return  User::find($id);
    }

    public function registerUser($data){


    }

    public function updateUser($data){

    }
    public function unarchiveOrArchiveUser($status,$id){

    }
}
