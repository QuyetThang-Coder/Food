<?php include_once './inc/side_bar.php'; ?>
<?php include_once '../classes/position.php';  ?>
<?php include_once '../classes/staff.php';  ?>

<?php 
    $position = new position;
    $staff = new staff;
    if (!isset($_GET['edit_staff']) || $_GET['edit_staff'] == NULL) {
		echo "<script>window.location = 'QL_NhanVien.php'</script>";
	} else {
        $staff_id = $_GET['edit_staff'];
    }
    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['save']) ) {
        
        $updatestaff = $staff->update_staff($_POST,$_FILES,$staff_id);
    }
?>

<script src="js/admin/nhan_vien_add.js"></script>
<link rel="stylesheet" href="css/nhan_vien_add.css">
<style> 
  .qlnv {
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
        <li class="breadcrumb-item"><a href="QL_NhanVien.php">Danh sách nhân viên</a></li>
        <li class="breadcrumb-item"><a href="#">Thêm nhân viên</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">

        <div class="tile">

          <h3 class="tile-title">Tạo mới nhân viên</h3>
          <div class="tile-body">
            <div class="row element-button">

            </div>
            <form class="row" enctype="multipart/form-data" method="POST">
                <div class="form-group col-md-12">
                    <?php 
                    if (isset($updatestaff)) {
                        echo $updatestaff;
                    }
                    ?>
                </div>
                <?php 
                    $get_staff = $staff -> getstaffbyid($staff_id);
                    if(isset($get_staff)) {
                        while($result_staff = $get_staff -> fetch_assoc()) {
                ?>
                    <div class="form-group col-md-4">
                        <label class="control-label">ID nhân viên</label>
                        <input class="form-control" type="text" name="staff_id" readonly value="<?php echo $result_staff['staff_id'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Họ và tên</label>
                        <input class="form-control" type="text" name="staff_name" value="<?php echo $result_staff['staff_name'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group  col-md-4">
                        <label class="control-label">Số điện thoại</label>
                        <input class="form-control" type="number" name="staff_phone" value="<?php echo $result_staff['staff_phone'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Địa chỉ email</label>
                        <input class="form-control" type="text" name="staff_email" value="<?php echo $result_staff['staff_email'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Ngày sinh</label>
                        <input class="form-control" type="date" name="staff_birthday" value="<?php echo $result_staff['staff_birthday'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Giới tính</label>
                        <select class="form-control" id="exampleSelect2" name="staff_sex">
                            <option <?php if ($result_staff['staff_sex'] == '0') { echo 'selected'; } ?> value="0">Nam</option>
                            <option <?php if ($result_staff['staff_sex'] == '1') { echo 'selected'; } ?> value="1">Nữ</option>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label class="control-label">Địa chỉ thường trú</label>
                        <input class="form-control" type="text" name="staff_address" value="<?php echo $result_staff['staff_address'] ?>" autocomplete="off" required>
                    </div>

                    <div class="form-group  col-md-4">
                        <label for="exampleSelect1" class="control-label">Chức vụ</label>
                        <select class="form-control" id="exampleSelect1" name="position">
                        <?php
                            $show_position_add = $position -> show_position();
                            if (isset($show_position_add)) {
                            while ($result_position = $show_position_add -> fetch_assoc()) {
                        ?>
                            <option 
                                <?php if ($result_staff['position'] == $result_position['position_id']) { echo 'selected'; } ?>
                                value="<?php echo $result_position['position_id']; ?>"><?php echo $result_position['position_name']; ?>
                            </option>
                        <?php } } ?>
                        
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="btn-upload">
                        <label class="control-label">Ảnh sản phẩm</label> <br>
                        <div id="displayImg">
                            <img src="uploads/staff/<?php echo $result_staff['staff_image'] ?>" alt="">
                        </div>
                        <input type="file" onchange="ImagesFileAsURL()" name="image" id="upload">
                        <button id="btn"  class="btn">Chọn ảnh</button>
                        </label>
                    </div>
                    <button class="save btn btn-save" style="margin-left: 10px; margin-right: 10px;" onclick="myFunction()" type="submit" name="save" >Lưu lại</button>
                    <a class="btn btn-cancel" href="QL_NhanVien.php">Hủy bỏ</a>
                <?php } } ?>
            </form>
          </div>
  </main>

  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>


  <script type="text/javascript">
    function ImagesFileAsURL() {
      var fileSelected = document.getElementById('upload').files;
      if (fileSelected.length > 0) {
        var fileToLoad = fileSelected[0];
        var fileReader = new FileReader();
        fileReader.onload = function(fileLoaderEvent) {
            var srcData = fileLoaderEvent.target.result;
            var newImage = document.createElement('img');
            newImage.src = srcData;
            document.getElementById('displayImg').innerHTML = newImage.outerHTML;
        }
        fileReader.readAsDataURL(fileToLoad);
      }
    }
  </script>
</body>

</html>