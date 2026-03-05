<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function insert_form() {
        return view('admin/category_insert_form');
    }
    public function action_insert(Request $request){
        // $request->validate([
        //     'name' => 'required|string|max:255'
        // ]);
        $name = $request->input('name'); 
        $result=[
            'category_name'=>$name
                ];
                CategoryModel::insert($result);
        return redirect()->to('admin/danh-sach-danh-muc');
    }
    public function action_update(Request $request) {
        $name = $request->input('name');
        $id = $request->input('id');
        $result=['category_name'=>$name];
        CategoryModel::where('category_id', $id)->update($result);
        return redirect()->to('admin/danh-sach-danh-muc');
    }
    public function get_all(){
        $categories = CategoryModel::all();
        return view('admin/category_list',['categories'=>$categories]);
    }
    public function del($id){
        CategoryModel::where('category_id', $id)->delete();
        return redirect()->to('admin/danh-sach-danh-muc');
    }
    public function show ($id) {
        $categories = CategoryModel::where('category_id', $id)->get();
        return view('admin/category_info_form',['categories'=>$categories]);
    }
}
    
