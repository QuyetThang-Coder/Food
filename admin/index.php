<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/order.php';  ?>
<?php include_once '../classes/user.php';  ?>
<?php include_once '../classes/product.php';  ?>
<?php include_once '../classes/sale.php';  ?>

<?php 
  $order = new order;
  $user = new user;
  $product = new product;
  $sale = new sale;
?>
<style>
  .dashboard {
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
            <li class="breadcrumb-item"><a href="#"><b>Bảng điều khiển</b></a></li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <!--Left-->
      <div class="col-md-12 col-6">
        <div class="row">
       <!-- col-6 -->
       <div class="col-md-3">
        <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
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
            <p class="info-tong">Tổng số khách hàng được quản lý.</p>
          </div>
        </div>
      </div>
       <!-- col-6 -->
          <div class="col-md-3">
            <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
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
                <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
              </div>
            </div>
          </div>
           <!-- col-6 -->
          <div class="col-md-3">
            <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
              <div class="info">
                <h4>Tổng đơn hàng</h4>
                <p><b>
                  <?php
                    $sum_order = $order -> sum_order();
                    if (isset($sum_order)) {
                      $i = 0;
                      while ($result = $sum_order -> fetch_assoc()) {
                        echo $result['SUM_ORDER'].' khách hàng';
                      }
                    } 
                  ?>
                </b></p>
                <p class="info-tong">Tổng số đơn hàng đã hoàn thành.</p>
              </div>
            </div>
          </div>
           <!-- col-6 -->
          <div class="col-md-3">
            <div class="widget-small danger coloured-icon"><i class='icon bx bx-money'></i>
              <div class="info">
                <h4>Tổng mã giảm giá</h4>
                <p><b>
                  <?php
                    $sum_sale = $sale -> sum_sale_remain();
                    if (isset($sum_sale)) {
                      $i = 0;
                      while ($result = $sum_sale -> fetch_assoc()) {
                        echo $result['sum_sale'].' mã giảm giá';
                      }
                    } 
                  ?>
                </b></p>
                <p class="info-tong">Tổng số mã giảm giá còn hiệu lực.</p>
              </div>
            </div>
          </div>
           <!-- col-12 -->
           <!-- <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Tình trạng đơn hàng</h3>
              <div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID đơn hàng</th>
                      <th>Tên khách hàng</th>
                      <th>Tổng tiền</th>
                      <th>Trạng thái</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>AL3947</td>
                      <td>Phạm Thị Ngọc</td>
                      <td>
                        19.770.000 đ
                      </td>
                      <td><span class="badge bg-info">Chờ xử lý</span></td>
                    </tr>
                    <tr>
                      <td>ER3835</td>
                      <td>Nguyễn Thị Mỹ Yến</td>
                      <td>
                        16.770.000 đ	
                      </td>
                      <td><span class="badge bg-warning">Đang vận chuyển</span></td>
                    </tr>
                    <tr>
                      <td>MD0837</td>
                      <td>Triệu Thanh Phú</td>
                      <td>
                        9.400.000 đ	
                      </td>
                      <td><span class="badge bg-success">Đã hoàn thành</span></td>
                    </tr>
                    <tr>
                      <td>MT9835</td>
                      <td>Đặng Hoàng Phúc	</td>
                      <td>
                        40.650.000 đ	
                      </td>
                      <td><span class="badge bg-danger">Đã hủy	</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
           </div> -->
            <!-- / col-12 -->
             <!-- col-12 -->
            <!-- <div class="col-md-6">
                <div class="tile">
                  <h3 class="tile-title">Khách hàng mới</h3>
                <div>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Tên khách hàng</th>
                        <th>Ngày sinh</th>
                        <th>Số điện thoại</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>#183</td>
                        <td>Hột vịt muối</td>
                        <td>21/7/1992</td>
                        <td><span class="tag tag-success">0921387221</span></td>
                      </tr>
                      <tr>
                        <td>#219</td>
                        <td>Bánh tráng trộn</td>
                        <td>30/4/1975</td>
                        <td><span class="tag tag-warning">0912376352</span></td>
                      </tr>
                      <tr>
                        <td>#627</td>
                        <td>Cút rang bơ</td>
                        <td>12/3/1999</td>
                        <td><span class="tag tag-primary">01287326654</span></td>
                      </tr>
                      <tr>
                        <td>#175</td>
                        <td>Hủ tiếu nam vang</td>
                        <td>4/12/20000</td>
                        <td><span class="tag tag-danger">0912376763</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </div>
            </div> -->
             <!-- / col-12 -->
        </div>
      </div>
      <!--END left-->
      <!--Right-->
      <div class="col-md-12 col-lg-12">
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

      </div>
      <!--END right-->
    </div>

    
  </main>
  <script src="js/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="js/popper.min.js"></script>
  <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
  <!--===============================================================================================-->
  <script src="js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="js/main.js"></script>
  <!--===============================================================================================-->
  <script src="js/plugins/pace.min.js"></script>
  <!--===============================================================================================-->
  <script type="text/javascript" src="js/plugins/chart.js"></script>
  <!--===============================================================================================-->
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


  <script type="text/javascript">
    //Thời Gian
    function time() {
      var today = new Date();
      var weekday = new Array(7);
      weekday[0] = "Chủ Nhật";
      weekday[1] = "Thứ Hai";
      weekday[2] = "Thứ Ba";
      weekday[3] = "Thứ Tư";
      weekday[4] = "Thứ Năm";
      weekday[5] = "Thứ Sáu";
      weekday[6] = "Thứ Bảy";
      var day = weekday[today.getDay()];
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      nowTime = h + " giờ " + m + " phút " + s + " giây";
      if (dd < 10) {
        dd = '0' + dd
      }
      if (mm < 10) {
        mm = '0' + mm
      }
      today = day + ', ' + dd + '/' + mm + '/' + yyyy;
      tmp = '<span class="date"> ' + today + ' - ' + nowTime +
        '</span>';
      document.getElementById("clock").innerHTML = tmp;
      clocktime = setTimeout("time()", "1000", "Javascript");

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
    }
  </script>
</body>

</html>