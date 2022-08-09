<?php include './inc/header.php'; ?>


<?php 
    $category = new category;
    $product = new product;
    if (!isset($_GET['product_id']) || $_GET['product_id'] == NULL || !isset($_GET['category_id']) || $_GET['category_id'] == NULL) {
		echo "<script>window.location = '404.php'</script>";
	} else {
        $product_id = $_GET['product_id'];
        $category_id = $_GET['category_id'];
    }
?>

<?php 

    if ($login_check == false) {
        if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['addcart']) ) {
            echo    "<script>
                        window.onload = function () {
                            swal({
                                title: 'Thất bại',
                                text: 'Vui lòng đăng nhập để mua hàng',
                                icon: 'error',
                                button: 'Cancel',
                              })
                        }
                    </script>";
        }
    } else {
        if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['addcart']) ) {
            $quantity = $_POST['product_quantity'];
            $addcart = $cart -> addtocart($quantity,Session::get("userId"),$product_id);
        }
    }
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="css/swiper.css">
<div id="detail">
    <div class="detail laptop_pc">
        <div class="grid wide">
            <div class="row detail_box">
                <div class="detail_left col l-9 m-9">
                    <?php
                        $product_detail = $product -> getproductbyid_detail($product_id);
                        if(isset($product_detail)) {
                            while($result = $product_detail -> fetch_assoc()) {
                    ?>
                    <div class="row detail_left_box">
                        <div class="col l-5 m-5 detail_left_img">
                            <img src="admin/uploads/<?php echo $result['product_image'] ?>" alt="<?php echo $result['product_name'] ?>">
                            <!-- <div>
                                <img src="" alt="">
                            </div>
                            <div>
                                <img src="" alt="">
                            </div> -->
                        </div>
                        <div class="col l-7 m-7 detail_left_content">
                            <form action="" method="POST">
                                <div class="detail_left_content_box">
                                    <div class="detail_name">
                                        <h3><?php echo $result['product_name'] ?></h3>
                                    </div>
                                    <div class="detail_describe">
                                        <h3>Mô tả ngắn: 
                                            <p><?php echo $result['product_describe'] ?></p>
                                        </h3>
                                    </div>
                                    <div class="detail_price">
                                        <h3>Giá: 
                                            <p><?php echo number_format($result['product_price']) ?></p>
                                            vnđ
                                        </h3>
                                    </div>
                                    <div class="detail_quantity">
                                        <button class="minus is-form" type="button">-</button>
                                        <input type="number" aria-label="quantity" class="input_quantity" name="product_quantity" readonly max="999"  min="1" value="1">
                                        <button class="plus is-form" type="button">+</button>
                                    </div>
                                    <div class="detail_submit">
                                        <input type="submit" value="Thêm vào giỏ hàng" name="addcart">
                                    </div>
                                    <?php 
                                        if(isset($addcart) && $addcart == '1') {
                                            echo "<script>location.reload();</script>";
                                        } if(isset($addcart) && $addcart != '1') {
                                            echo $addcart;
                                        }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
                <div class="detail_right col l-3 m-3">
                    <div class="detail_right_box">
                        <div class="detail_category">
                            <h3>Danh mục sản phẩm</h3>
                        </div>
                        <div class="detail_category_detail">
                            <ul>
                                <a href="product.php"><li>Tất cả</li></a>
                                <?php
                                    $show_category = $category -> getallcategory();
                                    if (isset($show_category)) {
                                        while ($result_category = $show_category -> fetch_assoc()) {
                                ?>
                                    <a href="product.php?category_id=<?php echo $result_category['category_id'] ?>"><li><?php echo $result_category['category_name'] ?></li></a>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="detail_bottom col l-12 m-12">
                    <div class="heading heading_margin">
                        <h3>Sản phẩm tương tự</h3>
                    </div>
                    <form action="" method="POST">
                        <div class="swiper mySwiper detail_bottom_product l-12 m-12">
                            
                            <div class="swiper-wrapper detail_bottom_content">
                                <?php
                                    $similar_product = $product -> product_similar($category_id);
                                    if (isset($similar_product)) {
                                        while ($result_similar = $similar_product -> fetch_assoc()) {
                                ?>
                                    <div class='swiper-slide'>
                                        <div class="detail_item_product_content">
                                            <a href='productdetail.php?product_id=<?php echo $result_similar['product_id'] ?>&category_id=<?php echo $result_similar['category']?>'><img src='admin/uploads/<?php echo $result_similar['product_image'] ?>' alt='<?php echo $result_similar['product_name'] ?>'></a>
                                            <a href='productdetail.php?product_id=<?php echo $result_similar['product_id'] ?>&category_id=<?php echo $result_similar['category']?>'><h3><?php echo $result_similar['product_name'] ?></h3></a>
                                            <p><?php echo number_format($result_similar['product_price']); ?> vnđ</p>
                                            <!-- <input type='submit' name='gio-hang7' value='Thêm vào giỏ hàng'> -->
                                            <a href="productdetail.php?product_id=<?php echo $result_similar['product_id'] ?>&category_id=<?php echo $result_similar['category']?>" class="detail_input">Xem chi tiết</a>
                                        </div>
                                    </div>
                                <?php } } ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="js/swiper-4.js"></script>
<!-- Quantity -->
<script src="js/quantity.js"></script>
<?php include './inc/footer.php'; ?>
