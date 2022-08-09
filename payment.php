<?php 
    include_once 'lib/session.php';
    Session::checkSessionUser();
    Session::checkSessionCart();
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
?>

<?php 
    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['order']) ) {

        if($_POST['redirect'] == 'cod') {
            $total_sum = $_POST['total'];
            $sale_price = $_POST['sale'];
            $sale_id = $_POST['sale_id'];
            $order_cod = $order->insert_order_cod($_POST,Session::get("userId"),$total_sum,$sale_id,$sale_price);
        }
        if($_POST['redirect'] == 'online') {
            // include_once 'payment_gateways.php';
            // include_once 'momo_QR.php';
            echo $_POST['user_id'];
            // die();
            include_once 'momo_ATM.php';
        }
		
	}

    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['use_sale']) ) {
        $sale_text = $_POST['sale_text'];
        $total_sum = $_POST['total'];
        
        $validate_sale = $sale -> validate_sale($sale_text,$total_sum);
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
    <link rel="stylesheet" href="css/payment.css">
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
<body oncontextmenu = "return false;">
    <div id="main">
        <div id="content" class="laptop_pc">
            <!-- content-left -->
            <form action="" method="POST">
                <div class="content-left">
                    <div class="content-left-thongtin">
                        <a href="./Home.php">VietNamese Food</a>
                        <ul>
                            <li><a href="cart.php" style="color: #54b3e5;" >Giỏ hàng</a></li>
                            <li><a href="#">Thông tin giao hàng</a></li>
                        </ul>
                        <h3>Thông tin giao hàng</h3>
                        <!--  -->
                        <?php
                            $show_user = $user -> getuserbysession(Session::get("userId"));
                            if(isset($show_user)) {
                                while($result_user = $show_user -> fetch_assoc()) {
                        ?>
                            <div class="thongtin">
                                <label for="">Tên khách hàng</label>
                                <input type="text" name="name" value="<?php echo $result_user['user_name'] ?>">
                            </div>
                            <div class="thongtin">
                                <label for="">Số điện thoại</label>
                                <input type="number" name="phone" value="<?php echo $result_user['user_phone'] ?>">
                            </div>
                            <div class="thongtin">
                                <label for="">Địa chỉ</label>
                                <textarea name="address" id="" cols="30" rows="10"><?php echo $result_user['user_address'] ?></textarea>
                            </div>
                        <?php } } ?>
                        <h3>Phương thức thannh toán</h3>
                        <div class="section">
                            <div class="content-box">
                                <div class="radio-wrapper">
                                    <label class="radio-label" for="">
                                        <div class="radio-input">
                                            <input class="input-radio" type="radio" value="cod" name="redirect" id="redirect" checked />
                                            <span class="checkmark"></span>
                                        </div>
                                        <div class='radio-content-input'>
                                            <!-- name="redirect" id="redirect" -->
                                            <!-- <img  src="https://hstatic.net/0/0/global/design/seller/image/payment/cod.svg?v=1"/> -->
                                            <i class="fa fa-thin fa-hand-holding-dollar"></i>
                                            <span class="radio-label-primary">Thanh toán khi giao hàng (COD)</span>
                                        </div>
                                    </label>
                                </div>
                                <!--  -->
                                <div class="radio-wrapper">
                                    <label class="radio-label" for="">
                                        <div class="radio-input">
                                            <input class="input-radio" type="radio" value="online" name="redirect" id="redirect" />
                                            <span class="checkmark"></span>
                                        </div>
                                        <div class='radio-content-input'>
                                            <!-- <img  src="https://hstatic.net/0/0/global/design/seller/image/payment/cod.svg?v=1"/> -->
                                            <i class="fa fa-thin fa-building-columns"></i>
                                            <span class="radio-label-primary">Thanh toán online</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="thanhtoan">
                            <input type="submit" onclick="return confirm('Bạn có muốn đặt hàng không?')" name="order" value="Đặt hàng">
                        </div>
                        <div class="giohang">
                            <a href="cart.php">Giỏ hàng</a>
                        </div>
                    </div>
                </div>
                <!-- content-right -->
                <div class="content-right">
                    <div class="content-right-thongtin">
                        <div class="sanpham">
                            <?php 
                                if(isset($order_cod)) {
                                    echo $order_cod;
                                }
                            ?>
                            <table>
                                <?php 
                                    $show_cart = $cart -> show_cart_by_id(Session::get("userId")) ;
                                    if($show_cart) {
                                        if (Session::get("cart") == false) {
                                            echo "<tr style='height:100px'></tr>";
                                        } if (Session::get("cart") == true) {

                                            $sum = 0;
                                            while($result_product = $show_cart -> fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td class="anh-sp">
                                            <img src="admin/uploads/<?php echo $result_product['cart_image'] ?>" alt="<?php echo $result_product['cart_name'] ?>">
                                            <label for=""><?php echo $result_product['cart_quantity'] ?></label>
                                        </td>
                                        <td class="ten-sp"><?php echo $result_product['cart_name'] ?></td>
                                        <td class="gia-sp">
                                            <label for=""><?php $into_money = $result_product['cart_price'] * $result_product['cart_quantity']; echo number_format($into_money) ?> vnđ</label>
                                        </td>
                                    </tr>
                                <?php $sum = $sum + $into_money; } } } ?>
                            </table>
                        </div>
                        <hr>
                        <div class="sale">
                            <input type="text" oninput="change()" id="ma-sale" name="sale_text" placeholder="Mã giảm giá" autocomplete="off" class="ma-sale">
                            <input type="button" name="use_sale" id="su-dung" value="Sử dụng" class="su-dung">
                            <input type="button" name="list_sale" onclick="showsale()" value="Danh sách mã giảm giá" class="list_sale">
                        </div>
                        <hr>
                        <div class="tong">
                            <?php 
                                if (Session::get("cart") == false) {}
                                if (Session::get("cart") == true) {
                            ?>
                                <div>
                                    <p>Tạm tính</p>
                                    <p class="tien"><?php echo number_format($sum).' vnđ'; ?></p>
                                </div>
                            <?php } ?>
                            <div>
                                <p>Phí vận chuyển</p>
                                <p class="tien"><?php $transport = 30000; echo number_format($transport).' vnđ'; ?></p>
                            </div>
                            
                            <!-- Sale -->
                            <div>
                                <p>Giảm giá</p>

                                <?php 
                                    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['use_sale']) ) {
                                        $sale_text = $_POST['sale_text'];
                                        $total_sum = $_POST['total'];
                                        
                                        $validate_sale = $sale -> validate_sale($sale_text,$total_sum);
                                        if(is_object($validate_sale)) {
                                            while($result = $validate_sale -> fetch_assoc()) {
                                ?>
                                    <input type="hidden" name="sale_id" readonly value="<?php echo $result['sale_id']; ?>">
                                    <p class="tien"><?php $sale_price = $result['sale_price']; echo '- '.number_format($sale_price).' vnđ'; ?></p>
                                <?php }} else { ?>
                                    <input type="hidden" name="sale_id" readonly value="<?php echo '0'; ?>">
                                    <p class="tien"><?php $sale_price = 0; echo number_format($sale_price).' vnđ'; ?></p>
                                <?php } } else { ?>
                                    <input type="hidden" name="sale_id" readonly value="<?php echo '0'; ?>">
                                    <p class="tien"><?php $sale_price = 0; echo number_format($sale_price).' vnđ'; ?></p>
                                <?php } ?>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="tongcong">
                            <?php 
                                if (Session::get("cart") == false) {} 
                                if (Session::get("cart") == true) {
                            ?>
                                <div>
                                    <p>Tổng cộng</p>
                                    <p class="tien1"><?php $total = $sum + $transport - $sale_price; echo number_format($total).' vnđ'; ?></p>
                                    <input type="hidden" name="total" readonly value="<?php echo $total; ?>">
                                    <input type="hidden" name="sale" readonly value="<?php echo $sale_price; ?>">
                                    <input type="hidden" name="user_id" readonly value="<?php echo Session::get('userId'); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>
            <?php 
                if(isset($validate_sale)) {
                    if(is_object($validate_sale)) {}
                    else { echo $validate_sale; }
                }
                // $validate_sale = $sale -> validate_sale($sale_text,$total_sum);
                // if($validate_sale) {
                //     while($result = $validate_sale -> fetch_assoc()) {
                //         echo $result['sale_id'];
                //     }
                // }
            ?>
            <!-- Modal -->
            <div class="modal js-modal" id="js-modal">
                <div class="modal-container">
                    <div class="modal-close" onclick="closethongtin()">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <div class="modal-header">
                        <h2>Danh sách mã giảm giá</h2>
                    </div>
                    <div class="modal-body">
                        <h3>Hỗ trợ khuyến mại</h3>
                        <h4>Mua nhiều hơn tiết kiệm nhiều hơn</h4>
                        <div class="modal-table">
                            <div class="modal-top">
                                <table>
                                    <tr class="fixed">
                                        <th width="40">STT</th>
                                        <th width="100">Mã giảm giá</th>
                                        <th width="90">Số tiền</th>
                                        <th width="140">Điều kiện</th>
                                        <th width="120">Số lượng</th>
                                        <th width="90">Còn lại</th>
                                        <th width="100">Ngày bắt đầu</th>
                                        <th width="100">Ngày kết thúc</th>
                                    </tr>
                                    <?php 
                                        $show_sale = $sale -> show_sale_remain();
                                        if(isset($show_sale) && $show_sale != '0') {
                                            $i = 0;
                                            while($result = $show_sale -> fetch_assoc()) {
                                                $i++;
                                    ?>
                                        <tr>
                                            <td width="40"><?php echo $i; ?></td>
                                            <td width="100"><?php echo $result['sale_name']; ?></td>
                                            <td width="80"><?php echo number_format($result['sale_price']).' vnđ'; ?></td>
                                            <td width="120"><?php echo 'Áp dụng cho đơn hàng có giá trị từ '.number_format($result['sale_rule']).' vnđ'; ?></td>
                                            <td width="120">
                                                <?php 
                                                    if($result['sale_quantity'] == '99999') {
                                                        echo "Không giới hạn";
                                                    } if($result['sale_quantity'] < '99999') {
                                                        echo 'Áp dụng cho '.$result['sale_quantity'].' đơn hàng đầu tiên';
                                                    }
                                                ?>
                                            </td>
                                            <td width="90">
                                                <?php 
                                                    if($result['sale_quantity'] == 99999) {
                                                        echo "Không giới hạn";
                                                    } if($result['sale_quantity'] < 50000 && $result['sale_remain'] > 0) {
                                                        echo $result['sale_remain'].' đơn hàng';
                                                    } if($result['sale_remain'] <= 0) {
                                                        echo "Đã hết";
                                                    }
                                                ?>
                                            </td>
                                            <td width="100"><?php echo date_format(date_create($result['start_day']),"d-m-Y").'<br>'.date_format(date_create($result['end_day']),"H-i-s"); ?></td>
                                            <td width="100"><?php echo date_format(date_create($result['end_day']),"d-m-Y").'<br>'.date_format(date_create($result['end_day']),"H-i-s"); ?></td>
                                        </tr>
                                    <?php } } ?>
                                </table>
                            </div>
                        </div>
                        <div class="button_modal">
                            <input type="button" class="dong" onclick="closethongtin()" value="Đóng">
                        </div>
                    </div>
                </div>  
            </div>

        </div>
    </div>
</body>
</html>