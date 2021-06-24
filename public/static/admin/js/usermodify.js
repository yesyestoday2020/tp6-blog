$(document).ready(function () {
    let form_data = $("form").serialize();
    $.ajax({
        type: "POST",
        url: "/admin.php/UserModify/saveData",
        data: form_data,
        dataType: "json",
        success: function (data) {
            $("input[name='name']").val(data.name);
            $("input[name='email']").val(data.email);
        },
    });
});
