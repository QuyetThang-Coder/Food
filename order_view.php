<?php 
    include_once 'lib/session.php';
    Session::checkSessionUser();
?>
<?php 
    include_once 'lib/database.php';
    include_once 'helpers/format.php';

	spl_autoload_register(function ($className) {
		include_once "classes/".$className.".php";
	});

	$db = new Database;
	$fm = new Format;
	$cart = new cart;
	$user = new user;
	$product = new product;
    $order = new order;
    $sale = new sale;
    $order_detail = new order_detail;
?>

<?php 
    if (!isset($_GET['order_view']) || $_GET['order_view'] == NULL) {
        echo "<script>window.location = 'order.php'</script>";
    } else {
        $order_id = $_GET['order_view'];
        $show_order = $order_detail -> order_view($order_id,Session::get("userId"));
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/fontawesome-free-6.1.1-web/css/all.css">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/order_view.css">
    <title>Thông tin giao hàng</title>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }

        document.addEventListener("keydown", function (event){
            if (event.ctrlKey){
            event.preventDefault();
            }
            if(event.keyCode == 123){
            event.preventDefault();
            }
        });
    </script>
    <script>
        isBool = true;
        function change() {
            if (isBool) {
                document.getElementById('su-dung').style.backgroundColor='#1877f2'
                document.getElementById('su-dung').style.cursor='pointer'
                document.getElementById('su-dung').setAttribute("type","submit");
            }      
            if (document.getElementById('ma-sale').value == ''){
                document.getElementById('su-dung').style.backgroundColor='#c8c8c8'
                document.getElementById('su-dung').setAttribute("type","button");
            }
        }
    </script>

    <script>
        function showsale() {
            document.getElementById("js-modal").style.display="flex";
        }
        function closethongtin() {
            document.getElementById("js-modal").style.display="none";
        }
    </script>

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</head>
<body>
    <div id="main">
        <div id="content" class="laptop_pc">
            <!-- content-left -->
            <form action="" method="POST">
                <div class="content-left">
                    <div class="content-left-thongtin">
                        <a href="./Home.php">VietNamese Food</a>
                        <ul>
                            <li><a href="order.php" style="color: #54b3e5;" >Đơn hàng</a></li>
                            <li><a href="#">Thông tin đơn hàng</a></li>
                        </ul>
                        <h3>Thông tin giao hàng</h3>
                        <!--  -->
                        <?php
                            $show_user = $order -> getuserbyorder($order_id);
                            if(isset($show_user)) {
                                while($result_user = $show_user -> fetch_assoc()) {
                        ?>
                            <div class="thongtin">
                                <label for="">Tên khách hàng</label>
                                <input type="text" name="name" readonly value="<?php echo $result_user['order_name'] ?>">
                            </div>
                            <div class="thongtin">
                                <label for="">Số điện thoại</label>
                                <input type="number" name="phone" readonly value="<?php echo $result_user['order_phone'] ?>">
                            </div>
                            <div class="thongtin">
                                <label for="">Địa chỉ</label>
                                <textarea name="address" id="" cols="30" readonly rows="10"><?php echo $result_user['order_address'] ?></textarea>
                            </div>
                            <div class="thongtin">
                                <label for="">Ngày đặt hàng</label>
                                <input type="datetime-local" readonly value="<?php echo $result_user['order_date'] ?>">
                            </div>
                            <h3>Phương thức thannh toán</h3>
                            <div class="section">
                                <div class="content-box">
                                    <?php if($result_user['payment'] == 0) { ?>
                                        <div class="radio-wrapper">
                                            <label class="radio-label" for="">
                                                <div class='radio-content-input'>
                                                    <i class="fa fa-thin fa-hand-holding-dollar"></i>
                                                    <span class="radio-label-primary">Thanh toán khi giao hàng (COD)</span>
                                                </div>
                                            </label>
                                        </div>
                                    <?php } if($result_user['payment'] == 1) { ?>
                                        <div class="radio-wrapper">
                                            <label class="radio-label" for="">
                                                <div class='radio-content-input'>
                                                    <i class="fa fa-thin fa-building-columns"></i>
                                                    <span class="radio-label-primary">Thanh toán online</span>
                                                </div>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php $sale_price = $result_user['sale_price']; $total = $result_user['order_price']; } } ?>
                    </div>
                </div>
                <!-- content-right -->
                <div class="content-right">
                    <div class="content-right-thongtin">
                        <div class="sanpham">
                            <?php 
                                if(isset($show_order) && $show_order == '0') {
                                    echo "<script>window.location = 'order.php'</script>";
                                }
                            ?>
                            <table>
                                <?php 
                                    if($show_order) {
                                        $i = 0;
                                        $sum =0;
                                        while ($result_order = $show_order -> fetch_assoc()) {
                                            $i++;
                                ?>
                                    <tr>
                                        <td class="anh-sp">
                                            <img src="admin/uploads/<?php echo $result_order['product_image'] ?>" alt="<?php echo $result_order['product_name'] ?>">
                                            <label for=""><?php echo $result_order['product_quantity'] ?></label>
                                        </td>
                                        <td class="ten-sp"><?php echo $result_order['product_name'] ?></td>
                                        <td class="gia-sp">
                                            <label for=""><?php echo number_format($result_order['product_price']) ?> vnđ</label>
                                        </td>
                                    </tr>
                                <?php $sum = $sum + $result_order['product_price']; } } ?>
                            </table>
                        </div>
                        <hr>
                        <div class="tong">
                                <div>
                                    <p>Tạm tính</p>
                                    <p class="tien"><?php echo number_format($sum).' vnđ'; ?></p>
                                </div>
                            <div>
                                <p>Phí vận chuyển</p>
                                <p class="tien"><?php $transport = 30000; echo number_format($transport).' vnđ'; ?></p>
                            </div>
                            
                            <!-- Sale -->
                            <div>
                                <p>Giảm giá</p>
                                <p class="tien"><?php echo '- '.number_format($sale_price).' vnđ'; ?></p>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="tongcong">
                                <div>
                                    <p>Tổng cộng</p>
                                    <p class="tien1"><?php echo number_format($total).' vnđ'; ?></p>
                                </div>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
</body>
</html>