$(document).ready(function () {
	$("button").click(function () {
		// // 验证字段是否为空
		// if ($('#name').val() == '') {
		//     $('.message_name').html('名字不能为空');
		// }

		// if ($('#email').val() == '') {
		//     $('.message_email').html('邮箱不能为空');
		// }

		// if ($('#password').val() == '') {
		//     $('.message_password').html('密码不能为空');
		// }

		var form_data = $("#form_data").serialize();

		$.ajax({
			// 请求方法
			type: "POST",
			// 发送到服务器的数据
			data: form_data,

			// url :控制器/方法
			url: "Admin/dologin",

			// 服务器返回数据类型
			datatype: "json",

			// 请求成功运行函数
			success: function (result) {
				console.log(result);
			},
			// 请求失败运行函数
			error: function (result) {
				console.log(result);
			},
		});
	});
});
