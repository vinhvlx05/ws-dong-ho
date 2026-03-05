<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function insert_form(){
        return view('admin/user_insert_form');
    }
    public function action_insert(Request $request){
        $name = $request->input('username'); 
        $password = $request->input('password'); 
        $fullname = $request->input('fullname'); 
        $address = $request->input('address'); 
        $role = $request->input('role'); 
        $result=['user_username'=>$name,
                    'user_password'=>$password,
                    'user_fullname'=>$fullname,
                    'user_address'=>$address,
                    'user_role'=>$role];
        Users::insert($result);
        return redirect()->to('admin/danh-sach-nguoi-dung');
    }
    public function action_update(Request $request){
        $name = $request->input('username'); 
        $id = $request->input('id'); 
        $fullname = $request->input('fullname'); 
        $address = $request->input('address'); 
        $role = $request->input('role');
        $result=['user_username'=>$name,
                    'user_fullname'=>$fullname,
                    'user_address'=>$address,
                    'user_role'=>$role];
        Users::where('user_id',$id)->update($result);
        return redirect()->to('admin/danh-sach-nguoi-dung');
    }
    public function get_all(){
        $users=Users::all();
        return view('admin/user_list',['users'=>$users]);
    }
    public function del($id){
        $users=Users::where('user_id',$id)->delete();
        return redirect()->to('admin/danh-sach-nguoi-dung');
    }
    public function show($id){
        $users=Users::where('user_id',$id)->get();
        return view('admin/user_info_form',['users'=>$users]);
    }

    public function login() {
        return view ('admin/login');
    }

    public function logout(){
        session()->forget('user');
        //$request->session()->flush();
        return redirect()->to('admin/danh-sach-nguoi-dung');
    }

    public function action_login(Request $request) {
        $name = $request->input('username');
        $pswd = $request->input('pswd');
        $user=Users::where('user_username',$name)->where('user_password',$pswd)->where('user_role',1)->first();
        if($user){
            $sessions = Session::put("user", [['id' => $user->user_id, 'username' => $user->user_username]]);
            return redirect()->to('admin/danh-sach-nguoi-dung');
        }
    }
}
