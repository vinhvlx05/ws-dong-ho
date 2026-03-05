<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\CategoryModel;
class ProductController extends Controller
{
    public function insert_form(){
        $categories=CategoryModel::all();
        return view('admin/product_insert_form',['categories'=>$categories]);
    }
    public function action_insert(Request $request){
        $name = $request->input('name'); 
        $price = $request->input('price'); 
        $description = $request->input('description'); 
        
        if ($request->hasFile('img')) {
            $request->file('img')->move('img', $request->file('img')->getClientOriginalName());
            $img_name='img/'.$request->file('img')->getClientOriginalName();
        }
        $category=$request->input('category');
        $result=['product_name'=>$name,
                    'product_img'=>$img_name,
                    'product_price'=>$price,
                    'product_category'=>$category,
                    'product_description'=>$description];
        ProductModel::insert($result);
        return redirect()->to('admin/danh-sach-san-pham');
    }
    public function action_update(Request $request){
        $name = $request->input('name'); 
        $price = $request->input('price'); 
        $description = $request->input('description'); 
        $id=$request->input('id');
        if ($request->hasFile('img')) {
            $request->file('img')->move('img', $request->file('img')->getClientOriginalName());
            $img_name='img/'.$request->file('img')->getClientOriginalName();
        }
        else
            $img_name=$request->input('img_old');
        $category=$request->input('category');
        $result=['product_name'=>$name,
                    'product_img'=>$img_name,
                    'product_price'=>$price,
                    'product_category'=>$category,
                    'product_description'=>$description];
        ProductModel::where('product_id',$id)->update($result);
        return redirect()->to('admin/danh-sach-san-pham');
    }
    public function get_all(){
        $products=ProductModel::join('category','product_category' , '=', 'category_id')->get();
        return view('admin/product_list',['products'=>$products]);
    }
    public function del($id){
        $products=ProductModel::where('product_id',$id)->delete();
        return redirect()->to('admin/danh-sach-san-pham');
    }
    public function show($id){
        $products=ProductModel::join('category','product_category' , '=', 'category_id')->where('product_id',$id)->get();
        $categories=CategoryModel::all();
        return view('admin/product_info_form',['products'=>$products,'categories'=>$categories]);
    }
}
