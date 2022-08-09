<?php include './inc/header.php'; ?>

<?php
    $category = new category;
    if (isset($_GET['category_id']) && $_GET['category_id'] != NULL) {
        $category_id = $_GET['category_id'];
    }
?>

<link rel="stylesheet" href="css/page.css">
<style>
    .item_product_header {
        background-color: #ff4500 !important; 
        padding: 12px 24px 8px 24px !important;
    }
</style>
<div id="product">
    <div class="product laptop_pc">
        <div class="grid wide">
            <div class="row product_box">
                <!-- product left -->
                <div class="product_left col l-3 m-3">
                    <div class="product_left_box">
                        <div class="frm_search">
                            <input type="text" placeholder="Tìm kiếm...">
                            <i class="fa fal fa-search"></i>
                            <input type="submit" value="Tìm kiếm">
                        </div>
                        <div class="product_left_category">
                            <h3>Danh mục sản phẩm</h3>
                        </div>
                        <div class="product_left_detail">
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

                        <div class="product_left_category">
                            <h3>Sản phẩm mới nhất</h3>
                        </div>
                        <div class="product_left_botoom">
                            <?php 
                                $get_getproductnews = $product -> getproductnew4();
                                if($get_getproductnews) {
                                    while($result = $get_getproductnews -> fetch_assoc()) {
                            ?>
                                <div class="row product_left_botoom_content">
                                    <div class="image l-3 m-4">
                                        <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category']?>"><img src="admin/uploads/<?php echo $result['product_image'] ?>" alt="<?php echo $result['product_name'] ?>"></a>
                                    </div>
                                    <div class="content l-9 m-8">
                                        <div>
                                            <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category']?>"><h3><?php echo $result['product_name'] ?></h3></a>
                                            <p><?php echo number_format($result['product_price']); ?> vnđ</p>
                                        </div>
                                    </div>
                                </div>
                            <?php } } ?>
                        </div>

                        <div class="product_left_category">
                            <h3>Sản phẩm bán chạy</h3>
                        </div>
                        <div class="product_left_botoom">
                            <?php 
                                $get_product_sellings = $product -> product_selling();
                                if($get_product_sellings) {
                                    while($result = $get_product_sellings -> fetch_assoc()) {
                            ?>
                                <div class="row product_left_botoom_content">
                                    <div class="image l-3 m-4">
                                        <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category']?>"><img src="admin/uploads/<?php echo $result['product_image'] ?>" alt="<?php echo $result['product_name'] ?>"></a>
                                    </div>
                                    <div class="content l-9 m-8">
                                        <div>
                                            <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category']?>"><h3><?php echo $result['product_name'] ?></h3></a>
                                            <p><?php echo number_format($result['product_price']); ?> vnđ</p>
                                        </div>
                                    </div>
                                </div>
                            <?php } } ?>
                        </div>
                    </div>
    
                </div>
                <!-- product right -->
                <div class="product_right col l-9 m-9">
                    <div class="product_right_content">
                        <div class="  heading heading_margin">
                            <?php
                                if (isset($_GET['category_id']) && $_GET['category_id'] != NULL) { 
                                    $getcategorybyid = $category -> getcategorybyid($category_id);
                                    if (isset($getcategorybyid)) {
                                        while ($result_category = $getcategorybyid -> fetch_assoc()) {
                            ?>
                                <h3><?php echo $result_category['category_name'] ?></h3>
                            <?php } } } ?>
                            <?php if (!isset($_GET['category_id']) || $_GET['category_id'] == NULL) { ?>
                                <h3>Tất cả sản phẩm</h3>
                            <?php } ?>
                        </div>
                        <div class="san-pham  l-12 m-12">
                            <form action='' method='POST'>
                                <div class=" san-pham-content">
                                    <?php 
                                        if (isset($_GET['category_id']) && $_GET['category_id'] != NULL) {
                                            $get_product = $product -> product_similar_page($category_id);
                                            if (isset($get_product)) {
                                                while ($result_product = $get_product -> fetch_assoc()) {
                                    ?>
                                    <div class='item_product col l-3 m-4'>
                                        <div class="item_product_content">
                                            <a href='productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>'><img src='admin/uploads/<?php echo $result_product['product_image'] ?>' alt='<?php echo $result_product['product_name'] ?>'></a>
                                            <a href='productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>'><h3><?php echo $result_product['product_name'] ?></h3></a>
                                            <p><?php echo number_format($result_product['product_price']) ?> vnđ</p>
                                            <!-- <input type='submit' name='gio-hang7' value='Thêm vào giỏ hàng'> -->
                                            <a href="productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>" class="detail_input" class="detail_input">Xem chi tiết</a>
                                        </div>
                                    </div>
                                    <?php } } } ?>
                                    <?php 
                                        if (!isset($_GET['category_id']) || $_GET['category_id'] == NULL) {
                                            $get_product = $product -> getproduct();
                                            if (isset($get_product)) {
                                                while ($result_product = $get_product -> fetch_assoc()) {
                                    ?>
                                    <div class='item_product col l-3 m-4'>
                                        <div class="item_product_content">
                                            <a href='productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>'><img src='admin/uploads/<?php echo $result_product['product_image'] ?>' alt='<?php echo $result_product['product_name'] ?>'></a>
                                            <a href='productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>'><h3><?php echo $result_product['product_name'] ?></h3></a>
                                            <p><?php echo number_format($result_product['product_price']) ?> vnđ</p>
                                            <!-- <input type='submit' name='gio-hang7' value='Thêm vào giỏ hàng'> -->
                                            <a href="productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>" class="detail_input" class="detail_input">Xem chi tiết</a>
                                        </div>
                                    </div>
                                    <?php } } } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="page">
                        <ul class="pagination">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                        </ul>
                    </div> -->
                    <div class="page">
                        <ul class="pagination">
                            <?php 
                                if (!isset($_GET['category_id'])) {
                                    $product_all = $product -> getallproduct();
                                    $product_count = mysqli_num_rows($product_all);
                                    $product_button = ceil($product_count / 16);
                                    $i = 0;
                                    for ($i = 1; $i <= $product_button; $i++) {
                            ?>
                                <li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } } ?>
                            <?php 
                                if (isset($_GET['category_id']) && $_GET['category_id'] != NULL) { 
                                    $product_all = $product -> product_similar($category_id);
                                    $product_count = mysqli_num_rows($product_all);
                                    $product_button = ceil($product_count / 16);
                                    $i = 0;
                                    for ($i = 1; $i <= $product_button; $i++) {
                            ?>
                                <li><a href="?category_id=<?php echo $category_id ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } } ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php include './inc/footer.php'; ?>