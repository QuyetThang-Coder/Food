<?php
    include_once './lib/session.php';

    Session::checkSessionUser();

    include './inc/header.php'; 
?>


<?php
	if(isset($_GET['action']) && $_GET['action'] == 'logout') {
		Session::destroy();
	}
    if(isset($_GET['status']) && $_GET['status'] == '3' && isset($_GET['cancel_order'])) {
        $order_id = $_GET['cancel_order'];
        $cancel_order = $order -> cancel_order($order_id,Session::get('userId'));
    } if (isset($_GET['status']) && $_GET['status'] != '3') {
        echo "<script>window.location = 'order.php'</script>";
    }
?> 

<style>
    .action {
        background-color: #e3eaef;
        border-left: 3px solid #5b9bd1;
        margin-left: -3px;
    }
    .action a {
        color: #5b9bd1;
    }
    .action a i {
        background-color: #fff;
        color: #5b9bd1;
    }
</style>
<div id="profile">
    <div class="profile laptop_pc">
        <div class="grid wide">
            <div class="row profile_box">
                <!-- product left -->
                <div class="profile_left col l-3 m-3">
                    <div class="profile_left_box">
                        <div class="profile_left_item">
                            <a href="profile.php"><i class="fa fa-thin fa-pen-to-square"></i></a>
                            <a href="profile.php" class="profile_left_content">Thông tin cá nhân</a>
                        </div>
                        <div class="profile_left_item">
                            <a href="changepass.php"><i class="fa fa-thin fa-lock"></i></a>
                            <a href="changepass.php" class="profile_left_content">Đổi mật khẩu</a>
                        </div>
                        <div class="profile_left_item action ">
                            <a href="order.php"><i class="fa fa-thin fa-box"></i></a>
                            <a href="order.php" class="profile_left_content">Thông tin đơn hàng</a>
                        </div>
                        <div class="profile_left_item ">
                            <a href="?action=logout"><i class="fa fa-thin fa-arrow-right-from-bracket"></i></a>
                            <a href="?action=logout" class="profile_left_content">Đăng xuất</a>
                        </div>
                    </div>
                </div>
                <!-- product right -->
                <div class="profile_right col l-9 m-9">
                    <div class="profile_right_box1">
                        <div class="profile_right_item">
                            <h2>Danh sách đơn hàng</h2>
                        </div>
                        <div class="profile_right_item1">
                            <?php 
                                if(isset($cancel_order)) {
                                    echo $cancel_order;
                                }
                            ?>
                            <table>
                                <tr class="fixed">
                                    <th width="">STT</th>
                                    <th width="100">Tên khách hàng</th>
                                    <th width="90">Số điện thoại</th>
                                    <th width="240">Địa chỉ</th>
                                    <th width="95">Giảm giá</th>
                                    <th width="95">Tổng tiền</th>
                                    <th width="85">Hình thức thanh toán</th>
                                    <th width="100">Trạng thái</th>
                                    <th width="80">Ngày đặt</th>
                                    <th width="60">Hành động</th>
                                </tr>
                                <?php
                                    $show_order = $order -> getorderbyid(Session::get("userId"));
                                    if($show_order) {
                                        $i = 0;
                                        while ($result_order = $show_order -> fetch_assoc()) {
                                            $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $result_order['order_name'] ?></td>
                                        <td><?php echo $result_order['order_phone'] ?></td>
                                        <td><?php echo $result_order['order_address'] ?></td>
                                        <td><?php echo '- '.number_format($result_order['sale_price']); ?> vnđ</td>
                                        <td><?php echo number_format($result_order['order_price']); ?> vnđ</td>
                                        <td>
                                            <?php 
                                                if ($result_order['payment'] == 0) {
                                                    echo "COD";
                                                } if ($result_order['payment'] == 1) {
                                                    echo "Online";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($result_order['status'] == 0) {
                                                    echo "<p style='background-color: #b6bef5; color: #0f2094; font-size:12px'>Chờ xử lý</p>";
                                                ?>
                                                    <a href="order.php?cancel_order=<?php echo $result_order['order_id']; ?>&status=3" onclick="return confirm('Bạn có muốn hủy đơn hàng `<?php echo $result_order['order_id']; ?>` không?')" title="Hủy">
                                                        <p style='background-color: #f9c9cd; color: #a90312; font-size:12px; margin-top: 10px;'>Hủy</p>
                                                    </a>
                                                <?php } if ($result_order['status'] == 1) {
                                                    echo "<p style='background-color: #f2f98a; color: #8b9400; font-size:12px'>Đang giao hàng</p>";
                                                } if ($result_order['status'] == 2) {
                                                    echo "<p style='background-color: #bfefc4; color: #02790c; font-size:12px'>Đã hoàn thành</p>";
                                                } if ($result_order['status'] == 3) {
                                                    echo "<p style='background-color: #f9c9cd; color: #a90312; font-size:12px'>Đã hủy</p>";
                                                } 
                                            ?>
                                        </td>
                                        <td><?php echo date_format(date_create($result_order['order_date']), "d/m/Y").'<br>'.date_format(date_create($result_order['order_date']), "H:i:s"); ?></td>
                                        <td><a href="order_view.php?order_view=<?php echo $result_order['order_id'] ?>"><i class="icon_show fa fa-thin fa-eye"></i></a></td>
                                    </tr>
                                <?php } } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Footer -->
<?php include './inc/footer.php'; ?>