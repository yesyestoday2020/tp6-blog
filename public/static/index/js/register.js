$(document).ready(function () {
    $("#submit").click(function () {
        var form_data = $("#form_data").serialize();

        $.ajax({
            type: "POST",
            data: form_data,
            url: "{:url('Index/Register/index')}",
            datatype: "json",
            success: function (result) {
                alert(result);
            },
            error: function () {
                console.log("失败");
            },
        });
    });
    // if ($("#name").val() == "") {
    //     $(".message_name").html("名字不能为空");
    // }
    // if ($("#email").val() == "") {
    //     $(".message_email").html("邮箱不能为空");
    // }
    // if ($("#password").val() == $("#password-confirm").val()) {
    //     $(".message_password").html("密码一致可以提交");
    // }
});
