<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UserRegistrationComponent extends Component
{


    public $state =[
        'username'=>'',
        'fullname'=>'',
        'email'=>'',
        'address'=>'',
        'province'=>0,
        'city'=>0,
        'stockist_type'=>4,
        'password'=>'',
        'c_password'=>'',
        'contact_number'=>''];

    protected $userService ;

    public  function __construct($id = null)
    {
        parent::__construct($id);

        $this->userService =  New UserService();
    }



    public function submit(){
        dd('test');

    }
    private function validateAndSave($input){
      Validator::make($input, [
            "username"=>['required'],
            "fullname"=>['required',"numeric",'min:1'],
            "email" => ['required','date','after_or_equal:date_start'],
            "address" => ['required','date','before_or_equal:date_end'],
            "province" => ['required'],
            "contact_number" => ['required'],
            "stockist_type" => ['required'],
            "city" => ['required'],
            "password" => ['required'],
            "c_password" => ['required'],

        ])->validateWithBag('submitPoll');

       $user =  $this->userService->registerUser($input);
       if($user){
            return true;
       }
       return false;


    }
    private function resetForm(){
        $this->state['username'] = '';
        $this->state['fullname'] = '';
        $this->state['email'] = '';
        $this->state['address']='';
        $this->state['contact_number']='';
        $this->state['province']='';
        $this->state['stockist_type']='';
        $this->state['city']='';
        $this->state['password']='';
        $this->state['c_password']='';
    }
    public function render()
    {
        return view('livewire.user-registration-component');
    }


}
