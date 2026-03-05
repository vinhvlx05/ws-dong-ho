@include('admin/template/header')
<div class="row">
    <h2>Thêm Danh Mục</h2>

    <form action="/admin/xu-ly-them-danh-muc" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <label for="fname">Danh Mục:</label><br>
      <input type="text" id="fname" name="name" required><br>
      <input type="submit" value="Thêm">
    </form> 
</div>
@include('admin/template/footer')
