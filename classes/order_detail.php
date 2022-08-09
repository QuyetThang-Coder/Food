<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class order_detail 
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function show_orderdetailbyid($id)
        {
            $query = "SELECT * FROM tbl_order_detail WHERE order_id = '$id'";
            $result = $this ->db -> select($query);
            return $result;
        }

        // Front end
        public function order_view($id,$user_id)
        {
            $select = "SELECT * FROM tbl_order WHERE order_id = '$id' AND order_user = '$user_id' ";
            $result_select = $this ->db -> select($select);
            if($result_select) {
                $query = "SELECT * FROM tbl_order_detail WHERE order_id = '$id'";
                $result = $this ->db -> select($query);
                return $result;
            } else {
                $alert = "0";
                return $alert;
            }
        }

    }
?>