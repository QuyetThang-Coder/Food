<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/category.php';  ?>
<?php include_once '../classes/product.php';  ?>

<?php 
  $category = new category;
  $product = new product;
  if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['save']) ) {

		$insertProduct = $product->insert_product($_POST,$_FILES);
	}

  if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['addcategory']) ) {

		$insertCategory = $category->insert_category($_POST);
	}
?>

<script src="js/admin/san_pham_add.js"></script>
<link rel="stylesheet" href="css/san_pham_add.css">
<style>
  .qlsp {
    background: #c6defd;
    text-decoration: none;
    color: rgb(22 22 72);
    box-shadow: none;
    border: 1px solid rgb(22 22 72);
  }
</style>
  <main class="app-content">
    <div class="app-title">
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="QL_SanPham.php">Danh sách sản phẩm</a></li>
        <li class="breadcrumb-item"><a href="#">Thêm sản phẩm</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Tạo mới sản phẩm</h3>
          <div class="tile-body">
            <div class="row element-button">
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#adddanhmuc"><i
                    class="fas fa-folder-plus"></i> Thêm danh mục</a>
              </div>
            </div>
            <form class="row" method="POST" enctype="multipart/form-data">
              <div class="form-group col-md-12">
                <?php 
                  if (isset($insertProduct)) {
                    echo $insertProduct;
                  }
                  if (isset($insertCategory)) {
                    echo $insertCategory;
                  }
                ?>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Mã sản phẩm </label>
                <input class="form-control" type="number" readonly placeholder="">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Tên sản phẩm</label>
                <input class="form-control" type="text" required autocomplete="off" name="product_name">
              </div>
              <div class="form-group col-md-3">
                <label for="exampleSelect1" class="control-label">Danh mục</label>
                <select class="form-control" id="exampleSelect1" name="category">
                  <?php 
                    $show_category = $category -> show_category();
                    if (isset($show_category)) {
                      while ($result = $show_category -> fetch_assoc()) {
                        echo '<option value="'.$result['category_id'].'">'.$result['category_name'].'</option>';
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Giá bán</label>
                <input class="form-control" type="text" required autocomplete="off" name="product_price">
              </div>
              <div class="form-group col-md-12">
                <label class="btn-upload">
                  <label class="control-label">Ảnh sản phẩm</label> <br>
                  <div id="displayImg"></div>
                  <input type="file" onchange="ImagesFileAsURL()" name="image" id="upload">
                  <button id="btn"  class="btn">Chọn ảnh</button>
                </label>
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Mô tả sản phẩm</label>
                <textarea class="form-control" name="product_describe" required autocomplete="off" id="mota"></textarea>
              </div>
              <button class="btn btn-save" style="margin-left: 10px; margin-right: 10px" name="save">Lưu lại</button>
              <a class="btn btn-cancel" href="QL_SanPham.php">Hủy bỏ</a>
            </form>
          </div>
        </div>
  </main>

  <!--
  MODAL DANH MỤC
-->
  <div class="modal fade" id="adddanhmuc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <form action="" method="POST">
            <div class="row">
              <div class="form-group  col-md-12">
                <span class="thong-tin-thanh-toan">
                  <h5>Thêm mới danh mục </h5>
                </span>
              </div>
              <div class="form-group  col-md-12">
                
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Nhập tên danh mục mới</label>
                <input class="form-control" type="text" required name="category_name">
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Danh mục sản phẩm hiện đang có</label>
                <ul style="padding-left: 20px;">
                  <?php
                    $show_category_add = $category -> show_category();
                    if (isset($show_category_add)) {
                      while ($result = $show_category_add -> fetch_assoc()) {
                  ?>
                    <li><?php echo $result['category_name'] ?></li>
                  <?php } } ?>
                </ul>
              </div>
            </div>
            <BR>
            <button class="btn btn-save" name="addcategory">Lưu lại</button>
            <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
            <BR>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--
MODAL
-->





  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/plugins/pace.min.js"></script>
  <script>
    const inpFile = document.getElementById("inpFile");
    const loadFile = document.getElementById("loadFile");
    const previewContainer = document.getElementById("imagePreview");
    const previewContainer = document.getElementById("imagePreview");
    const previewImage = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");
    inpFile.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        previewDefaultText.style.display = "none";
        previewImage.style.display = "block";
        reader.addEventListener("load", function () {
          previewImage.setAttribute("src", this.result);
        });
        reader.readAsDataURL(file);
      }
    });

  </script>


  <!-- image -->
  <script>
    function ImagesFileAsURL() {
      var fileSelected = document.getElementById('upload').files;
      if (fileSelected.length > 0) {
        var fileToLoad = fileSelected[0];
        var fileReader = new FileReader();
        fileReader.onload = function(fileLoaderEvent) {
            var srcData = fileLoaderEvent.target.result;
            var newImage = document.createElement('img');
            newImage.src = srcData;
            document.getElementById('displayImg').innerHTML = newImage.outerHTML;
        }
        fileReader.readAsDataURL(fileToLoad);
      }
    }
  </script>
</body>

</html>