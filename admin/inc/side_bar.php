<?php 
    include '../lib/session.php';
    include_once '../classes/staff.php';
    Session::checkSession();
?>

<?php 
    $staff = new staff;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quản trị Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</head>

<body onload="time()" class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header">
        <!-- Sidebar toggle button-->
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!-- User Menu-->
            <li>
                <?php
                    if(isset($_GET['action']) && $_GET['action'] == 'logout' ) {
                        Session::destroy();
                    }
                ?>
                <a class="app-nav__item" href="?action=logout"><i class='bx bx-log-out bx-rotate-180'></i> </a>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user">
            <?php 
                $get_staff_session = $staff -> getstaffbysession(Session::get('adminId'));
                if(isset($get_staff_session)) {
                    while($result_staff = $get_staff_session -> fetch_assoc()) {
            ?>
            <img class="app-sidebar__user-avatar" src="uploads/staff/<?php echo $result_staff['staff_image'] ?>" width="50px" alt="<?php echo $result_staff['staff_name'] ?>">
            <div>
                <p class="app-sidebar__user-name"><b><?php echo $result_staff['staff_name'] ?></b></p>
                <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
            </div>
            <?php } } ?>
        </div>
        <hr>
        <ul class="app-menu">
            <li><a class="app-menu__item dashboard " href="index.php"><i class='app-menu__icon bx bx-tachometer'></i><span
                    class="app-menu__label">Bảng điều khiển</span></a>
            </li>
            <li><a class="app-menu__item qlnv" href="QL_NhanVien.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                    class="app-menu__label">Quản lý nhân viên</span></a>
            </li>
            <li><a class="app-menu__item qlkh" href="QL_KhachHang.php"><i class='app-menu__icon bx bx-user-voice'></i><span
                    class="app-menu__label">Quản lý khách hàng</span></a>
            </li>
            <li><a class="app-menu__item qlsp" href="QL_SanPham.php"><i class='app-menu__icon bx bx-purchase-tag-alt'></i><span 
                    class="app-menu__label">Quản lý sản phẩm</span></a>
            </li>
            <li><a class="app-menu__item qldh" href="QL_DonHang.php"><i class='app-menu__icon bx bx-task'></i><span
                    class="app-menu__label">Quản lý đơn hàng</span></a>
            </li>
            <li><a class="app-menu__item qlsl" href="QL_Sale.php"><i class='app-menu__icon bx bx-money'></i><span 
                    class="app-menu__label">Mã giảm giá</span></a>
            </li>


            <li><a class="app-menu__item qllh" href="QL_LienHe.php"><i class='app-menu__icon bx bxs-contact'></i><span
                    class="app-menu__label">Quản lý liên hệ</span></a>
            </li>
            <li><a class="app-menu__item bcdt" href="BaoCao.php"><i class='app-menu__icon bx bx-pie-chart-alt-2'></i><span 
                    class="app-menu__label">Báo cáo doanh thu</span></a>
            </li>
        </ul>
    </aside>