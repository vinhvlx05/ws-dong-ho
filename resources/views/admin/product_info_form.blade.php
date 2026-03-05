@include('admin/template/header')

<div class="row">
  <h2>Cập nhật sản phẩm</h2>

  <form action="/admin/xu-ly-cap-nhat-san-pham" method="post" enctype="multipart/form-data">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      @foreach ($products as $product)
    <label for="fname">Tên:</label><br>
    <input type="text" id="fname" name="name" value="{{ $product->product_name}}" required><br>
    <label for="fprice">Giá:</label><br>
    <input type="number" id="fprice" name="price" value="{{ $product->product_price}}" required><br>
    <label for="lcategory">Danh mục:</label><br>
    <select id="lcategory" name="category">
      @foreach ($categories as $category)
        <option value="{{$category->category_id}}"<?php if($category->category_id==$product->product_category) echo"selected";?>>{{$category->category_name}}</option>
      @endforeach
    </select><br>
    <label for="limg">Ảnh:</label><br>
    <input type="file" id="limg" name="img" value=""><br><br>
    <input type="hidden" id="limg_old" name="img_old" value="{{ $product->product_img}}" required>
    <label for="ldescription">Mô tả:</label><br>
    <textarea id="ldescription" name="description" cols='100' rows='8'>
      {{ $product->product_description}}</textarea><br><br>
    <input type="hidden" id="fid" name="id" value="{{ $product->product_id}}" required><br>
    @endforeach
    <input type="submit" value="Cập nhật">
  </form> 
</div>
@include('admin/template/footer')

