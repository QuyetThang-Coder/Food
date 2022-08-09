<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class product  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function insert_product($data,$files)
        {
            
            $product_name = mysqli_real_escape_string($this->db->link, $data['product_name']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $product_price = mysqli_real_escape_string($this->db->link, $data['product_price']);
            $product_describe = mysqli_real_escape_string($this->db->link, $data['product_describe']);

            // Kiểm tra ảnh và tải lên upload
            $permited = array('jpg','png','jpeg', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;
            
            if ($product_name == '' || $category == '' || $product_price == '' || $product_describe == '' || $file_name == '' ) {
                $alert = "<span class='error'>Không được để trống các trường</span>";
                return $alert;
            } else {
                move_uploaded_file($file_temp,$uploaded_image);
                $query = "INSERT INTO tbl_product(product_name,product_image,product_price,category,product_describe)
                          VALUE('$product_name','$unique_image','$product_price','$category','$product_describe')";
                $result = $this ->db -> insert($query);

                if($result) {
                    $alert = "<span class='success'>Thêm sản phẩm thành công</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Thêm sản phẩm không thành công</span>";
                }
            }
        }

        public function show_product()
        {
            $query = "SELECT * FROM tbl_product, tbl_category WHERE tbl_product.category = tbl_category.category_id ORDER BY tbl_product.product_id DESC";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function delete_product($id)
        {
            $query = "DELETE FROM tbl_product WHERE product_id = '$id'";
            $result = $this ->db -> delete($query);
            if ($result) {
                $alert = "<span class='success'>Xóa sản phẩm thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Xóa sản phẩm không thành công</span>";
                return $alert;
            }
            return $result;
        }

        public function update_product($data,$file,$id)
        {      
            $product_name = mysqli_real_escape_string($this->db->link, $data['product_name']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $product_price = mysqli_real_escape_string($this->db->link, $data['product_price']);
            $product_describe = mysqli_real_escape_string($this->db->link, $data['product_describe']);

            // Kiểm tra ảnh và tải lên upload
            $permited = array('jpg','png','jpeg', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;

            if ($product_name == '' || $category == '' || $product_price == '' || $product_describe == '') {
                $alert = "<span class='error'>Không được để trống các trường</span>";
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
                    $query = "UPDATE tbl_product set 
                              productName = '$product_name', 
                              product_image = '$unique_image', 
                              product_price = '$product_price',
                              category = '$category'; 
                              product_describe = '$product_describe', 
                              WHERE product_id = '$id'";
                    $result = $this ->db -> update($query);
                    if($result) {
                        $alert = "<span class='success'>Sửa danh mục thành công</span>";
                        return $alert;
                    } else {
                        $alert = "<span class='error'>Sửa danh mục không thành công</span>";
                    }
                } else {
                    $query = "UPDATE tbl_product set 
                              product_name = '$product_name', 
                              product_price = '$product_price',
                              category = '$category', 
                              product_describe = '$product_describe'
                              WHERE product_id = '$id'";
                    $result = $this ->db -> update($query);
                    if($result) {
                        $alert = "<span class='success'>Sửa danh mục thành công</span>";
                        return $alert;
                    } else {
                        $alert = "<span class='error'>Sửa danh mục không thành công</span>";
                    }
                }
            }      
        }

        public function getproductbyid($id)
        {
            $query = "SELECT * FROM tbl_product WHERE tbl_product.product_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_product()
        {
            $query = "SELECT COUNT(*) AS SUM_PRODUCT FROM tbl_product";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function sum_selling() {
            $query =    "SELECT tbl_product.*, sum(product_quantity) AS soluongban FROM tbl_product, tbl_order_detail
                        WHERE tbl_product.product_id = tbl_order_detail.product_id
                        AND month(curdate()) = month(order_creat)
                        AND year(curdate()) = year(order_creat)
                        GROUP BY tbl_order_detail.product_id 
                        ORDER BY soluongban DESC LIMIT 5";
            $result = $this -> db -> select($query);
            if($result) {
                return $result;
            }
        }

        // Front end
        public function getproductcategory()
        {
            $query =    "SELECT * from tbl_product, tbl_category
                        where tbl_category.category_id = tbl_product.category
                        and tbl_product.product_id IN (
                            SELECT MAX(product_id)
                            FROM tbl_product
                            GROUP BY category
                        ) order by tbl_category.category_id LIMIT 4;";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function getproductbyid_detail($id)
        {
            $query = "SELECT * FROM tbl_product WHERE tbl_product.product_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function product_similar($id)
        {
            $query = "SELECT * FROM tbl_product WHERE tbl_product.category = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function product_similar_page($id)
        {
            $product_page = 16;
            if(!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $each_page = ($page - 1) * $product_page;
            $query = "SELECT * FROM tbl_product WHERE tbl_product.category = '$id' ORDER BY product_id DESC LIMIT $each_page,$product_page";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function getproduct()
        {
            $product_page = 16;
            if(!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $each_page = ($page - 1) * $product_page;
            $query = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT $each_page,$product_page";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function getallproduct()
        {
            $query = "SELECT * FROM tbl_product ORDER BY product_id DESC";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function getproductnew4()
        {
            $query = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 4";
            $result = $this ->db -> select($query);
            return $result;
        }

        public function product_selling()
        {
            $query =    "SELECT *, SUM(product_quantity) AS Tongsoluong
                        FROM tbl_order_detail, tbl_product
                        WHERE tbl_order_detail.product_id = tbl_product.product_id
                        AND month(order_creat) = Month(curdate()) 
                        AND year(order_creat) = year(curdate())
                        GROUP BY tbl_order_detail.product_id
                        ORDER BY Tongsoluong DESC LIMIT 4;";
            $result = $this ->db -> select($query);
            return $result;
        }
    }
?>