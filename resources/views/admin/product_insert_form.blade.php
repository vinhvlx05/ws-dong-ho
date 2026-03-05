@include('admin/template/header')
<div class="row">
  <h2>Thêm sản phẩm</h2>

  <form action="/admin/xu-ly-them-san-pham" method="post" enctype="multipart/form-data">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <label for="fname">Tên:</label><br>
    <input type="text" id="fname" name="name" value="" required><br>
    <label for="fprice">Giá:</label><br>
    <input type="number" id="fprice" name="price" value="" required><br>
    <label for="fimg">Ảnh:</label><br>
    <input type="file" id="fimg" name="img" value="" required><br>
    <label for="lcategory">Danh mục:</label><br>
    <select id="lcategory" name="category">
      @foreach ($categories as $category)
        <option value="{{$category->category_id}}">{{$category->category_name}}</option>
      @endforeach
    </select><br>
    <label for="ldescription">Chi tiết:</label><br>
    <textarea id="ldescription" name="description" value="" cols="50"rows="10"></textarea><br><br>
    <input type="submit" value="Thêm">
  </form> 
</div>


@include('admin/template/footer')