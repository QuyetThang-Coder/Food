<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class cart  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function addtocart($quantity,$userId,$product_id)
        {
            $quantity = $this->fm->validation($quantity);   
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $product_id = mysqli_real_escape_string($this->db->link, $product_id);
            $user_id = mysqli_real_escape_string($this->db->link, $userId);

            $query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
            $result = $this -> db -> select($query) -> fetch_assoc();

            $check_cart = "SELECT * FROM tbl_cart WHERE product_id = '$product_id' AND user_id = '$user_id'";
            $result_check = $this -> db -> select($check_cart);
            if($result_check) {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Sản phẩm đã có trong giỏ hàng',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;
            } else {
                $query_insert = "INSERT INTO tbl_cart(user_id,product_id,cart_image,cart_name,cart_price,cart_quantity)
                          VALUE('$user_id','$product_id','".$result['product_image']."','".$result['product_name']."','".$result['product_price']."','$quantity')";
                $insert_cart = $this ->db -> insert($query_insert);

                if($insert_cart) {
                    Session::set("cart", true);
                    $alert =   "1";
                    return $alert;
                } else {
                    $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Sản phẩm chưa được thêm vào giỏ hàng',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                    return $alert;
                }
            }
        }

        public function show_cart_by_id($user_id)
        {
            $query = "SELECT * FROM tbl_cart WHERE user_id = '$user_id' ORDER BY cart_id DESC";
            $result = $this ->db -> select($query);
            if($result == false) {
                Session::set("cart", false);
                $alert = "<span class='error'>Không có sản phẩm nào trong giỏ hàng</span>";
                return $alert;
            }
            if($result) {
                Session::set("cart", true);
                return $result;
            }
        }

        public function delete_cart($id)
        {
            $delete = "DELETE FROM tbl_cart WHERE cart_id = '$id'";
            $result = $this ->db -> delete($delete);
            if ($result) {
                $alert =   "<script>location.reload();
                        </script>";
                return $alert;
            } else {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Sản phẩm chưa được xóa',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                        </script>";
                return $alert;
            }
            return $result;
        }

        public function update_quantity($id,$quantity)
        {
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $carId = mysqli_real_escape_string($this->db->link, $id);

            $query = "UPDATE tbl_cart SET cart_quantity = $quantity WHERE cart_id = '$id'";
            $result = $this ->db -> update($query);
            
            if ($result) {
                $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thành công',
                                            text: 'Sản phẩm đã được sửa',
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
                                            text: 'Sản phẩm chưa được sửa',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                            </script>";
                return $alert;
            }
        }

        public function show_sum_cart_by_id($user_id)
        {
            $query = "SELECT count(*) AS sum FROM tbl_cart WHERE user_id = '$user_id'";
            $result = $this ->db -> select($query);
            return $result;
        }
    }
?>