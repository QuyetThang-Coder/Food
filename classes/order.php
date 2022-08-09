<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class order  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function statistical()
        {
            $query =    "SELECT COUNT(order_id) as Tongdonhang, SUM(order_price) as Doanhthu, month(order_date) AS Month
                        FROM tbl_order
                        WHERE year(order_date) = year(curdate())
                        AND status = 2
                        GROUP BY month(order_date)
                        ORDER BY Month ";
            $result = $this -> db -> select($query);
            return $result;
        }

        public function statistical_year()
        {
            $query =    "SELECT COUNT(order_id) as Tongdonhang, SUM(order_price) as Doanhthu, year(order_date) AS Year
                        FROM tbl_order
                        WHERE status = 2
                        GROUP BY year(order_date)
                        ORDER BY Year; ";
            $result = $this -> db -> select($query);
            return $result;
        }

        public function sum_order()
        {
            $query = "SELECT COUNT(*) AS SUM_ORDER FROM tbl_order WHERE status = 2";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_orderbymonth()
        {
            $query = "SELECT COUNT(*) AS SUM_ORDER FROM tbl_order WHERE status = 2 AND month(curdate()) = month(order_date) AND year(curdate()) = year(order_date) ";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_ordercancelbymonth()
        {
            $query = "SELECT COUNT(*) AS SUM_ORDER FROM tbl_order WHERE status = 3 AND month(curdate()) = month(order_date) AND year(curdate()) = year(order_date) ";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_total()
        {
            $query = "SELECT SUM(order_price) AS sum_price FROM tbl_order WHERE status = 2 AND month(curdate()) = month(order_date) AND year(curdate()) = year(order_date) ";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_status_handle()
        {
            $query = "SELECT COUNT(*) AS sum FROM tbl_order WHERE status = 0";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function show_order_all()
        {
            $query = "SELECT * FROM tbl_order ORDER BY order_id DESC";
            $result = $this ->db -> select($query);
            // print_r($result -> fetch_assoc());
            // die();
            return $result;
        }

        public function show_orderbyid($id)
        {
            $query = "SELECT * FROM tbl_order WHERE order_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function update_order_delivery($id)
        {
            $query = "UPDATE tbl_order SET status = '1' WHERE order_id = '$id'";
            $result = $this ->db -> update($query);
            return $result;
        }

        public function update_order_success($id)
        {
            $query = "UPDATE tbl_order SET status = '2' WHERE order_id = '$id'";
            $result = $this ->db -> update($query);
            return $result;
        }

        // Front end
        public function insert_order_cod($data,$id,$total_sum,$sale_id,$sale_price)
        {
            
            $id = Session::get("userId");
            $order_name = mysqli_real_escape_string($this->db->link, $data['name']);
            $order_phone = mysqli_real_escape_string($this->db->link, $data['phone']);
            $order_address = mysqli_real_escape_string($this->db->link, $data['address']);
            
            if($sale_id == '0') {
                $query_order = "INSERT INTO tbl_order(order_user,order_name,order_address,order_phone,sale_price,order_price)
                                VALUE('$id','$order_name','$order_address','$order_phone','$sale_price','$total_sum')";
                $insert_order = $this -> db -> insert_id($query_order);

                if($insert_order) {
                    $order_id = $insert_order;
                    $query = "SELECT * FROM tbl_cart WHERE user_id = '$id'"; 
                    $get_product = $this ->db -> select($query);

                    if($get_product) {
                        while ($row = $get_product -> fetch_assoc()) {
                            $into_money = $row['cart_price'] * $row['cart_quantity'];   
                            $query_order_detail = "INSERT INTO tbl_order_detail(order_id,product_id,product_name,product_image,product_quantity,product_price)
                                            VALUE('$order_id','".$row['product_id']."','".$row['cart_name']."','".$row['cart_image']."','".$row['cart_quantity']."','$into_money')";
                            $insert_order_detail = $this -> db -> insert($query_order_detail);
                            if($insert_order_detail) {
                                $query_delete_cart = "DELETE FROM tbl_cart WHERE cart_id = '".$row['cart_id']."'";
                                $delete = $this -> db -> delete($query_delete_cart);
                            }
                        }
                        if($delete) {
                            $alert = "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Đặt hàng thành công',
                                                icon: 'success',
                                                button: 'Cancel',
                                            })
                                            .then((willDelete) => {
                                                if (willDelete) {
                                                    window.location='index.php';
                                                }
                                            });
                                        }
                                    </script>";
                            return $alert;
                        } else {
                            $alert = "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thất bại',
                                                text: 'Đặt hàng không thành công thành công',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                            .then((willDelete) => {
                                                if (willDelete) {
                                                    window.location='index.php';
                                                }
                                            });
                                        }
                                    </script>";
                            return $alert;
                        }
                    } else {
                        $alert = "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Không có sản phẩm nào',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                window.location='index.php';
                                            }
                                        });
                                    }
                                </script>";
                        return $alert;
                    }  
                }
            }
            if($sale_id != '0') {
                $query_order = "INSERT INTO tbl_order(order_user,order_name,order_address,order_phone,sale_price,order_price)
                                VALUE('$id','$order_name','$order_address','$order_phone','$sale_price','$total_sum')";
                $insert_order = $this -> db -> insert_id($query_order);

                if($insert_order) {
                    $order_id = $insert_order;
                    $query = "SELECT * FROM tbl_cart WHERE user_id = '$id'"; 
                    $get_product1 = $this ->db -> select($query);

                    if($get_product1) {
                        while ($row = $get_product1 -> fetch_assoc()) {
                            $into_money = $row['cart_price'] * $row['cart_quantity'];   
                            $query_order_detail = "INSERT INTO tbl_order_detail(order_id,product_id,product_name,product_image,product_quantity,product_price)
                                            VALUE('$order_id','".$row['product_id']."','".$row['cart_name']."','".$row['cart_image']."','".$row['cart_quantity']."','$into_money')";
                            $insert_order_detail = $this -> db -> insert($query_order_detail);
                            if($insert_order_detail) {
                                $query_delete_cart = "DELETE FROM tbl_cart WHERE cart_id = '".$row['cart_id']."'";
                                $delete = $this -> db -> delete($query_delete_cart);
                            }
                        }
                        $query = "SELECT * FROM tbl_sale WHERE sale_id = '$sale_id'"; 
                        $get_product = $this ->db -> select($query);
                        if($get_product) {
                            while ($result = $get_product -> fetch_assoc()) {
                                $sale_remain = $result['sale_remain'] - 1;
                            }
                            $update_remain = "UPDATE tbl_sale SET sale_remain = '$sale_remain' WHERE sale_id = '$sale_id'"; 
                            $get_product = $this ->db -> update($update_remain);
                        }
                        if ($get_product) {
                            if($delete) {
                                $alert = "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thành công',
                                                    text: 'Đặt hàng thành công',
                                                    icon: 'success',
                                                    button: 'Cancel',
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        window.location='index.php';
                                                    }
                                                });
                                            }
                                        </script>";
                                return $alert;
                            } else {
                                $alert = "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thất bại',
                                                    text: 'Đặt hàng không thành công thành công',
                                                    icon: 'error',
                                                    button: 'Cancel',
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        window.location='index.php';
                                                    }
                                                });
                                            }
                                        </script>";
                                return $alert;
                            }
                        }
                    } else {
                        $alert = "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Không có sản phẩm nào',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                window.location='index.php';
                                            }
                                        });
                                    }
                                </script>";
                        return $alert;
                    }  
                }
            }
        }

        public function insert_order_onl($id,$name,$phone,$address,$total_sum,$sale_id,$sale_price)
        {
            
            
            $order_name = mysqli_real_escape_string($this->db->link, $name);
            $order_phone = mysqli_real_escape_string($this->db->link, $phone);
            $order_address = mysqli_real_escape_string($this->db->link, $address);
            
            if($sale_id == '0') {
                $query_order = "INSERT INTO tbl_order(order_user,order_name,order_address,order_phone,sale_price,order_price,payment)
                                VALUE('$id','$order_name','$order_address','$order_phone','$sale_price','$total_sum','1')";
                $insert_order = $this -> db -> insert_id($query_order);

                if($insert_order) {
                    $order_id = $insert_order;
                    $query = "SELECT * FROM tbl_cart WHERE user_id = '$id'"; 
                    $get_product = $this ->db -> select($query);

                    if($get_product) {
                        while ($row = $get_product -> fetch_assoc()) {
                            $into_money = $row['cart_price'] * $row['cart_quantity'];   
                            $query_order_detail = "INSERT INTO tbl_order_detail(order_id,product_id,product_name,product_image,product_quantity,product_price)
                                            VALUE('$order_id','".$row['product_id']."','".$row['cart_name']."','".$row['cart_image']."','".$row['cart_quantity']."','$into_money')";
                            $insert_order_detail = $this -> db -> insert($query_order_detail);
                            if($insert_order_detail) {
                                $query_delete_cart = "DELETE FROM tbl_cart WHERE cart_id = '".$row['cart_id']."'";
                                $delete = $this -> db -> delete($query_delete_cart);
                            }
                        }
                        if($delete) {
                            $alert = "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Đặt hàng thành công',
                                                icon: 'success',
                                                button: 'Cancel',
                                            })
                                            .then((willDelete) => {
                                                if (willDelete) {
                                                    window.location='index.php';
                                                }
                                            });
                                        }
                                    </script>";
                            return $alert;
                        } else {
                            $alert = "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thất bại',
                                                text: 'Đặt hàng không thành công thành công',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                            .then((willDelete) => {
                                                if (willDelete) {
                                                    window.location='index.php';
                                                }
                                            });
                                        }
                                    </script>";
                            return $alert;
                        }
                    } else {
                        $alert = "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Không có sản phẩm nào',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                window.location='index.php';
                                            }
                                        });
                                    }
                                </script>";
                        return $alert;
                    }  
                }
            }
            if($sale_id != '0') {
                $query_order = "INSERT INTO tbl_order(order_user,order_name,order_address,order_phone,sale_price,order_price,payment)
                                VALUE('$id','$order_name','$order_address','$order_phone','$sale_price','$total_sum','1')";
                $insert_order = $this -> db -> insert_id($query_order);

                if($insert_order) {
                    $order_id = $insert_order;
                    $query = "SELECT * FROM tbl_cart WHERE user_id = '$id'"; 
                    $get_product1 = $this ->db -> select($query);

                    if($get_product1) {
                        while ($row = $get_product1 -> fetch_assoc()) {
                            $into_money = $row['cart_price'] * $row['cart_quantity'];   
                            $query_order_detail = "INSERT INTO tbl_order_detail(order_id,product_id,product_name,product_image,product_quantity,product_price)
                                            VALUE('$order_id','".$row['product_id']."','".$row['cart_name']."','".$row['cart_image']."','".$row['cart_quantity']."','$into_money')";
                            $insert_order_detail = $this -> db -> insert($query_order_detail);
                            if($insert_order_detail) {
                                $query_delete_cart = "DELETE FROM tbl_cart WHERE cart_id = '".$row['cart_id']."'";
                                $delete = $this -> db -> delete($query_delete_cart);
                            }
                        }
                        $query = "SELECT * FROM tbl_sale WHERE sale_id = '$sale_id'"; 
                        $get_product = $this ->db -> select($query);
                        if($get_product) {
                            while ($result = $get_product -> fetch_assoc()) {
                                $sale_remain = $result['sale_remain'] - 1;
                            }
                            $update_remain = "UPDATE tbl_sale SET sale_remain = '$sale_remain' WHERE sale_id = '$sale_id'"; 
                            $get_product = $this ->db -> update($update_remain);
                        }
                        if ($get_product) {
                            if($delete) {
                                $alert = "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thành công',
                                                    text: 'Đặt hàng thành công',
                                                    icon: 'success',
                                                    button: 'Cancel',
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        window.location='index.php';
                                                    }
                                                });
                                            }
                                        </script>";
                                return $alert;
                            } else {
                                $alert = "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thất bại',
                                                    text: 'Đặt hàng không thành công thành công',
                                                    icon: 'error',
                                                    button: 'Cancel',
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        window.location='index.php';
                                                    }
                                                });
                                            }
                                        </script>";
                                return $alert;
                            }
                        }
                    } else {
                        $alert = "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Không có sản phẩm nào',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                window.location='index.php';
                                            }
                                        });
                                    }
                                </script>";
                        return $alert;
                    }  
                }
            }
        }

        public function getorderbyid($id)
        {
            $query = "SELECT * FROM tbl_order WHERE order_user = '$id' ORDER BY order_id DESC ";
            $result = $this -> db -> select($query);
            return $result;
        }

        public function getuserbyorder($id)
        {
            $query = "SELECT * FROM tbl_order WHERE order_id = '$id' ORDER BY order_id DESC ";
            $result = $this -> db -> select($query);
            return $result;
        }

        public function cancel_order($id,$user_id)
        {
            $select = "SELECT * FROM tbl_order WHERE order_id = '$id' AND order_user = '$user_id' AND status = '0'";
            $result_select = $this ->db -> select($select);
            if($result_select) {
                $query = "UPDATE tbl_order SET status = '3' WHERE order_id = '$id' and order_user = '$user_id'";
                $result = $this ->db -> update($query);
                if($result) {
                    $alert = "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thành công',
                                        text: 'Hủy đơn hàng thành công',
                                        icon: 'success',
                                        button: 'Cancel',
                                    })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            window.location='order.php';
                                        }
                                    });
                                }
                            </script>";
                    return $alert;
                } else {
                    $alert = "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Hủy đơn hàng không thành công',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            window.location='order.php';
                                        }
                                    });
                                }
                            </script>";
                    return $alert;
                }
            } else {
                $alert = "<script>
                            window.onload = function () {
                                swal({
                                    title: 'Thất bại',
                                    text: 'Đơn hàng đã được xử lý không thể hủy đơn',
                                    icon: 'error',
                                    button: 'Cancel',
                                })
                                .then((willDelete) => {
                                    if (willDelete) {
                                        window.location='order.php';
                                    }
                                });
                            }
                        </script>";
                return $alert;
            }
        }
    }
?>