<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/category.php';  ?>
<?php include_once '../classes/product.php';  ?>

<?php 
    $category = new category;
    $product = new product;
    if (!isset($_GET['edit_product']) || $_GET['edit_product'] == NULL) {
		  echo "<script>window.location = 'QL_SanPham.php'</script>";
	  } else {
        $product_id = $_GET['edit_product'];
    }
    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['save']) ) {
        
        $updateProduct = $product->update_product($_POST,$_FILES,$product_id);
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
        <li class="breadcrumb-item"><a href="#">Sửa sản phẩm</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Sửa sản phẩm</h3>
          <div class="tile-body">
            <form class="row" method="POST" enctype="multipart/form-data">
              <div class="form-group col-md-12">
                <?php 
                  if (isset($updateProduct)) {
                    echo $updateProduct;
                  }
                ?>
              </div>
              <?php 
                $get_product = $product -> getproductbyid($product_id);
                if (isset($get_product)) {
                    while ($result_product = $get_product -> fetch_assoc()) {
                ?>
                
              <div class="form-group col-md-3">
                <label class="control-label">Mã sản phẩm </label>
                <input class="form-control" type="number" readonly placeholder="" value="<?php echo $result_product['product_id'] ?>" name="product_id">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Tên sản phẩm</label>
                <input class="form-control" type="text" required autocomplete="off" value="<?php echo $result_product['product_name'] ?>" name="product_name">
              </div>
              <div class="form-group col-md-3">
                <label for="exampleSelect1" class="control-label">Danh mục</label>
                <select class="form-control" id="exampleSelect1" name="category">
                  <?php 
                    $show_category = $category -> show_category();
                    if (isset($show_category)) {
                      while ($result_category = $show_category -> fetch_assoc()) {
                    ?>
                        <option
                            <?php if ($result_product['category'] == $result_category['category_id']) { echo 'selected'; } ?>
                                value="<?php echo $result_category['category_id']; ?>"><?php echo $result_category['category_name']; ?>
                        </option>;
                    <?php  } } ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Giá bán</label>
                <input class="form-control" type="text" required autocomplete="off" value="<?php echo $result_product['product_price'] ?>" name="product_price">
              </div>
              <div class="form-group col-md-12">
                <label class="btn-upload">
                  <label class="control-label">Ảnh sản phẩm</label> <br>
                  <div id="displayImg">
                    <img src="uploads/<?php echo $result_product['product_image'] ?>" alt="">
                  </div>
                  <input type="file" onchange="ImagesFileAsURL()" name="image" id="upload">
                  <button id="btn"  class="btn">Chọn ảnh</button>
                </label>
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Mô tả sản phẩm</label>
                <textarea class="form-control" name="product_describe" required autocomplete="off" id="mota"><?php echo $result_product['product_describe'] ?></textarea>
              </div>
              <button class="btn btn-save" style="margin-left: 10px; margin-right: 10px" name="save">Lưu lại</button>
              <a class="btn btn-cancel" href="QL_SanPham.php">Hủy bỏ</a>
              <?php } } ?>
            </form>
          </div>
        </div>
  </main>


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