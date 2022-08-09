<?php 
	include '../classes/adminlogin.php';
?>
<?php
    if(isset($_GET['action']) && $_GET['action'] == 'logout' ) {
        Session::destroy();
    }
?>
<?php
	$staff = new adminlogin;
	if($_SERVER["REQUEST_METHOD"] === 'POST' ) {
		$adminUser = $_POST['adminUser'];
		$adminPass = $_POST['adminPass'];

		$login_check = $staff->login_admin($adminUser,$adminPass);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Login.css">
    <link rel="stylesheet" href="../themify-icons/themify-icons.css">
    <script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
    <title>Login admin</title>

    <!--  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<!-- Js -->
	<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
	<!-- Icon -->
	<link rel="stylesheet" href="css/fontawesome-free-6.1.1-web/css/all.css">
	<!-- font Satisfy -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
	<!-- font IBM Plex Sans -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@200&display=swap" rel="stylesheet">
	<!-- font 'Roboto Slab', serif -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
	<!-- Css -->
	<link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/login.css">


    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</head>
<body>
    <!-- body -->
    <div id="body">
        <div class="body-center laptop_pc">
            <div class="body-center-img l-12 m-0">
                <img src="images/VNFood-banner.pjg.jpg" alt="">
            </div>
            <div class="body-right login" id="login">
                <form action="" method="POST">
                    <div class="body-center-document login_box">
                        <h2>CHÀO MỪNG BẠN ĐẾN VỚI QUẢN TRỊ VIÊN</h2>
                        <h3>Đăng nhập</h3>
                        <div class="form-group col-md-12">
                            <?php 
                                if (isset($login_check)) {
                                    echo $login_check;
                                }
                            ?>
                        </div>
                        <div class="login_frm">
                            <input type="text" placeholder="Số điện thoại"  class="taikhoan" name="adminUser" autocomplete="off"> <br>
                            <div>
                                <input type="password" placeholder="Mật khẩu" id="showpassword"  class="matkhau" name="adminPass" >
                            </div>
                            <a href="../index.php" class="trangchu">Về trang chủ</a> <br>
                            <input type="submit" class="Dangnhap" value="Đăng nhập" name="dangnhap"> <br>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</body>
</html>