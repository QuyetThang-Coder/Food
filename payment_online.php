<?php 
    include_once 'lib/session.php';
    include_once 'lib/database.php';
    include_once 'helpers/format.php';

	spl_autoload_register(function ($className) {
		include_once "classes/".$className.".php";
	});

    $session = new Session;
	$db = new Database;
	$fm = new Format;
    $order = new order;
?>


<?php 
    if($_GET['message'] == 'Successful.') {
        $name = $_GET['name'];
        $phone = $_GET['phone'];
        $address = $_GET['address'];
        $total_sum = $_GET['amount'];
        $sale_price = $_GET['sale_price'];
        $sale_id = $_GET['sale_id'];
        $user_id = $_GET['user_id'];
        // $user_id = Session::get("userId");
        echo $user_id;
        $order_cod = $order->insert_order_onl($user_id,$name,$phone,$address,$total_sum,$sale_id,$sale_price);
        header("Location:order.php");
    }
    if($_GET['message'] != 'Successful.') {
        header("Location:payment.php");
    }
?>