<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class contact  
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this-> db = new Database();            
            $this-> fm = new Format();            
        }

        public function show_contact()
        {
            $select = "SELECT * FROM tbl_contact ORDER BY contact_id DESC";
            $result = $this -> db -> select($select);
            if($result) {
                return $result;
            }
        }

        public function delete_contact($id)
        {
            $delete_contact = "DELETE FROM tbl_contact WHERE contact_id = '$id'";
            $result = $this -> db -> delete($delete_contact);
            if($result) {
                $alert =   "<script>
                                window.onload = function () {
                                    swal({
                                        title: 'Thành công',
                                        text: 'Liên hệ đã được xóa',
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
                                        text: 'Liên hệ chưa được xóa',
                                        icon: 'error',
                                        button: 'Cancel',
                                    })
                                }
                        </script>";
                return $alert;
            }
        }
        // Front end
        public function insert_contact($data)
        {
            
            $contact_name = mysqli_real_escape_string($this->db->link, $data['contact_name']);
            $contact_phone = mysqli_real_escape_string($this->db->link, $data['contact_phone']);
            $contact_email = mysqli_real_escape_string($this->db->link, $data['contact_email']);
            $contact_describe = mysqli_real_escape_string($this->db->link, $data['contact_describe']);
            
            if ($contact_name == '' || $contact_phone == '' || $contact_email == '' || $contact_describe == '') {
                $alert = "<span class='error'>Không được để trống các trường</span>";
                return $alert;
            } else {
                $query = "INSERT INTO tbl_contact(contact_name,contact_phone,contact_email,contact_describe)
                          VALUE('$contact_name','$contact_phone','$contact_email','$contact_describe')";
                $result = $this ->db -> insert($query);

                if($result) {
                    $alert = "<span class='success'>Gửi ý kiến thành công. Xin cảm ơn bạn đã góp ý giúp chúng tôi ngày càng phát triển. Chúc bạn 1 ngày vui vẻ!</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Gửi ý kiến không thành công</span>";
                }
            }
        }

    }
?>