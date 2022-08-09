<?php include './inc/header.php'; ?>
<?php include './inc/slider.php'; ?>


<style>
    .item_home {
        background-color: #ff4500 !important; 
        padding: 12px 20px 8px 20px !important;
    }
</style>
<div class="main">
    <div id="body">
        <!-- Banner -->
        <section class="banner laptop_pc">
            <div class="grid wide">
                <div class="row ">
                    <div class="banner-left">
                        <div class="banner__item " >
                            <span class="banner__link">
                                <img src="images/banner2-1.jpg" alt="" class="banner-img">
                            </span>
                            <div class="banner__text banner__text-1">
                                <span class="banner__text-engname">American <p>Pigga</p></span>
                                <p class="banner__text-vietname">pizza bò xào</p>
                            </div>
                        </div>
                    </div>
                    <div class="banner-right">
                        <div class="banner__item" > 
                            <span class="banner__link">
                                <img src="images/banner2-2.jpg" alt="" class="banner-img">
                            </span>
                            <div class="banner__text mg-l">
                                <span class="banner__text-engname">Asian<p class="banner__text-engname-p">Bread</p></span>
                                <p class="banner__text-vietname banner__text-vietname1">Bánh mì hảo hạng</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Body -->
        <div id="content" class="laptop_pc">
            <div class="grid wide">
                <div class="">
                    <div class="  heading heading_margin">
                        <h3>Sản phẩm bán chạy nhất</h3>
                        <!-- <p>(Mua càng nhiều giá càng rẻ)</p> -->
                    </div>
                    <div class="san-pham  l-12 m-12">
                        <form method="POST" action="" class=" san-pham-content">
                            <?php 
                                $get_product_sellings = $product -> product_selling();
                                if($get_product_sellings) {
                                    while($result = $get_product_sellings -> fetch_assoc()) {
                            ?>
                                <div class='item_product col l-3 m-3'>
                                    <div class="item_product_content">
                                        <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category']?>"><img src='admin/uploads/<?php echo $result['product_image'] ?>' alt='<?php echo $result['product_name'] ?>'></a>
                                        <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category']?>"><h3><?php echo $result['product_name'] ?></h3></a>
                                        <p><?php echo number_format($result['product_price']); ?> vnđ</p>
                                        <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category']?>" class="detail_input">Xem chi tiết</a>
                                    </div>
                                </div>
                            <?php } } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content bottom -->
        <div id="content_botoom" class="laptop_pc">
            <div class="grid wide">
                <div class="">
                    <div class="  heading heading_margin">
                        <h3>SẢN PHẨM MỚI</h3>
                    </div>
                    <div class="san-pham  l-12 m-12">
                        <div class=" san-pham-content">
                            <?php 
                                $get_productnew = $product -> getproductnew4();
                                if (isset($get_productnew)) {
                                    while ($result_product = $get_productnew -> fetch_assoc()) {
                            ?>
                                <div class='item_product col l-3 m-3'>
                                    <div class="item_product_content">
                                        <a href='productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>'><img src='admin/uploads/<?php echo $result_product['product_image'] ?>' alt='<?php echo $result_product['product_name'] ?>'></a>
                                        <a href='productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>'><h3><?php echo $result_product['product_name'] ?></h3></a>
                                        <p><?php echo number_format($result_product['product_price']) ?> vnđ</p>
                                        <!-- <input type='submit' name='addcart' value='Xem chi tiết'> -->
                                        <a href="productdetail.php?product_id=<?php echo $result_product['product_id'] ?>&category_id=<?php echo $result_product['category']?>" class="detail_input">Xem chi tiết</a>
                                    </div>
                                </div>
                            <?php } } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

<!-- Footer -->
<?php include './inc/footer.php'; ?>