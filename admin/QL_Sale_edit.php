<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/sale.php';  ?>

<?php 
    $sale = new sale;
    if (!isset($_GET['edit_sale']) || $_GET['edit_sale'] == NULL) {
		  echo "<script>window.location = 'QL_Sale.php'</script>";
	  } else {
        $sale_id = $_GET['edit_sale'];
    }
    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['save']) ) {
        
        $updateSale = $sale->update_sale($_POST,$sale_id);
    }
?>

<style>
  .qlsl {
    background: #c6defd;
    text-decoration: none;
    color: rgb(22 22 72);
    box-shadow: none;
    border: 1px solid rgb(22 22 72);
  }
</style>
  <main class="app-content">
    <div class="app-title">
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="QL_Sale.php">Danh sách mã giảm giá</a></li>
        <li class="breadcrumb-item"><a href="#">Sửa mã giảm giá</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Sửa mã giảm giá</h3>
          <div class="tile-body">
            <form class="row" method="POST" enctype="multipart/form-data">
              <div class="form-group col-md-12">
                <?php 
                  if (isset($updateSale) && $updateSale != '0') {
                    echo $updateSale;
                  } if (isset($updateSale) && $updateSale == '0') {
                    echo "<script>window.location = 'QL_Sale.php'</script>";
                  }
                ?>
              </div>
              <?php 
                $get_sale = $sale -> getsalebyid($sale_id);
                if (isset($get_sale) && $get_sale == '0') { 
                  echo "<script>window.location = 'QL_Sale.php'</script>";
                }
                if (isset($get_sale) && $get_sale != '0') {
                    while ($result_sale = $get_sale -> fetch_assoc()) {
                ?>
                
                <div class="form-group col-md-3">
                  <label class="control-label">Mã giảm giá </label>
                  <input class="form-control" type="number" readonly placeholder="" value="<?php echo $result_sale['sale_id'] ?>" name="sale_id">
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label">Tên mã giảm giá</label>
                  <input class="form-control" type="text" required autocomplete="off" value="<?php echo $result_sale['sale_name'] ?>" name="sale_name">
                </div>
                <div class="form-group col-md-3">
                  <label for="exampleSelect1" class="control-label">Số tiền giảm</label>
                  <input class="form-control" type="number" required autocomplete="off" value="<?php echo $result_sale['sale_price'] ?>" name="sale_price">
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label">Điều kiện áp dụng (Đơn hàng trên .... vnđ)</label>
                  <input class="form-control" type="number" autocomplete="off" value="<?php echo $result_sale['sale_rule'] ?>" name="sale_rule">
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label">Số lượng</label>
                  <input class="form-control" type="number" autocomplete="off" value="<?php echo $result_sale['sale_quantity'] ?>" name="sale_quantity">
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label">Ngày bắt đầu</label>
                  <input class="form-control" type="datetime-local" required autocomplete="off" value="<?php echo $result_sale['start_day'] ?>" name="start_day">
                </div>
                <div class="form-group col-md-3">
                  <label class="control-label">Ngày kết thúc</label>
                  <input class="form-control" type="datetime-local" required autocomplete="off" value="<?php echo $result_sale['end_day'] ?>" name="end_day">
                </div>
                <div class="form-group col-md-12">
                  <button class="btn btn-save" style="margin-left: 10px; margin-right: 10px" name="save">Lưu lại</button>
                  <a class="btn btn-cancel" href="QL_Sale.php">Hủy bỏ</a>
                </div>
                
              <?php } } ?>
            </form>
          </div>
        </div>
  </main>


  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/plugins/pace.min.js"></script>


</body>

</html>