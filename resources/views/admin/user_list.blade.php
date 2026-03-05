@include('admin/template/header')
   <div class="row">
      <table class="table table-striped">
         <tr><td colspan="5">Danh sách người dùng</td></tr>
         <tr><td colspan="3"></td><td  colspan="2"><a href="them-nguoi-dung">Thêm người dùng</a></td></tr>
         <tr>
            <td>Tài khoản</td>
            <td>Họ tên</td>
            <td>Địa chỉ</td>
            <td></td>
            <td></td>
         </tr>
         @foreach ($users as $user)
         <tr>
            <td>{{ $user->user_username}}</td>
            <td>{{ $user->user_fullname}}</td>
            <td>{{ $user->user_address}}</td>
            <td>{{ $user->user_role}}</td>
            <td><a href="thong-tin-nguoi-dung/{{ $user->user_id}}"><img src="{{ asset('admin/img/edit.png') }}" width='40'></a></td>
            <td><a href="xoa-nguoi-dung/{{ $user->user_id}}"><img src="{{ asset('admin/img/delete.png') }}" width='40'></a></td>
         </tr>
         @endforeach
      </table>
   </div>
@include('admin/template/footer')
