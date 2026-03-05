@include('admin/template/header')
   <div class="row">
      <table class="table table-striped">
         <tr><td colspan="5">Danh sách danh muc</td></tr>
         <tr><td colspan="3"></td><td  colspan="2"><a href="them-danh-muc">Thêm danh muc</a></td></tr>
         <tr>
            <td>ID</td>
            <td>Danh Mục</td>
            <td></td>
            <td></td>
         </tr>
         @foreach ($categories as $category)
         <tr>
            <td>{{$category->category_id}}</td>
            <td>{{ $category->category_name}}</td>
            
            <td><a href="thong-tin-danh-muc/{{ $category->category_id}}"><img src="{{ asset('admin/img/edit.png') }}" width='40'></a></td>
            <td><a href="xoa-danh-muc/{{ $category->category_id}}" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');"><img src="{{ asset('admin/img/delete.png') }}" width='40'></a></td>
         </tr>
         @endforeach
      </table>
   </div>
@include('admin/template/footer')
