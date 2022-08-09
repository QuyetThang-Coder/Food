<?php include './inc/header.php'; ?>

<?php
    if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['submit']) ) {

		$submit_contact = $contact->insert_contact($_POST);
	}
?>
<style>
    .item_contact {
        background-color: #ff4500 !important; 
        padding: 12px 24px 8px 24px !important;
    }
</style>
<div id="contact">
    <div class="contact laptop_pc">
        <div class="grid wide">
            <div class="row contact_box">
                <form action="" method="POST" class="contact_left col l-9 m-8">
                    <div class="contact_heading">
                        <h3>Liên hệ với chúng tôi</h3>
                    </div>
                    <div class="contact_left_box ">
                        <div class="l-12 m-12">
                            <?php 
                                if(isset($submit_contact)) {
                                    echo $submit_contact;
                                }
                            ?>
                        </div>
                        <div class="contact_box_content">
                            <span>Họ và tên</span> <br>
                            <input type="text" name="contact_name">
                        </div>
                        <div class="contact_box_content">
                            <span>Số điện thoại</span> <br>
                            <input type="number" name="contact_phone">
                        </div>
                        <div class="contact_box_content">
                            <span>Email</span> <br>
                            <input type="text" name="contact_email">
                        </div>
                        <div class="contact_box_content">
                            <span>Nội dung</span> <br>
                            <textarea name="contact_describe" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="contact_submit">
                        <input type="submit" value="Gửi" name="submit">
                    </div>
                </form>
                <div class="contact_right col l-3 m-4">
                    <div class="contact_heading contact_heading_padding">
                        <h3>Thông tin của chúng tôi</h3>
                    </div>
                    <div class="contact_information">
                        <div class="lien-he lien-he-mobile">
                            <i class="fa fa-thin fa-square-phone"></i>
                            <h3>Phone</h3>
                            <p>+84 6666 8888 </p>
                        </div>
                        <div class="lien-he">
                            <i class="fa fa-thin fa-square-envelope"></i>
                            <h3>Email</h3>
                            <p>VietNamFood@gmail.com </p>
                        </div>
                        <div class="lien-he">
                            <i class="fa fa-thin fa-map-location-dot"></i>
                            <h3>Address</h3>
                            <p>123 Tây Hồ, Hà Nội, Việt Nam </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php include './inc/footer.php'; ?>