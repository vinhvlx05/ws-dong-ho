@include('admin/template/header')
<div class="row">
<h2>Thay đổi danh mục</h2>

<form action="/admin/xu-ly-cap-nhat-danh-muc" method="post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    @foreach ($categories as $category)
  <label for="fname">Tên:</label><br>
  <input type="text" id="fname" name="name" value="{{ $category->category_name}}" required><br>
  
  <input type="hidden" id="fid" name="id" value="{{ $category->category_id}}" required><br>
  @endforeach
  <input type="submit" value="Cập nhật">
</div>
@include('admin/template/footer')
