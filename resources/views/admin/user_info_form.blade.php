@include('admin/template/header')
<div class="row">
<h2>Thay đổi tài khoản người dùng</h2>

<form action="/admin/xu-ly-cap-nhat-nguoi-dung" method="post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    @foreach ($users as $user)
  <label for="fusername">Tên:</label><br>
  <input type="text" id="fusername" name="username" value="{{ $user->user_username}}" required><br>
  <label for="laddress">Địa chỉ:</label><br>
  <input type="text" id="laddress" name="address" value="{{ $user->user_address}}" required><br><br>
  <label for="lfull">Họ tên:</label><br>
  <input type="text" id="lfullname" name="fullname" value="{{ $user->user_fullname}}" required><br><br>
  <label for="lrole">Quyền:</label><br>
  <select name="role" id="lrole" value="{{ $user->user_role}}" class="col-lg-1">
    <option>1</option>
    <option>0</option>
  </select><br><br>
  
  <input type="hidden" id="fid" name="id" value="{{ $user->user_id}}" required><br>
  @endforeach
  <input type="submit" value="Cập nhật">
</div>
@include('admin/template/footer')
