<?php 
    include_once 'lib/session.php';
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
	$category = new category;
	$product = new product;
	$contact = new contact;
	$order = new order;
	$order_detail = new order_detail;
?>
<?php
	if(isset($_GET['action']) && $_GET['action'] == 'logout') {
		Session::destroy();
	}

?> 

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>VietNam Food</title>
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
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/main.css">

	<script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
	<!-- <base href="http://localhost:8080/Food/"> -->
	<meta name="google-site-verification" content="aAV_SNjvAPGX5Sh7GI1_qexh4kE3eC0Ts40rXYTeXc8" />
</head>
<body>
	<div id="main">
		<div id="header">
			<div class="header laptop_pc">
				<!-- Header top -->
				<div class="header_top">
					<div class="grid wide">
						<div class="row header_top_box">
							<!-- Logo -->
							<div class="header_logo_item col l-6 m-6">
								<a href="" class="col l-2 m-2 ">
									<img src="images/pixlr-bg-result.png" alt="">
								</a>
								<span class="header__logo-text "></span>
							</div>
							<!-- Right -->
							<div class="header_right col l-6 m-6">
								<div class="row header_right_location" >
									<div class="header_right_item col l-4 m-4 ">
										<div class="header__contact">
											<div class="header__contact-icon">
												<i class="fas fa-clock"></i>
											</div>
											<div class="header__contact-content">
												<span class="header__contact-title">open:</span>
												<span href="#" class="header__contact-in4">8 AM - 10 PM</span>
											</div>
										</div>
									</div>
									<div class="header_right_item col l-4 m-4 ">
										<div class="header__contact">
											<div class="header__contact-icon">
												<i class="fas fa-envelope ti-email"></i>
											</div>
											<div class="header__contact-content">
												<span class="header__contact-title">Email:</span>
												<span href="#" class="header__contact-in4">vnfood@food.com</span>
											</div>
										</div>
									</div>
									<div class="header_right_item col l-4 m-4 ">
										<div class="header__contact">
											<div class="header__contact-icon">
												<i class="fas fa-phone-alt"></i>
											</div>
											<div class="header__contact-content">
												<span class="header__contact-title">Hotline:</span>
												<span href="#" class="header__contact-in4">0946312559</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Header botoom -->
				<div class="header_botoom">
					<div class="grid wide">
						<div class="row header_botoom_box">
							<div class="header_botoom_left col l-9 m-9">
								<ul class="list_menu">
									<li><a href="index.php" class="item_home">Trang chủ</a></li>
									<li><a href="introduce.php" class="item_introduce">Giới thiệu</a></li>
									<li><a href="product.php" class="item_product_header">Sản phẩm</a></li>
									<?php if(Session::get("userLogin") == false) { ?>
										<li><a href="cart.php" class="item_cart">Giỏ hàng</a></li>
									<?php } else { ?>
										<li>
											<a href="cart.php" class="item_cart item_sum_cart">Giỏ hàng</a>
											<span>
												<?php 
													$sum_cart = $cart -> show_sum_cart_by_id(Session::get('userId'));
													if(isset($sum_cart)) {
														while ($result = $sum_cart -> fetch_assoc()) {
															echo $result['sum'];
														}
													}
												?>
											</span>
										</li>
									<?php } ?>
									<li><a href="contact.php" class="item_contact">Liên hệ</a></li>
								</ul>
							</div>
							<div class="header_botoom_right l-3 m-3">
								<ul class="list_menu button_login">
									<!-- <li><a href="login.php">Đăng nhập</a></li> -->
									<?php 
										$login_check = Session::get('userLogin');
										if ($login_check == false) {
											echo '<li><a href="login.php">Đăng nhập</a></li>';
										} if ($login_check == true) {
											$getuser = $user -> getuserbysession(Session::get('userId'));
											if(isset($getuser)) {
												while ($result_user = $getuser -> fetch_assoc()) {
									?>
										<li>
											<a href="#"><?php echo $result_user['user_name'] ?></a>
											<ul class="sub_nav">
												<li>
													<a href="profile.php"><i class="fa fa-thin fa-user"></i></a>
													<a href="profile.php" class="button_href">Thông tin khách hàng</a>
												</li>
												<li>
													<a href="order.php"><i class="fa fa-thin fa-box"></i></a>
													<a href="order.php" class="button_href">Thông tin đơn hàng</a>
												</li>
												<li>
													<a href='?action=logout'><i class="fa fa-thin fa-arrow-right-from-bracket"></i></a>
													<a href='?action=logout' class="button_href">Đăng xuất</a>
													<form action="" method="POST">
													</form>
												</li>
											</ul>
										</li>
									<?php } } } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mobile">
			<h3>Website không hỗ trợ trên ứng dụng di động</h3>
		</div>

