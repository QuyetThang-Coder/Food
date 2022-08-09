<?php 
	include 'classes/user.php';
    // Session::destroy();
    
?>

<?php 
	$login_check = Session::get('userLogin');
	if ($login_check) {
		header('Location:index.php');
	} 
?>

<?php
	$user = new user;
	if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['dangnhap']) ) {
		$userUser = $_POST['userUser'];
		$userPass = $_POST['userPass'];

		$login_check = $user->login_user($userUser,$userPass);
	}
    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['dangky']) ) {

		$register = $user->register($_POST);
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
    <title>Login VietNamese Food</title>

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
	<!-- Sweetalert -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<!-- Css -->
	<link rel="stylesheet" href="css/sweetalert.css">
	<link rel="stylesheet" href="css/grid.css">
	<link rel="stylesheet" href="css/login.css">

    <meta name="google-site-verification" content="aAV_SNjvAPGX5Sh7GI1_qexh4kE3eC0Ts40rXYTeXc8" />
    <!-- JS -->
    <script>
        isBool = true;
        function showpassword() {
            if(isBool) {
                document.getElementById("showpassword").setAttribute("type","text");
                isBool = false;
            }
            else {
                document.getElementById("showpassword").setAttribute("type","password");
                isBool = true;
            }
        }
        function showpassword_register() {
            if(isBool) {
                document.getElementById("showpassword_register").setAttribute("type","text");
                isBool = false;
            }
            else {
                document.getElementById("showpassword_register").setAttribute("type","password");
                isBool = true;
            }
        }
        function showrepassword_register() {
            if(isBool) {
                document.getElementById("showrepassword_register").setAttribute("type","text");
                isBool = false;
            }
            else {
                document.getElementById("showrepassword_register").setAttribute("type","password");
                isBool = true;
            }
        }



        function register() {
            document.getElementById("sign_up").style.display="block";
            document.getElementById("login").style.display="none";
        }
        function login() {
            document.getElementById("login").style.display="block";
            document.getElementById("sign_up").style.display="none";
        }
    </script>

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
                        <h2>CHÀO MỪNG BẠN ĐẾN VỚI VIETNAM FOOD</h2>
                        <h3>Đăng nhập</h3>
                        <div class="login_frm">
                            <input type="number" placeholder="Số điện thoại"  class="taikhoan userUser" name="userUser" autocomplete="off"> <br>
                            <label for="" class="info_userUser error"></label> <br>
                            <div>
                                <input type="password" placeholder="Mật khẩu" id="showpassword"  class="matkhau userPass" name="userPass" >
                                <i class="icon_show fa fa-thin fa-eye" onclick="showpassword()"></i> <br>
                                <label for="" class="info_userPass error"></label><br>
                            </div>
                            <?php 
                                if (isset($login_check)) {
                                    echo $login_check;
                                }
                            ?>
                            <a href="index.php" class="trangchu">Về trang chủ</a> <br>
                            <input type="submit" class="Dangnhap" value="Đăng nhập" name="dangnhap"> <br>
                            <a href="#" class="quenmatkhau" id="quenmatkhau">Quên mật khẩu?</a> <br>
                            <!-- <input type="submit" class="Dangky" onclick="register()"  value="Tạo tài khoản mới" name="dangky"> -->
                            <p class="Dangky" onclick="register()" >Tạo tài khoản mới</p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- sign up -->
            <div class="body-right sign_up" id="sign_up">
                <form action="" method="POST">
                    <div class="body-center-document sign_up_box">
                        <h2>CHÀO MỪNG BẠN ĐẾN VỚI VIETNAM FOOD</h2>
                        <h3>Đăng ký</h3>
                        <div class="sign_up_frm">
                            <input type="text" placeholder="Họ và tên" required class="taikhoan register_name" name="register_name" autocomplete="off"> <br>
                            <label for="" class="info_register_name error"></label><br>
                            <input type="number" placeholder="Số điện thoại" required class="taikhoan register_phone" name="register_phone" autocomplete="off"> <br>
                            <label for="" class="info_register_phone error"></label><br>
                            <input type="email" placeholder="Email" required class="taikhoan register_email" name="register_email" autocomplete="off"> <br>
                            <label for="" class="info_register_email error"></label><br>
                            <input type="text" placeholder="Địa chỉ" required class="taikhoan register_address" name="register_address" autocomplete="off"> <br>
                            <label for="" class="info_register_address error"></label><br>
                            <div>
                                <input type="password" placeholder="Mật khẩu" required id="showpassword_register"  class="matkhau register_pass" name="register_pass" >
                                <i class="icon_show fa fa-thin fa-eye" onclick="showpassword_register()"></i> <br>
                                <label for="" class="info_register_pass error"></label><br>
                            </div>
                            <div>
                                <input type="password" placeholder="Nhập lại mật khẩu" required id="showrepassword_register"  class="matkhau register_repass" name="register_repass" >
                                <i class="icon_show fa fa-thin fa-eye" onclick="showrepassword_register()"></i> <br>
                                <label for="" class="info_register_repass error"></label>
                            </div>
                            <?php 
                                if (isset($register)) {
                                    echo $register;
                                }
                            ?>
                            <input type="submit" class="Dangky" value="Đăng ký" name="dangky"> <br>
                            <!-- <a href="#" class="quenmatkhau" id="quenmatkhau">Bạn đã có tài khoản?</a> -->
                            <p class="quenmatkhau">Bạn đã có tài khoản? <i onclick="login()">Đăng nhập</i></p> <br>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    <!-- JS -->
    <script src="js/login.js"></script>
    </script>
</body>
</html>