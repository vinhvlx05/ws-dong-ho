@include('admin/template/header')
<div class="row">
    <h2>Thêm tài khoản người dùng</h2>

    <form action="/admin/xu-ly-them-nguoi-dung" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <label for="fname">Tài khoản:</label><br>
      <input type="text" id="fname" name="username" value="" required><br>
      <label for="fpass">Mật khẩu:</label><br>
      <input type="password" id="fpass" name="password" value="" required><br>
      <label for="lname">Họ tên:</label><br>
      <input type="text" id="lname" name="fullname" value="" required><br><br>
      <label for="laddress">Địa chỉ:</label><br>
      <input type="text" id="laddress" name="address" value="" required><br><br>
      <label for="lrole">Quyền: </label><br>
      <select name="role" id="lrole" required class="col-lg-1">
        <option>1</option>
        <option>0</option>
      </select><br><br>
      <input type="submit" value="Đăng ký">
    </form> 
</div>
@include('admin/template/footer')
