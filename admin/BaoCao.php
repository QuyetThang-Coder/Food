<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/order.php';  ?>
<?php include_once '../classes/user.php';  ?>
<?php include_once '../classes/product.php';  ?>
<?php include_once '../classes/staff.php';  ?>

<?php 
  $order = new order;
  $user = new user;
  $staff = new staff;
  $product = new product;
?>

<style>
    .bcdt {
        background: #c6defd;
        text-decoration: none;
        color: rgb(22 22 72);
        box-shadow: none;
        border: 1px solid rgb(22 22 72);
    }
</style>
  <main class="app-content">
    <div class="row">
      <div class="col-md-12">
        <div class="app-title">
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="#"><b>Báo cáo doanh thu    </b></a></li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="widget-small primary coloured-icon"><i class='icon  bx bxs-user fa-3x'></i>
                    <div class="info">
                        <h4>Tổng Nhân viên</h4>
                        <p><b>
                            <?php
                                $sum_staff = $staff -> sum_staff();
                                if (isset($sum_staff)) {
                                    $i = 0;
                                    while ($result = $sum_staff -> fetch_assoc()) {
                                        echo $result['sum_staff'].' sản phẩm';
                                    }
                                } 
                            ?>
                        </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x' ></i>
                    <div class="info">
                        <h4>Tổng sản phẩm</h4>
                        <p><b>
                            <?php
                                $sum_product = $product -> sum_product();
                                if (isset($sum_product)) {
                                    $i = 0;
                                    while ($result = $sum_product -> fetch_assoc()) {
                                        echo $result['SUM_PRODUCT'].' sản phẩm';
                                    }
                                } 
                            ?>
                        </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-shopping-bag-alt'></i>
                    <div class="info">
                        <h4>Tổng đơn hàng</h4>
                        <p><b>
                            <?php
                                $sum_order = $order -> sum_orderbymonth();
                                if (isset($sum_order)) {
                                    $i = 0;
                                    while ($result = $sum_order -> fetch_assoc()) {
                                        echo $result['SUM_ORDER'].' đơn hàng';
                                    }
                                } 
                            ?>
                        </b></p>
                    </div>
                </div>
            </div>
        
            <div class="col-md-6 col-lg-4">
                <div class="widget-small primary coloured-icon"><i class='icon fa-3x bx bxs-chart' ></i>
                    <div class="info">
                        <h4>Tổng thu nhập</h4>
                        <p><b>
                            <?php
                                $sum_total = $order -> sum_total();
                                if (isset($sum_total)) {
                                    $i = 0;
                                    while ($result = $sum_total -> fetch_assoc()) {
                                        echo number_format($result['sum_price']).' vnđ';
                                    }
                                } 
                            ?>
                        </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class='icon fa-3x bx bxs-user-badge' ></i>
                    <div class="info">
                        <h4>Tổng khách hàng</h4>
                        <p><b>
                            <?php
                                $sum_user = $user -> sum_user();
                                if (isset($sum_user)) {
                                    $i = 0;
                                    while ($result = $sum_user -> fetch_assoc()) {
                                        echo $result['SUM_USER'].' khách hàng';
                                    }
                                } 
                            ?>
                        </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-receipt' ></i>
                    <div class="info">
                        <h4>Đơn hàng hủy</h4>
                        <p><b>
                            <?php
                                $sum_order_cancel = $order -> sum_ordercancelbymonth();
                                if (isset($sum_order_cancel)) {
                                    $i = 0;
                                    while ($result = $sum_order_cancel -> fetch_assoc()) {
                                        echo $result['SUM_ORDER'].' đơn hàng';
                                    }
                                } 
                            ?>
                        </b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">SẢN PHẨM BÁN CHẠY</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Mã sản phẩm</th>
                                    <th style="text-align: center;">Tên sản phẩm</th>
                                    <th style="text-align: center;">Ảnh</th>
                                    <th style="text-align: center;">Giá tiền</th>
                                    <th style="text-align: center;">Số lượng đã bán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sum_product_selling = $product -> sum_selling();
                                    if (isset($sum_product_selling)) {
                                        $i = 0;
                                        while ($result = $sum_product_selling -> fetch_assoc()) {
                                            $i++;
                                ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td style="text-align: center;"><?php echo $result['product_name'] ?></td>
                                        <td style="text-align: center;"><img src="uploads/<?php echo $result['product_image'] ?>" style="border-radius: 4px; object-fit: cover;" width="70px" height="50px" alt="<?php echo $result['product_name'] ?>"></td>
                                        <td style="text-align: center;"><?php echo number_format($result['product_price']).' vnđ' ?></td>
                                        <td style="text-align: center;"><?php echo $result['soluongban'].' sản phẩm' ?></td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">TỔNG ĐƠN HÀNG</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>ID đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Đơn hàng</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>MD0837</td>
                                    <td>Triệu Thanh Phú</td>
                                    <td>Ghế làm việc Zuno, Bàn ăn gỗ Theresa</td>
                                    <td>2 sản phẩm</td>
                                    <td>9.400.000 đ</td>
                                </tr>
                                <tr>
                                    <td>MĐ8265</td>
                                    <td>Nguyễn Thị Ngọc Cẩm</td>
                                    <td>Ghế ăn gỗ Lucy màu trắng</td>
                                    <td>1 sản phẩm</td>
                                    <td>3.800.000 đ</td>   
                                </tr>
                                <tr>
                                    <td>MT9835</td>
                                    <td>Đặng Hoàng Phúc</td>
                                    <td>Giường ngủ Jimmy, Bàn ăn mở rộng cao cấp Dolas, Ghế làm việc Zuno</td>
                                    <td>3 sản phẩm</td>
                                    <td>40.650.000 đ</td>
                                </tr>
                                <tr>
                                    <td>ER3835</td>
                                    <td>Nguyễn Thị Mỹ Yến</td>
                                    <td>Bàn ăn mở rộng Gepa</td>
                                    <td>1 sản phẩm</td>
                                    <td>16.770.000 đ</td>
                                </tr>
                                <tr>
                                    <td>AL3947</td>
                                    <td>Phạm Thị Ngọc</td>
                                    <td>Bàn ăn Vitali mặt đá, Ghế ăn gỗ Lucy màu trắng</td>
                                    <td>2 sản phẩm</td>
                                    <td>19.770.000 đ</td>
                                </tr>
                                <tr>
                                    <td>QY8723</td>
                                    <td>Ngô Thái An</td>
                                    <td>Giường ngủ Kara 1.6x2m</td>
                                    <td>1 sản phẩm</td>
                                    <td>14.500.000 đ</td>
                                </tr>
                                <tr>
                                    <th colspan="4">Tổng cộng:</th>
                                    <td>104.890.000 đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">SẢN PHẨM ĐÃ HẾT</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Ảnh</th>
                                    <th>Số lượng</th>
                                    <th>Tình trạng</th>
                                    <th>Giá tiền</th>
                                    <th>Danh mục</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>83826226</td>
                                    <td>Tủ ly - tủ bát</td>
                                    <td><img src="/img-sanpham/tu.jpg" alt="" width="100px;"></td>
                                    <td>0</td>
                                    <td><span class="badge bg-danger">Hết hàng</span></td>
                                    <td>2.450.000 đ</td>
                                    <td>Tủ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">NHÂN VIÊN MỚI</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Họ và tên</th>
                                    <th>Địa chỉ</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>SĐT</th>
                                    <th>Chức vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hồ Thị Thanh Ngân</td>
                                    <td>155-157 Trần Quốc Thảo, Quận 3, Hồ Chí Minh </td>
                                    <td>12/02/1999</td>
                                    <td>Nữ</td>
                                    <td>0926737168</td>
                                    <td>Bán hàng</td>
                                </tr>
                                <tr>
                                    <td>Trần Khả Ái</td>
                                    <td>6 Nguyễn Lương Bằng, Tân Phú, Quận 7, Hồ Chí Minh</td>
                                    <td>22/12/1999</td>
                                    <td>Nữ</td>
                                    <td>0931342432</td>
                                    <td>Bán hàng</td>
                                </tr>
                                <tr>
                                    <td>Nguyễn Đặng Trọng Nhân</td>
                                    <td>59C Nguyễn Đình Chiểu, Quận 3, Hồ Chí Minh </td>
                                    <td>23/07/1996</td>
                                    <td>Nam</td>
                                    <td>0846881155</td>
                                    <td>Dịch vụ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                <h3 class="tile-title">Thống kê doanh thu theo 12 tháng</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                <h3 class="tile-title">Tổng đơn hàng thành công theo 12 tháng</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                <h3 class="tile-title">Thống kê doanh thu theo năm</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="lineChartDemo_year"></canvas>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                <h3 class="tile-title">Tổng đơn hàng thành công theo năm</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="barChartDemo_year"></canvas>
                </div>
                </div>
            </div>
        </div>

        
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/chart.js"></script>
    <script type="text/javascript">
        var order = {
        labels: [
                    <?php 
                    $statistical_month = $order -> statistical();
                    if (isset($statistical_month)) {
                        while ($result = $statistical_month -> fetch_assoc()) {
                        echo "'Tháng ".$result['Month']."',";
                        }
                    } 
                    ?>
                ],
        datasets: [
            {
            label: "Tổng đơn hàng theo 12 tháng",
            fillColor: "rgba(255, 213, 59, 0.767), 212, 59)",
            strokeColor: "rgb(255, 212, 59)",
            pointColor: "rgb(255, 212, 59)",
            pointStrokeColor: "rgb(255, 212, 59)",
            pointHighlightFill: "rgb(255, 212, 59)",
            pointHighlightStroke: "rgb(255, 212, 59)",
            data: [
                    <?php
                        $statistical = $order -> statistical();
                        if (isset($statistical)) {
                        $i = 0;
                        while ($result = $statistical -> fetch_assoc()) {
                            echo $result['Tongdonhang'].',';
                        }
                        }  
                    ?>
                    ]
            }
        ]
        };

        var turnover = {
        labels: [
                    <?php 
                    $statistical_month = $order -> statistical();
                    if (isset($statistical_month)) {
                        while ($result = $statistical_month -> fetch_assoc()) {
                        echo "'Tháng ".$result['Month']."',";
                        }
                    } 
                    ?>
                ],
        datasets: [
            {
            label: "Thống kê doanh thu theo 12 tháng",
            fillColor: "rgba(9, 109, 239, 0.651)  ",
            pointColor: "rgb(9, 109, 239)",
            strokeColor: "rgb(9, 109, 239)",
            pointStrokeColor: "rgb(9, 109, 239)",
            pointHighlightFill: "rgb(9, 109, 239)",
            pointHighlightStroke: "rgb(9, 109, 239)",
            data: [
                    <?php
                        $statistical_turnover = $order -> statistical();
                        if (isset($statistical_turnover)) {
                        $i = 0;
                        while ($result = $statistical_turnover -> fetch_assoc()) {
                            echo "'".$result['Doanhthu']."',";
                        }
                        }  
                    ?>
                    ]
            }
        ]
        };


        // 
        var order_year = {
        labels: [
                    <?php 
                    $statistical_year = $order -> statistical_year();
                    if (isset($statistical_year)) {
                        while ($result = $statistical_year -> fetch_assoc()) {
                        echo "'Năm ".$result['Year']."',";
                        }
                    } 
                    ?>
                ],
        datasets: [
            {
            label: "Tổng đơn hàng theo năm",
            fillColor: "rgba(255, 213, 59, 0.767), 212, 59)",
            strokeColor: "rgb(255, 212, 59)",
            pointColor: "rgb(255, 212, 59)",
            pointStrokeColor: "rgb(255, 212, 59)",
            pointHighlightFill: "rgb(255, 212, 59)",
            pointHighlightStroke: "rgb(255, 212, 59)",
            data: [
                    <?php
                        $statistical_year = $order -> statistical_year();
                        if (isset($statistical_year)) {
                        $i = 0;
                        while ($result = $statistical_year -> fetch_assoc()) {
                            echo $result['Tongdonhang'].',';
                        }
                        }  
                    ?>
                    ]
            }
        ]
        };

        var turnover_year = {
        labels: [
                    <?php 
                    $statistical_year = $order -> statistical_year();
                    if (isset($statistical_year)) {
                        while ($result = $statistical_year -> fetch_assoc()) {
                        echo "'Năm ".$result['Year']."',";
                        }
                    } 
                    ?>
                ],
        datasets: [
            {
            label: "Thống kê doanh thu theo năm",
            fillColor: "rgba(9, 109, 239, 0.651)  ",
            pointColor: "rgb(9, 109, 239)",
            strokeColor: "rgb(9, 109, 239)",
            pointStrokeColor: "rgb(9, 109, 239)",
            pointHighlightFill: "rgb(9, 109, 239)",
            pointHighlightStroke: "rgb(9, 109, 239)",
            data: [
                    <?php
                        $statistical_turnover_year = $order -> statistical_year();
                        if (isset($statistical_turnover_year)) {
                        $i = 0;
                        while ($result = $statistical_turnover_year -> fetch_assoc()) {
                            echo "'".$result['Doanhthu']."',";
                        }
                        }  
                    ?>
                    ]
            }
        ]
        };


        var ctxl = $("#lineChartDemo").get(0).getContext("2d");
        var lineChart = new Chart(ctxl).Line(turnover);

        var ctxb = $("#barChartDemo").get(0).getContext("2d");
        var barChart = new Chart(ctxb).Bar(order);

        var ctxl_year = $("#lineChartDemo_year").get(0).getContext("2d");
        var lineChart_year = new Chart(ctxl_year).Line(turnover_year);

        var ctxb_year = $("#barChartDemo_year").get(0).getContext("2d");
        var barChart_year = new Chart(ctxb_year).Bar(order_year);

       
    </script>
    <!-- Google analytics script-->
    <script type="text/javascript">
        if (document.location.hostname == 'pratikborsadiya.in') {
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-72504830-1', 'auto');
            ga('send', 'pageview');
        }
    </script>
</body>

</html>