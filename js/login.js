$(document).ready(function () {
    $(".userUser").blur(function() {
        var phone = $(this).val();
        if (phone == "") {
            $(".info_userUser").html("Vui lòng nhập trường này");
            $(".userUser").addClass("input_error");
        } else {
            $(".info_userUser").html("");
            $(".userUser").removeClass("input_error");
        }
    });
    $(".userPass").blur(function() {
        var password = $(this).val();
        if (password == "") {
            $(".info_userPass").html("Vui lòng nhập trường này");
            $(".userPass").addClass("input_error");
        } else {
            $(".info_userPass").html("");
            $(".userPass").removeClass("input_error");
        }
    });

    $(".register_name").blur(function() {
        var name = $(this).val();
        if (name == "") {
            $(".info_register_name").html("Vui lòng nhập trường này");
            $(".register_name").addClass("input_error");
        } else {
            $(".info_register_name").html("");
            $(".register_name").removeClass("input_error");
        }
    });
    $(".register_phone").blur(function() {
        var name = $(this).val();
        if (name == "") {
            $(".info_register_phone").html("Vui lòng nhập trường này");
            $(".register_phone").addClass("input_error");
        } 
        else {
            $(".info_register_phone").html("");
            $(".register_phone").removeClass("input_error");
        }
    });
    $(".register_email").blur(function() {
        var name = $(this).val();
        if (name == "") {
            $(".info_register_email").html("Vui lòng nhập trường này");
            $(".register_email").addClass("input_error");
        } else {
            $(".info_register_email").html("");
            $(".register_email").removeClass("input_error");
        }
    });
    $(".register_address").blur(function() {
        var name = $(this).val();
        if (name == "") {
            $(".info_register_address").html("Vui lòng nhập trường này");
            $(".register_address").addClass("input_error");
        } else {
            $(".info_register_address").html("");
            $(".register_address").removeClass("input_error");
        }
    });
    $(".register_pass").blur(function() {
        var name = $(this).val();
        if (name == "") {
            $(".info_register_pass").html("Vui lòng nhập trường này");
            $(".register_pass").addClass("input_error");
        } else {
            $(".info_register_pass").html("");
            $(".register_pass").removeClass("input_error");
        }
    });
    $(".register_repass").blur(function() {
        var repassword = $(this).val();
        var password = $(".register_pass").val();
        if (repassword == "") {
            $(".info_register_repass").html("Vui lòng nhập trường này");
            $(".register_repass").addClass("input_error");
        } else if (repassword != password) {
            $(".info_register_repass").html("Mật khẩu không trùng nhau");
            $(".register_repass").addClass("input_error");
        } else {
            $(".info_register_repass").html("");
            $(".register_repass").removeClass("input_error");
        }
    });
});


