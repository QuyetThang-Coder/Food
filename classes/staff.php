<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class staff  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function insert_staff($data,$files)
        {
            
            $staff_name = mysqli_real_escape_string($this->db->link, $data['staff_name']);
            $staff_phone = mysqli_real_escape_string($this->db->link, $data['staff_phone']);
            $staff_email = mysqli_real_escape_string($this->db->link, $data['staff_email']);
            $staff_birthday = mysqli_real_escape_string($this->db->link, $data['staff_birthday']);
            $staff_sex = mysqli_real_escape_string($this->db->link, $data['staff_sex']);
            $staff_address = mysqli_real_escape_string($this->db->link, $data['staff_address']);
            $position = mysqli_real_escape_string($this->db->link, $data['position']);

            // Kiểm tra ảnh và tải lên upload
            $permited = array('jpg','png','jpeg', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/staff/".$unique_image;
            
            if ($staff_name == '' || $staff_phone == '' || $staff_email == '' || $staff_birthday == '' || $staff_sex == '' || $staff_address == '' || $position == '' || $file_name == '' ) {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Không được để trống các trường',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            } else {
                move_uploaded_file($file_temp,$uploaded_image);
                $query = "INSERT INTO tbl_staff(staff_name,staff_image,staff_phone,staff_email,staff_birthday,staff_sex,staff_address,position)
                          VALUE('$staff_name','$unique_image','$staff_phone','$staff_email','$staff_birthday','$staff_sex','$staff_address','$position')";
                $result = $this ->db -> insert($query);

                if($result) {
                    $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thành công',
                                            text: 'Thêm nhân viên thành công',
                                            icon: 'success',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                    return $alert;
                } else {
                    $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Thêm nhân viên không thành công',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                    return $alert;
                }
            }
        }

        public function show_staff()
        {
            $query = "SELECT * FROM tbl_staff, tbl_position WHERE tbl_staff.position = tbl_position.position_id ORDER BY tbl_staff.staff_id DESC";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function delete_staff($id)
        {
            $query = "DELETE FROM tbl_staff WHERE staff_id = '$id'";
            $result = $this ->db -> delete($query);
            if ($result) {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thành công',
                                        text: 'Xóa nhân viên thành công',
                                        icon: 'success',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            } else {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Xóa nhân viên không thành công',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            }
            return $result;
        }

        public function update_staff($data,$file,$id)
        {      
            $staff_name = mysqli_real_escape_string($this->db->link, $data['staff_name']);
            $staff_phone = mysqli_real_escape_string($this->db->link, $data['staff_phone']);
            $staff_email = mysqli_real_escape_string($this->db->link, $data['staff_email']);
            $staff_birthday = mysqli_real_escape_string($this->db->link, $data['staff_birthday']);
            $staff_sex = mysqli_real_escape_string($this->db->link, $data['staff_sex']);
            $staff_address = mysqli_real_escape_string($this->db->link, $data['staff_address']);
            $position = mysqli_real_escape_string($this->db->link, $data['position']);

            // Kiểm tra ảnh và tải lên upload
            $permited = array('jpg','png','jpeg', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/staff/".$unique_image;

            if ($staff_name == '' || $staff_phone == '' || $staff_email == '' || $staff_birthday == '' || $staff_sex == '' || $staff_address == '' || $position == '') {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Không được để trống các trường',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            } else {
                if(!empty($file_name)) {
                    if($file_size > 2048000) {
                        $alert = "<span class='error'>Kích thước hình ảnh phải nhỏ hơn 2MB</span>";
                        return $alert;
                    } else if(in_array($file_ext,$permited) == false) {
                        $alert = "<span class='error'>Những file có thể tải lên ".implode(', ',$permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp,$uploaded_image);
                    $query = "UPDATE tbl_staff set 
                              staff_name = '$staff_name', 
                              staff_image = '$unique_image', 
                              staff_phone = '$staff_phone',
                              staff_email = '$staff_email',
                              staff_birthday = '$staff_birthday',
                              staff_sex = '$staff_sex',
                              staff_address = '$staff_address',
                              position = '$position' 
                              WHERE staff_id = '$id'";
                    $result = $this ->db -> update($query);
                    if($result) {
                        $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Sửa nhân viên thành công',
                                                icon: 'success',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;
                    } else {
                        $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thất bại',
                                                text: 'Sửa nhân viên không thành công',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;
                    }
                } else {
                    $query = "UPDATE tbl_staff set 
                              staff_name = '$staff_name', 
                              staff_phone = '$staff_phone',
                              staff_email = '$staff_email',
                              staff_birthday = '$staff_birthday',
                              staff_sex = '$staff_sex',
                              staff_address = '$staff_address',
                              position = '$position'
                              WHERE staff_id = '$id'";
                    $result = $this ->db -> update($query);
                    if($result) {
                        $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Sửa nhân viên thành công',
                                                icon: 'success',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;
                    } else {
                        $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thất bại',
                                                text: 'Sửa nhân viên không thành công',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;
                    }
                }
            }      
        }

        public function getstaffbyid($id)
        {
            $query = "SELECT * FROM tbl_staff WHERE tbl_staff.staff_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function getstaffbysession($id)
        {
            $query = "SELECT * FROM tbl_staff WHERE tbl_staff.staff_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_staff()
        {
            $query = "SELECT COUNT(*) AS sum_staff FROM tbl_staff ";
            $result = $this -> db -> select($query);
            if($result) {
                return $result;
            }
        }
    }
?>