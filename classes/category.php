<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class category  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function show_category()
        {
            $query = "SELECT * FROM tbl_category";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function insert_category($data)
        {
            $category_name = mysqli_real_escape_string($this->db->link, $data['category_name']);

            
            if ($category_name == '') {
                $alert = "<span class='error'>Không được để trống các trường</span>";
                return $alert;
            } else {
                $query = "INSERT INTO tbl_category(category_name)
                          VALUE('$category_name')";
                $result = $this ->db -> insert($query);

                if($result) {
                    $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Thêm danh mục thành công',
                                                icon: 'success',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;
                    return $alert;
                } else {
                    $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thất bại',
                                                text: 'Thêm danh mục thất bại',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;
                }
            }
        }

        // Front end
        public function getallcategory()
        {
            $query = "SELECT * FROM tbl_category";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function getcategorybyid($id)
        {
            $query = "SELECT * FROM tbl_category WHERE category_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }
    }
?>