<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/session.php');
    Session::checkLogin();
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class adminlogin  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new Database();            
            $this->fm = new Format();            
        }

        public function login_admin($adminUser,$adminPass)
        {
            $adminUser = $this->fm->validation($adminUser);    
            $adminPass = $this->fm->validation($adminPass);
            
            $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
            $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

            if (empty($adminUser) || empty($adminPass)) {
                $alert = "<span class='error'>Không được để trống User và Password</span>";
                return $alert;
            } else {
                $query = "SELECT * FROM tbl_staff where staff_phone = '$adminUser' and staff_password = '".md5($adminPass)."' and position = 3 LIMIT 1";
                $result = $this ->db -> select($query);

                if($result != false ) {
                    $value = $result -> fetch_assoc();
                    Session::set('adminlogin', true);
                    Session::set('adminId', $value['staff_id']);

                    header('Location:index.php');
                } else {
                    $alert = "<span class='error'>Bạn không có quyền truy cập</span>";
                    return $alert;
                }
            }
        }
    }
?>