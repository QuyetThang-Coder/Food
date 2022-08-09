<?php include './inc/header.php'; ?>


<?php
    // if (isset($_GET['delete_cart'])) {
    //     $id = $_GET['delete_cart'];
    //     $deletecart = $cart -> delete_cart($id);
    // }
    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['update_quantity'])) {
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];
        $update_quantity = $cart -> update_quantity($cart_id,$quantity);
    }

    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['delete'])) {
        $cart_id = $_POST['cart_id'];
        $deletecart = $cart -> delete_cart($cart_id);
    }
?>

<?php
	if(!isset($_GET['id'])) {
		// echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
	}
?>

<style>
    .item_cart {
        background-color: #ff4500 !important; 
        padding: 12px 24px 8px 24px !important;
    }
</style>
<link rel="stylesheet" href="css/quantity.css">
<div id="cart">
    <div class="cart laptop_pc">
        <div class="grid wide">
            <?php 
                if($login_check == true) {
            ?>
            <div class="cart_content">
                <?php if (Session::get("cart") == false) { ?>
                    <div class="not_login">
                        <p>Không có sản phẩm nào trong giỏ hàng</p>
                        <div>
                            <a href="product.php">Xem sản phẩm</a>
                        </div>
                    </div>
                <?php } else { ?>
                <div class="l-12 heading heading_margin">
                    <h3>Giỏ hàng của bạn</h3>
                </div>
                <div class="l-12 list_cart">
                    <?php 
                        if(isset($deletecart)) {
                            echo $deletecart;

                        }
                    ?>
                    <table class="table_cart">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="20%">Ảnh sản phẩm</th>
                            <th width="20%">Tên sản phẩm</th>
                            <th width="15%">Đơn giá</th>
                            <th width="15%">Số lượng</th>
                            <th width="15%">Thành tiền</th>
                            <th width="10%">Xóa</th>
                        </tr>
                        <?php
                            $cart_show = $cart -> show_cart_by_id(Session::get("userId"));
                            if (isset($cart_show)) {
                                if (Session::get("cart") == false) {
                                    echo "<tr style='height:200px'></tr>";
                                }
                                if (Session::get("cart") == true) {
                                    $i = 0;
                                    $sum = 0;
                                    while ($result_cart = $cart_show -> fetch_assoc()) {
                                        $i ++;
                        ?>
                            <form action="" method="POST">
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><img src="admin/uploads/<?php  echo $result_cart['cart_image'] ?>" alt="<?php echo $result_cart['cart_name'] ?>"></td>
                                    <td><?php echo $result_cart['cart_name'] ?></td>
                                    <td><?php echo number_format($result_cart['cart_price']) ?></td>
                                    <td>
                                        
                                            <div class="quantity">
                                                <input type="number" name="quantity" min="1" max="999" step="1" readonly value="<?php echo $result_cart['cart_quantity'] ?>"> 
                                            </div> 
                                            <input type="hidden" name="cart_id" value="<?php echo $result_cart['cart_id'] ?>"/>
                                            <input type="submit" name="update_quantity" value="Cập nhật" >
                                        
                                    </td>
                                    <td><?php $into_money = $result_cart['cart_price'] * $result_cart['cart_quantity']; echo number_format($into_money) ?></td>
                                    <td> <input type="submit" onclick="return confirm('Bạn có muốn xóa sản phẩm `<?php echo $result_cart['cart_name']; ?>` không?')" name="delete" value="xóa"></td>
                                </tr>
                            </form>
                        <?php $sum = $sum + $into_money; } } } } ?>
                    </table>
                </div>
                <?php if (Session::get("cart") == true) { ?>
                    <div class="price">
                        <ul>
                            <li><h3>Tạm tính:</h3></li>
                            <li><p><?php echo number_format($sum); ?> vnđ</p></li>
                        </ul>
                    </div>
                    <div class="back_product">
                        <a href="product.php">Tiếp tục xem sản phẩm</a>
                    </div>
                    <div class="pay">
                        <a href="payment.php" class="">Thanh toán</a>
                    </div>
                <?php } ?>
            </div>
            <?php } else { ?>
                <div class="not_login">
                    <p>Vui lòng đăng nhập để đặt hàng</p>
                    <div>
                        <a href="./Login.php">Đăng nhập</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Footer -->
<!-- Quantity -->
<script src="js/quantity.js"></script>
<script src="js/quantity_cart.js"></script>
<?php include './inc/footer.php'; ?>