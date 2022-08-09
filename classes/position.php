<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class position  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function show_position()
        {
            $query = "SELECT * FROM tbl_position";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function insert_position($data)
        {
            $position_name = mysqli_real_escape_string($this->db->link, $data['position_name']);

            
            if ($position_name == '') {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Không được bỏ trống các trường',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            } else {
                $query = "INSERT INTO tbl_position(position_name)
                          VALUE('$position_name')";
                $result = $this ->db -> insert($query);

                if($result) {
                    $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thành công',
                                            text: 'Thêm chức vụ thành công',
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
                                            text: 'Thêm chức vụ không thành công',
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