<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/order.php';  ?>

<?php 
  $order = new order;
?>
<style>
  .qldh {
    background: #c6defd;
    text-decoration: none;
    color: rgb(22 22 72);
    box-shadow: none;
    border: 1px solid rgb(22 22 72);
  }
</style>
    <main class="app-content">
      <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item active"><a href="#"><b>Danh sách đơn hàng
            <?php
              $sum_handle = $order -> sum_status_handle();
              if (isset($sum_handle)) {
                $i = 0;
                while ($result = $sum_handle -> fetch_assoc()) {
                  if($result['sum'] == 0) {

                  } else {
                    echo "(Còn ".$result['sum']." đơn hàng chờ xử lý)";
                  }
                }
              }
            ?>
          </b></a></li>
        </ul>
        <div id="clock"></div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="row element-button">
                <div class="col-sm-2">
                  <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                      class="fas fa-file-upload"></i> Tải từ file</a>
                </div>
  
                <div class="col-sm-2">
                  <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                      class="fas fa-print"></i> In dữ liệu</a>
                </div>
  
                <div class="col-sm-2">
                  <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                </div>
                <div class="col-sm-2">
                  <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                      class="fas fa-file-pdf"></i> Xuất PDF</a>
                </div>
              </div>
              <table class="table table-hover table-bordered table-striped" id="sampleTable">
                <thead>
                  <tr>
                    <th style="display: none;">STT</th>
                    <th>ID đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Địa chỉ nhận hàng</th>
                    <th>Số điện thoại</th>
                    <th>Giảm giá</th>
                    <th>Tổng tiền</th>
                    <th>Hình thức thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $show_order = $order -> show_order_all();
                    if (isset($show_order)) {
                      $i = 0;
                      while ($result = $show_order -> fetch_assoc()) {
                        $i++;
                  ?>
                    <tr>
                      <td style="display: none;"><?php echo $i ?></td>
                      <td style="text-align: center;"><?php echo $result['order_id']; ?></td>
                      <td style="text-align: center;"><?php echo $result['order_name'] ?></td>
                      <td style="text-align: center;"><?php echo $result['order_address'] ?></td>
                      <td style="text-align: center;"><?php echo $result['order_phone'] ?></td>
                      <td style="text-align: center;"><?php echo '- '.number_format($result['sale_price']).' vnđ' ?></td>
                      <td style="text-align: center;"><?php echo number_format($result['order_price']).' vnđ' ?></td>
                      <td style="text-align: center;">
                        <?php 
                          if($result['payment'] == 0) {
                            echo "COD";
                          } if ($result['payment'] == 1) {
                            echo 'Online';
                          }
                        ?>
                      </td>
                      <td style="text-align: center;">
                        <?php 
                          if($result['status'] == 0) {
                            echo '<span class="badge bg-info">Chờ xử lý</span>';
                          } if ($result['status'] == 1) {
                            echo '<span class="badge bg-warning">Đang giao hàng</span>';
                          } if ($result['status'] == 2) {
                            echo '<span class="badge bg-success">Hoàn thành</span>';
                          } if ($result['status'] == 3) {
                            echo '<span class="badge bg-danger">Đã hủy</span>';
                          }
                        ?>
                      </td>
                      <td style="text-align: center;"><?php echo date_format(date_create($result['order_date']),"d-m-Y").'<br>'.date_format(date_create($result['order_date']),"H:i:s") ?></td>
                      <td style="text-align: center;">
                        <a class="btn btn-primary btn-sm" style="background-color: #798aff; color: #fff" href="QL_DonHang_view.php?view_order=<?php echo $result['order_id']; ?>" title="Xem"><i class="fas fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="src/jquery.table2excel.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <!-- Page specific javascripts-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <!-- Data table plugin-->
  <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript">$('#sampleTable').DataTable();</script>
  <script>
    oTable = $('#sampleTable').dataTable();
    $('#all').click(function (e) {
      $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
      e.stopImmediatePropagation();
    });

    //EXCEL
    // $(document).ready(function () {
    //   $('#').DataTable({

    //     dom: 'Bfrtip',
    //     "buttons": [
    //       'excel'
    //     ]
    //   });
    // });


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