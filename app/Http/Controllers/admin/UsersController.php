<?php

namespace App\Http\Controllers\admin;


use App\Constants\StockistConstants;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected  $userService;
    public function __construct()
    {
        $this->middleware('auth');
        $this->userService = New UserService();
    }

    /**
     * Show the users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        session()->forget(['error','success']);
        $you = auth()->user();
        $users = User::all();
        $pageData = array();
        $pageData['title'] = 'Users';

        return view('admin.userlist', compact('users', 'you','pageData'));
    }

    /**
     *  Remove user
     *
     *  @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function remove( $id )
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('adminUsers');
    }

    /**
     *  Show the form for editing the user.
     *
     *  @param int $id
     *  @return \Illuminate\Contracts\Support\Renderable
     */
    public function editForm( $id )
    {
        $user = User::find($id);
        return view('dashboard.admin.userEditForm', compact('user'));
    }

    /**
     * User Info  View/Edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userInfoAction(Request $request)
    {
        session()->forget(['error','success']);
        $pageData = array();
        $pageData['title'] = 'New User';
        $userInfo = $request->all();
        if($request->method() == 'POST'){
            $userInfo = $request->all();
            $validator =   Validator::make($request->all(), [
                "username"=>['required','unique:users_stockist','min:6','max:255'],
                "name"=>['required','max:255'],
                "email" => ['required','email','max:255'],
                "address" => ['required','max:255'],
                "province" => ['required','numeric','exists:philippine_provinces,id'],
                "contact_number" => ['required','max:255'],
                "stockist_type" => ['required','numeric', Rule::in([2,3,4])],
                "city" => ['required','numeric','exists:philippine_cities,id'],
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
                "stockist_type.in"=>"Stockist Type is not available",
                'password.regex'=>'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'


            ]);

            if(!$validator->fails()){
                $user =  $this->userService->registerUser($request->all());
                session()->flash('success','Added User Successfully');
                $userInfo= $this->cleanUserInfo($userInfo);

            }else{
                $messages = $validator->errors()->all();
                session()->flash('error',$messages);

            }

        }

        return view('admin.userinfo',['pageData'=>$pageData,'userInfo'=>$userInfo ]);

    }

    /**
     * Reset User Info Value
     *
     * @param  array $userInfo
     * @return array
     */
    private function cleanUserInfo(array $userInfo = null){
        foreach ($userInfo as $key => $value){
            $userInfo[$key] = null;

        }
        return $userInfo;
    }

    /**
     * getAllUsers
     *
     * @param  array $userInfo
     * @return array
     */
    public function getusersAction(array $userInfo = null){
        $users = User::where('id','!=',Auth::user()->id)->get();
        $pageData = array();
        $pageData['title'] = 'Users';
        $array=array();
        $array['draw']=1;
        $array['recordsTotal']=$users->count();
        $array['recordsFiltered']=$users->count();
        $array['data']= array();

        foreach($users as $key=>$value)
        {
            $ActionElements ='<a target="_blank"  class="btn btn-default" href="'.route('admin.user.update',['id'=>$value->id]).'" title="Edit"><i class="fas fa-user-edit"></i></a>
                                      <a target="_blank" class="btn btn-default" href="'.route('admin.user.update.password',['id'=>$value->id]).'" title="Change Password"><i class="fas fa-lock"></i></a>
                              ' ;
            $array['data'][] = array(
                $value->username,
                $value->name,
                $value->email,
                $value->menuroles,
                StockistConstants::USER_TYPES[$value->stockist_type_id],
                Carbon::parse($value->created_at)->format(StockistConstants::GMT_DATE_FORMAT),
                $ActionElements);
        }
        return $array;
    }
    /**
     * Update User
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserInfoAction(Request $request,$id)
    {
        session()->forget(['error','success']);
        $pageData = array();
        $pageData['title'] = 'Update User';
        $user= $this->userService->getUserById($id);
        $userInfo = array();
        if(CommonHelper::isNotNullOrEmpty($user)){
            $pageData['title']  .= ': '.$user->username;
            $userInfo = CommonHelper::userInfoToFormData($user);
        }
        if($request->method() == 'POST'){
            $userInfo = $request->all();
            $validator =   Validator::make($request->all(), [
                "username"=>['required','unique:users_stockist,username,'.$id,'min:6','max:255'],
                "name"=>['required','max:255'],
                "email" => ['required','email','max:255'],
                "address" => ['required','max:255'],
                "province" => ['required','numeric','exists:philippine_provinces,id'],
                "contact_number" => ['required','max:255'],
                "stockist_type" => ['required','numeric', Rule::in([2,3,4])],
                "city" => ['required','numeric','exists:philippine_cities,id'],
            ],[
                "stockist_type.in"=>"Stockist Type is not available"

            ]);

            if(!$validator->fails()){
                $this->userService->updateUser($request->all(),$user->id);
                session()->flash('success','User Information has been Updated Successfully');

            }else{
                $messages = $validator->errors()->all();
                session()->flash('error',$messages);

            }


        }

        return view('admin.userinfo',['pageData'=>$pageData,'userInfo'=>$userInfo ]);

    }

    /**
     * Update User Password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserPasswordAction(Request $request,$id)
    {
        session()->forget(['error','success']);
        $pageData = array();
        $pageData['title'] = 'Change Password';
        $user= $this->userService->getUserById($id);
        $userInfo = array();
        if(CommonHelper::isNotNullOrEmpty($user)){
            $pageData['title']  .= ': '.$user->username;
            $userInfo = CommonHelper::userInfoToFormData($user);
        }
        if($request->method() == 'POST'){
            $userInfo = $request->all();
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
                $this->userService->updateUserPassword($request->all(),$user->id);
                session()->flash('success','User Password has been Updated Successfully');

            }else{
                $messages = $validator->errors()->all();
                session()->flash('error',$messages);

            }


        }

        return view('admin.changepassword',['pageData'=>$pageData,'userInfo'=>$userInfo ]);

    }






}
