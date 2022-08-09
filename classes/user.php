<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/session.php');
    Session::checkLogin_user();
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class user  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new Database();            
            $this->fm = new Format();            
        }

        public function show_user()
        {
            $query = "SELECT * FROM tbl_user";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_user()
        {
            $query = "SELECT COUNT(*) AS SUM_USER FROM tbl_user";
            $result = $this ->db -> select($query);
            return $result;
        }

        //  Front end
        public function login_user($userUser,$userPass)
        {
            $userUser = $this->fm->validation($userUser);    
            $userPass = $this->fm->validation($userPass);
            
            $userUser = mysqli_real_escape_string($this->db->link, $userUser);
            $userPass = mysqli_real_escape_string($this->db->link, $userPass);

            if (empty($userUser) || empty($userPass)) {
                $alert = "<span class='error'>Không được để trống User và Password</span>";
                return $alert;
            } else {
                $query = "SELECT * FROM tbl_user where user_phone = '$userUser' and user_password = '".md5($userPass)."' LIMIT 1";
                $result = $this ->db -> select($query);
                
                if($result) {
                    $value = $result -> fetch_assoc();
                    Session::set('userLogin', true);
                    Session::set('cart', true);
                    Session::set('userId', $value['user_id']);

                    header('Location:index.php');
                } 
                else {
                    $alert = "<span class='error'>Tài khoản hoặc mật khẩu không chính xác</span>";
                    return $alert;
                }
            }
        }

        public function getuserbysession($id)
        {
            $query = "SELECT * FROM tbl_user WHERE tbl_user.user_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function register($data)
        {
            
            $register_name = mysqli_real_escape_string($this->db->link, $data['register_name']);
            $register_phone = mysqli_real_escape_string($this->db->link, $data['register_phone']);
            $register_email = mysqli_real_escape_string($this->db->link, $data['register_email']);
            $register_address = mysqli_real_escape_string($this->db->link, $data['register_address']);
            $register_pass = mysqli_real_escape_string($this->db->link, $data['register_pass']);
            $register_repass = mysqli_real_escape_string($this->db->link, $data['register_repass']);

            if (empty($register_name) || empty($register_phone) || empty($register_email) || empty($register_address) || empty($register_pass) || empty($register_repass)) {
                $alert = "<span class='error'>Không được để trống User và Password</span>";
                return $alert;
            } if ($register_pass != $register_repass) {
                $alert = "<span class='error'>Mật khẩu không trùng nhau</span>";
                return $alert;
            } else {
                $check_phone = "SELECT * FROM tbl_user WHERE user_phone = '$register_phone'";
                $result_check_phone = $this -> db -> select($check_phone);
                if ($result_check_phone) {
                    $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Số điện thoại đã được đăng ký',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                    return $alert;
                }
                $check_email = "SELECT * FROM tbl_user WHERE user_email = '$register_email'";
                $result_check_email = $this -> db -> select($check_email);
                if ($result_check_email) {
                    $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Email đã được đăng ký',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                    return $alert;
                } else {
                    $regex_phone = "/^(032|033|034|035|036|037|038|039|086|096|097|098|081|082|083|084|085|088|091|094|056|058|092|070|076|077|078|079|089|090|093|099|059)+([0-9]{7})$/"; 
                    $result_phone = preg_match($regex_phone,$register_phone) ;
                    if(!$result_phone) { 
                        $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Số điện thoại không hợp lệ',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                        return $alert;
                    } else {
                        $regex_email = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/"; 
                        $result_email = preg_match($regex_email,$register_email) ;
                        if(!$result_email) { 
                            $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Email không hợp lệ',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                            return $alert;
                        } else {
                            $query =    "INSERT INTO tbl_user(user_name,user_phone,user_email,user_address,user_password)
                                VALUES ('$register_name','$register_phone','$register_email','$register_address','".md5($register_pass)."')";
                            $result = $this ->db -> insert($query);
                            
                            if($result) {
                                $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thành công',
                                                    text: 'Đăng ký thành công',
                                                    icon: 'success',
                                                    button: 'Cancel',
                                                })
                                            }
                                        </script>";
                                return $alert;
                            } 
                            else {
                                $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thất bại',
                                                    text: 'Đăng ký không thành công',
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
            }
        }

        public function update_user($id,$data)
        {
            $user_name = mysqli_real_escape_string($this->db->link, $data['user_name']);
            $user_phone = mysqli_real_escape_string($this->db->link, $data['user_phone']);
            $user_email = mysqli_real_escape_string($this->db->link, $data['user_email']);
            $user_address = mysqli_real_escape_string($this->db->link, $data['user_address']);
            $id = mysqli_real_escape_string($this->db->link, $id);

            $query =    "UPDATE tbl_user SET 
                        user_name = '$user_name',
                        user_phone = '$user_phone',
                        user_email = '$user_email',
                        user_address = '$user_address'
                        WHERE user_id = '$id'";
            $result = $this ->db -> update($query);
            
            if ($result) {
                $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thành công',
                                            text: 'Thông tin đã được sửa',
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
                                            text: 'Thông tin chưa được sửa',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                            </script>";
                return $alert;
            }
        }

        public function update_pass($id,$data,$re_pass)
        {
            $pass_old = mysqli_real_escape_string($this->db->link, $data['pass_old']);
            $pass = mysqli_real_escape_string($this->db->link, $data['pass']);
            $repassword = mysqli_real_escape_string($this->db->link, $data['repassword']);
            $id = mysqli_real_escape_string($this->db->link, $id);

            if($pass == '' || $pass_old == '' || $repassword = '') {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Vui lòng nhập đầy đủ các trường',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            } if ($re_pass != $pass) {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Mật khẩu không trùng nhau',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            } else {
                $check_pass = "SELECT * FROM tbl_user WHERE user_id = '$id' AND user_password = '".md5($pass_old)."'";
                $result_check = $this -> db -> select($check_pass);
                if ($result_check) {
                    $query =    "UPDATE tbl_user SET 
                                user_password = '".md5($pass)."'
                                WHERE user_id = '$id'";
                    $result = $this ->db -> update($query);
                    
                    if ($result) {
                        $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Thông tin đã được sửa',
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
                                                text: 'Thông tin chưa được sửa',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;
                    }
                } else {
                    $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thất bại',
                                                text: 'Mật khẩu cũ không chính xác',
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
?>