<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/category.php';  ?>
<?php include_once '../classes/product.php';  ?>

<?php 
  $product = new product;
  $category = new category;

  if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $deleteProduct = $product->delete_product($id);
  }
?>
<link rel="stylesheet" href="css/san_pham_add.css">
<style>
  .qlsp {
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
                <li class="breadcrumb-item active"><a href="#"><b>Danh sách sản phẩm</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-2">
              
                              <a class="btn btn-add btn-sm" href="QL_SanPham_add.php" title="Thêm"><i class="fas fa-plus"></i>
                                Tạo mới sản phẩm</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                                  class="fas fa-file-upload"></i> Tải từ file</a>
                            </div>
              
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                  class="fas fa-print"></i> In dữ liệu</a>
                            </div>
                            <!-- <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file js-textareacopybtn" type="button" title="Sao chép"><i
                                  class="fas fa-copy"></i> Sao chép</a>
                            </div> -->
                            <div class="col-sm-2">
                              <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                                  class="fas fa-file-pdf"></i> Xuất PDF</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i
                                  class="fas fa-trash-alt"></i> Xóa tất cả </a>
                            </div>
                          </div>
                          <div class="form-group col-md-12">
                            <?php 
                              if (isset($deleteProduct)) {
                                echo $deleteProduct;
                              }
                            ?>
                          </div>
                          <table class="table table-hover table-bordered table-striped sampleTable" cellpadding="0" cellspacing="0" id="sampleTable">
                              <thead>
                                <tr class="">
                                  <th width="10"><input type="checkbox" id="all"></th>
                                  <th width="30">STT</th>
                                  <th width="100">Tên sản phẩm</th>
                                  <th width="20">Ảnh</th>
                                  <th width="80">Giá tiền</th>
                                  <th width="100">Danh mục</th>
                                  <th>Mô tả</th>
                                  <th width="80">Chức năng</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  $show_product = $product -> show_product();
                                  if (isset($show_product)) {
                                    $i = 0;
                                    while ($result = $show_product -> fetch_assoc()) {
                                      $i++;
                                ?>
                                  <tr class="onRow">
                                      <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                      <td style="text-align: center;"><?php echo $i; ?></td>
                                      <td style="text-align: center;"><?php echo $result['product_name'] ?></td>
                                      <td style="text-align: center;"><img src="uploads/<?php echo $result['product_image'] ?>" alt="<?php echo $result['product_name'] ?>" width="100px;" class="img-card-person"></td>
                                      <td style="text-align: center;"><?php echo number_format($result['product_price']); ?> vnđ</td>
                                      <td style="text-align: center;"><?php echo $result['category_name'] ?></td>
                                      <td style="text-align: justify;"><?php echo $result['product_describe'] ?></td>
                                      <td style="text-align: center;">
                                        <a class="btn btn-primary btn-sm trash" href="?delete_product=<?php echo $result['product_id']; ?>" onclick="return confirm('Bạn có muốn xóa sản phẩm `<?php echo $result['product_name']; ?>` không?')" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                        <a class="btn btn-primary btn-sm edit show-emp" href="QL_SanPham_edit.php?edit_product=<?php echo $result['product_id']; ?>" title="Sửa"><i class="fas fa-edit"></i></a>
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
    <script type="text/javascript">
        $('#sampleTable').DataTable();
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
    <script>
        // function deleteRow(r) {
        //     var i = r.parentNode.parentNode.rowIndex;
        //     document.getElementById("myTable").deleteRow(i);
        // }
        // jQuery(function () {
        //     jQuery(".trash").click(function () {
        //         swal({
        //             title: "Cảnh báo",
        //             text: "Bạn có chắc chắn là muốn xóa sản phẩm này?",
        //             buttons: ["Hủy bỏ", "Đồng ý"],
        //         })
        //             .then((willDelete) => {
        //                 if (willDelete) {
        //                     swal("Đã xóa thành công.!", {

        //                     });
        //                 }
        //             });
        //     });
        // });
        oTable = $('#sampleTable').dataTable();
        $('#all').click(function (e) {
            $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
            e.stopImmediatePropagation();
        });
    </script>

</body>

</html>