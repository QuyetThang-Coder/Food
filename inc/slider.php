
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    var i = 1;
    changeImage = function () {
        var imgs = ["images/slider1-1.jpg","images/slider2-1.jpg","images/slider3-1.jpg","images/slider4-1.jpg","images/slider5-1.jpg"]
        document.getElementById("img").src = imgs[i];
        i++;
        if(i == 5) {
            i = 0;
        }
    }
    setInterval(changeImage,1500);
</script>
<div id="slider">
    <div class="slider laptop_pc">
        <div class="grid wide">
            <div class="row slider_block">
                <div class="slider_left slider_item col l-8 m-12 ">
                    <?php
                        $get_product = $product -> getproductcategory();
                        if (isset($get_product)) {
                            while($result = $get_product -> fetch_assoc()) {
                    ?>
                    <div class="slider_left_item l-6 m-6">
                        <div class="box_image">
                            <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category_id']?>"><img src="admin/uploads/<?php echo $result['product_image'] ?>" alt="<?php echo $result['product_name'] ?>"></a>
                        </div>
                        <div class="box_content">
                            <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category_id']?>"><h2><?php echo $result['category_name'] ?></h2></a>
                            <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category_id']?>"><h3><?php echo $result['product_name'] ?></h3></a>
                            <p><?php echo number_format($result['product_price']) ?> vnđ</p>
                            <!-- <input type="submit" value="Xem chi tiết"> -->
                            <a href="productdetail.php?product_id=<?php echo $result['product_id'] ?>&category_id=<?php echo $result['category_id']?>" class="input_detail">Xem chi tiết</a>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
                <div class="slider_right slider_item col l-4 m-12">
                    <div class="slider_img">
                        <img src="images/slider2-1.jpg" id="img" alt="">
                    </div>
                    <div class="slider_text">
                        <span class="slider__heading">VietNamFood Restaurant</span><br>
                        <span class="slider__description">Hệ thống ăn uống và giải trí hàng đầu tại Việt Nam với hơn 200 cửa hàng lớn nhỏ trên cả 3 miền 
                            nhằm mang đến sự phục vụ tốt nhất dành cho bạn và cả gia đình!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>