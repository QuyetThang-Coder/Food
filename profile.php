<?php
    include_once './lib/session.php';

    Session::checkSessionUser();

    include './inc/header.php'; 
?>


<?php
	if(isset($_GET['action']) && $_GET['action'] == 'logout') {
		Session::destroy();
	}
    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['submit'])) {
        $id = Session::get("userId");

        $update_user = $user -> update_user($id,$_POST);
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
                        <div class="profile_left_item action">
                            <a href="profile.php"><i class="fa fa-thin fa-pen-to-square"></i></a>
                            <a href="profile.php" class="profile_left_content">Thông tin cá nhân</a>
                        </div>
                        <div class="profile_left_item ">
                            <a href="changepass.php"><i class="fa fa-thin fa-lock"></i></a>
                            <a href="changepass.php" class="profile_left_content">Đổi mật khẩu</a>
                        </div>
                        <div class="profile_left_item ">
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
                    <form action="" method="POST">
                        <div class="profile_right_box">
                            <div class="profile_right_item">
                                <h2>Thông tin cá nhân</h2>
                            </div>
                            <?php 
                                $show_user = $user -> getuserbysession(Session::get("userId"));
                                if($show_user) {
                                    while($result_user = $show_user -> fetch_assoc()) {
                            ?>
                                <div class="profile_right_item">
                                    <label for="">Họ và tên</label>
                                    <input type="text" name="user_name" value="<?php echo $result_user['user_name'] ?>">
                                </div>
                                <div class="profile_right_item">
                                    <label for="">Số điện thoại</label>
                                    <input type="text" name="user_phone" value="<?php echo $result_user['user_phone'] ?>">
                                </div>
                                <div class="profile_right_item">
                                    <label for="">Email</label>
                                    <input type="text" name="user_email" value="<?php echo $result_user['user_email'] ?>">
                                </div>
                                <div class="profile_right_item">
                                    <label for="">Địa chỉ nhận hàng</label>
                                    <textarea name="user_address" id="" cols="30" rows="10"><?php echo $result_user['user_address'] ?></textarea>
                                </div>
                                <div class="profile_right_item">
                                    <?php 
                                        if(isset($update_user)) {
                                            echo $update_user;
                                        }
                                    ?>
                                </div>
                                <div class="profile_right_item">
                                    <input type="submit" name="submit" value="Lưu thay đổi">
                                </div>
                            <?php } } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php include './inc/footer.php'; ?>
