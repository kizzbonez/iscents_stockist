<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Validation\Rule;
class UsersController extends Controller
{

    protected  $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->userService = New UserService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $you = auth()->user();
        $users = User::all();
        return view('dashboard.admin.usersList', compact('users', 'you'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.admin.userShow', compact( 'user' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('dashboard.admin.userEditForm', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256'
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        $user->save();
        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }


    public function getuserInfoAction(){
        $pageData =array();
        $pageData['title']= 'My Profile';
        $userInfo =  Auth::user();
        return view('user.userprofile', compact('userInfo','pageData'));
    }

    public function changePasswordAction(Request $request)
    {
        session()->forget(['error','success']);
        $pageData = array();
        $pageData['title'] = 'Change Password';

        if($request->method() == 'POST'){
            $validator =   Validator::make($request->all(), [
                "password" => ['required',
                    'max:30',
                    'string',
                    'min:8',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/'], // must contain a special character,'confirmed'],
                "password_confirmation" => ['required'],
            ],[
                'password.regex'=>'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
            ]);

            if(!$validator->fails()){
                $this->userService->updateUserPassword($request->all(),Auth::user()->id);
                session()->flash('success','User Password has been Updated Successfully');

            }else{
                $messages = $validator->errors()->all();
                session()->flash('error',$messages);

            }


        }

        return view('user.changepassword', compact('pageData'));

    }


}
