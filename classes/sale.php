<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class sale  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function show_sale()
        {
            $query = "SELECT * FROM tbl_sale ORDER BY sale_id DESC";
            $result = $this ->db -> select($query);
            if($result) {
                return $result;
            } else {
                $alert = '0';
                return $alert;
            }
        }

        public function delete_sale($id)
        {
            $query = "DELETE FROM tbl_sale WHERE sale_id = '$id'";
            $result = $this ->db -> delete($query);
            if ($result) {
                $alert = "<span class='success'>Xóa mã giảm giá thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Xóa mã giảm giá không thành công</span>";
                return $alert;
            }
            return $result;
        }

        public function getsalebyid($id)
        {
            $query = "SELECT * FROM tbl_sale WHERE sale_id = '$id'";
            $result = $this ->db -> select($query);
            if($result) {
                return $result;
            } else {
                $alert = '0';
                return $alert;
            }
            
        }

        public function update_sale($data,$id)
        {      
            $select = "SELECT * FROM tbl_sale WHERE sale_id = '$id'";
            $result_select = $this -> db -> select($select);
            if($result_select) {
                $sale_name = mysqli_real_escape_string($this->db->link, $data['sale_name']);
                $sale_price = mysqli_real_escape_string($this->db->link, $data['sale_price']);
                $sale_quantity = mysqli_real_escape_string($this->db->link, $data['sale_quantity']);
                $sale_rule = mysqli_real_escape_string($this->db->link, $data['sale_rule']);
                $start_day = mysqli_real_escape_string($this->db->link, $data['start_day']);
                $end_day = mysqli_real_escape_string($this->db->link, $data['end_day']);

                $handle_start_day = str_replace("T"," ",$start_day);
                $handle_end_day = str_replace("T"," ",$end_day);

                $select_name = "SELECT * FROM tbl_sale 
                                WHERE sale_name = '$sale_name' 
                                AND '$handle_start_day' < end_day 
                                AND sale_id NOT IN (SELECT sale_id FROM tbl_sale WHERE sale_id = '$id')";
                $result_name = $this -> db -> select($select_name);
                if($result_name) {
                    $alert =   "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Tên của mã giảm giá đang được sử dụng',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                    return $alert;
                } else {
                    if ($sale_name == '' || $sale_price == '' || $handle_start_day == '' || $handle_end_day == '') {
                        $alert = "Vui lòng nhập đầy đủ các trường";
                        return $alert;
                    } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity == '' && $sale_rule == '') {
                        $update =   "UPDATE tbl_sale SET 
                                    sale_name = '$sale_name',
                                    sale_price = '$sale_price',
                                    sale_quantity = '99999',
                                    sale_remain = '99999',
                                    sale_rule = '0',
                                    start_day = '$handle_start_day',
                                    end_day = '$handle_end_day'
                                    WHERE sale_id = '$id'";
                        
                        $result = $this -> db -> update($update);
                        if ($result) {
                            $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thành công',
                                                    text: 'Sửa mã giảm giá thành công',
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
                                                    text: 'Sửa mã giảm giá không thành công',
                                                    icon: 'error',
                                                    button: 'Cancel',
                                                })
                                            }
                                        </script>";
                            return $alert;
    
                        }
    
                    } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity != '' && $sale_rule == '') {
                        if ($sale_quantity < 10) {
                            $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thất bại',
                                                    text: 'Số lượng phải lớn hơn 10',
                                                    icon: 'error',
                                                    button: 'Cancel',
                                                })
                                            }
                                        </script>";
                            return $alert;
                        } else {
                            $update =   "UPDATE tbl_sale SET 
                                    sale_name = '$sale_name',
                                    sale_price = '$sale_price',
                                    sale_quantity = '$sale_quantity',
                                    sale_remain = '$sale_quantity',
                                    sale_rule = '0',
                                    start_day = '$handle_start_day',
                                    end_day = '$handle_end_day'
                                    WHERE sale_id = '$id'";
                        
                            $result = $this -> db -> update($update);
                            if ($result) {
                                $alert =   "<script>
                                                window.onload = function () {
                                                    swal({
                                                        title: 'Thành công',
                                                        text: 'Sửa mã giảm giá thành công',
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
                                                        text: 'Sửa mã giảm giá không thành công',
                                                        icon: 'error',
                                                        button: 'Cancel',
                                                    })
                                                }
                                            </script>";
                                return $alert;
    
                            }
                        }
    
                    } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity == '' && $sale_rule != '') {
                        $update =   "UPDATE tbl_sale SET 
                                    sale_name = '$sale_name',
                                    sale_price = '$sale_price',
                                    sale_quantity = '99999',
                                    sale_remain = '99999',
                                    sale_rule = '$sale_rule',
                                    start_day = '$handle_start_day',
                                    end_day = '$handle_end_day'
                                    WHERE sale_id = '$id'";
                        
                        $result = $this -> db -> update($update);
                        if ($result) {
                            $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thành công',
                                                    text: 'Sửa mã giảm giá thành công',
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
                                                    text: 'Sửa mã giảm giá không thành công',
                                                    icon: 'error',
                                                    button: 'Cancel',
                                                })
                                            }
                                        </script>";
                            return $alert;
    
                        }
    
                    } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity != '' && $sale_rule != '') {
                        if($sale_quantity < 10) {
                            $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thất bại',
                                                    text: 'Số lượng phải lớn hơn 10',
                                                    icon: 'error',
                                                    button: 'Cancel',
                                                })
                                            }
                                        </script>";
                            return $alert;
                        } else {
                            $update =   "UPDATE tbl_sale SET 
                                    sale_name = '$sale_name',
                                    sale_price = '$sale_price',
                                    sale_quantity = '$sale_quantity',
                                    sale_remain = '$sale_quantity',
                                    sale_rule = '$sale_rule',
                                    start_day = '$handle_start_day',
                                    end_day = '$handle_end_day'
                                    WHERE sale_id = '$id'";
                        
                            $result = $this -> db -> update($update);
                            if ($result) {
                                $alert =   "<script>
                                                window.onload = function () {
                                                    swal({
                                                        title: 'Thành công',
                                                        text: 'Sửa mã giảm giá thành công',
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
                                                        text: 'Sửa mã giảm giá không thành công',
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

            } else {
                $alert = '0';
                return $alert;
            }
        }

        public function insert_sale($data)
        {      
            $sale_name = mysqli_real_escape_string($this->db->link, $data['sale_name']);
            $sale_price = mysqli_real_escape_string($this->db->link, $data['sale_price']);
            $sale_quantity = mysqli_real_escape_string($this->db->link, $data['sale_quantity']);
            $sale_rule = mysqli_real_escape_string($this->db->link, $data['sale_rule']);
            $start_day = mysqli_real_escape_string($this->db->link, $data['start_day']);
            $end_day = mysqli_real_escape_string($this->db->link, $data['end_day']);

            $handle_start_day = str_replace("T"," ",$start_day);
            $handle_end_day = str_replace("T"," ",$end_day);

            $select = "SELECT * FROM tbl_sale WHERE sale_name = '$sale_name' AND '$handle_start_day' < end_day";
            $result_select = $this -> db -> select($select);
            if($result_select) {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Tên mã giảm giá đang được sử dụng',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                return $alert;

            } else {
                if ($sale_name == '' || $sale_price == '' || $handle_start_day == '' || $handle_end_day == '') {
                    $alert = "Vui lòng nhập đầy đủ các trường";
                    return $alert;
                } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity == '' && $sale_rule == '') {
                    $insert =   "INSERT INTO tbl_sale(sale_name,sale_price,sale_rule,sale_quantity,sale_remain,start_day,end_day) 
                                VALUE ('$sale_name','$sale_price','0','99999','99999','$handle_start_day','$handle_end_day')";
                    
                    $result = $this -> db -> insert($insert);
                    if ($result) {
                        $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Thêm mã giảm giá thành công',
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
                                                text: 'Thêm mã giảm giá không thành công',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;

                    }

                } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity != '' && $sale_rule == '') {
                    if($sale_quantity < 10) {
                        $alert = "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Số lượng phải lớn hơn 10',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                        return $alert;
                    } else {
                        $insert =   "INSERT INTO tbl_sale(sale_name,sale_price,sale_rule,sale_quantity,sale_remain,start_day,end_day) 
                                    VALUE ('$sale_name','$sale_price','0','$sale_quantity','$sale_quantity','$handle_start_day','$handle_end_day')";
                        
                        $result = $this -> db -> insert($insert);
                        if ($result) {
                            $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thành công',
                                                    text: 'Thêm mã giảm giá thành công',
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
                                                    text: 'Thêm mã giảm giá không thành công',
                                                    icon: 'error',
                                                    button: 'Cancel',
                                                })
                                            }
                                        </script>";
                            return $alert;
                        }
                    }

                } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity == '' && $sale_rule != '') {
                    $insert =   "INSERT INTO tbl_sale(sale_name,sale_price,sale_rule,sale_quantity,sale_remain,start_day,end_day) 
                                VALUE ('$sale_name','$sale_price','$sale_rule','99999','99999','$handle_start_day','$handle_end_day')";
                    
                    $result = $this -> db -> insert($insert);
                    if ($result) {
                        $alert =   "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thành công',
                                                text: 'Thêm mã giảm giá thành công',
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
                                                text: 'Thêm mã giảm giá không thành công',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                        return $alert;

                    }

                } if ($sale_name != '' && $sale_price != '' && $handle_start_day != '' && $handle_end_day != '' && $sale_quantity != '' && $sale_rule != '') {
                    if($sale_quantity < 10) {
                        $alert = "<script>
                                    window.onload = function () {
                                        swal({
                                            title: 'Thất bại',
                                            text: 'Số lượng phải lớn hơn 10',
                                            icon: 'error',
                                            button: 'Cancel',
                                        })
                                    }
                                </script>";
                        return $alert;
                    } else {
                        $insert =   "INSERT INTO tbl_sale(sale_name,sale_price,sale_rule,sale_quantity,sale_remain,start_day,end_day) 
                                    VALUE ('$sale_name','$sale_price','$sale_rule','$sale_quantity','$sale_quantity','$handle_start_day','$handle_end_day')";
                        
                        $result = $this -> db -> insert($insert);
                        if ($result) {
                            $alert =   "<script>
                                            window.onload = function () {
                                                swal({
                                                    title: 'Thành công',
                                                    text: 'Thêm mã giảm giá thành công',
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
                                                    text: 'Thêm mã giảm giá không thành công',
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

        public function sum_sale_remain()
        {
            $count = "select COUNT(sale_id) as sum_sale from tbl_sale where curdate() < end_day and sale_remain > 0";
            $result = $this -> db -> select($count);
            return $result;
        }
        // Front end
        public function show_sale_remain()
        {
            $query = "SELECT * FROM tbl_sale WHERE curdate() < end_day ORDER BY sale_id DESC";
            $result = $this ->db -> select($query);
            if($result) {
                return $result;
            } else {
                $alert = '0';
                return $alert;
            }
        }

        public function validate_sale($sale_text,$price)
        {
            $select_sale = "SELECT * FROM tbl_sale WHERE sale_name = '$sale_text' AND start_day < curdate() AND curdate() < end_day";
            $result_select = $this -> db -> select($select_sale);
            if($result_select) {
                while($result = $result_select -> fetch_assoc()) {
                    $sale_id = $result['sale_id'];
                    $sale_price = $result['sale_price'];
                    $sale_rule = $result['sale_rule'];
                    $sale_quantity = $result['sale_quantity'];
                    $sale_remain = $result['sale_remain'];
                    $sale = ['sale_id' => $sale_id,
                             'sale_price' => $sale_price];
    
                }
                if($sale_remain <= 0) {
                    $alert = "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thất bại',
                                        text: 'Số lượng mã giảm giá đã hết',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                            </script>";
                    return $alert;
                } if($sale_remain > 0) {
                    if($sale_rule == 0) {
                        $alert = "1";
                        $select_sale1 = "SELECT * FROM tbl_sale WHERE sale_name = '$sale_text' AND start_day < curdate() AND curdate() < end_day";
                        $result_select1 = $this -> db -> select($select_sale);
                        return $result_select1;
                        return $sale_price;
                    }
                    if($sale_rule != 0) {
                        if($sale_rule > $price) {
                            $alert = "<script>
                                        window.onload = function () {
                                            swal({
                                                title: 'Thất bại',
                                                text: 'Đơn hàng không đủ điều kiện',
                                                icon: 'error',
                                                button: 'Cancel',
                                            })
                                        }
                                    </script>";
                            return $alert;
                        } if($sale_rule <= $price ) {
                            $alert = "1";
                            $select_sale1 = "SELECT * FROM tbl_sale WHERE sale_name = '$sale_text' AND start_day < curdate() AND curdate() < end_day";
                            $result_select1 = $this -> db -> select($select_sale);
                            return $result_select1;
                        }
                    }
                }
            } else {
                $alert = "<script>
                            window.onload = function () {
                                swal({
                                    title: 'Thất bại',
                                    text: 'Không tìm thấy mã giảm giá',
                                    icon: 'error',
                                    button: 'Cancel',
                                })
                            }
                        </script>";
                return $alert;
            }
        }

    }
?>