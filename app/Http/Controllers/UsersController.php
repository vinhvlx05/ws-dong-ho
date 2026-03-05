<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function showLogin(){
        if(session()->has('user')){
            return redirect('/trang-chu');
        }
        return view ('/login');
    }

    public function login(Request $request){
        $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if ($user::check($request->password, $user->password)){
            session([
                'user'=> [
                    'id'=> $user->id,
                    'username'=>$user->username,
                    'email'=>$user->email,
                ]
            ]);
        }
        return redirect('/trang-chu')->with('success', 'đăng nhập thành công! chào mừng'.$user->username);
    }

    public function showRegister(){
        if(session()->has('user')){
            return redirect('/trang-chu');
        }
        return view('register');
    }
    
}