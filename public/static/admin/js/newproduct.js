layui.use(["jquery", "form", "layer", "upload", "laydate", "table"], function () {
	var $ = layui.$;
	var layer = layui.layer;
	var form = layui.form;
	var upload = layui.upload;
	var laydate = layui.laydate;
	var table = layui.table;

	// 监听提交,使用ajax提交表单
	form.on("submit(form_data)", function (data) {
		$.ajax({
			type: "POST",
			url: "Newproduct/formdata",
			// 表单数据
			data: data.field,
			success: function (response) {
				console.log(response);
			},
		});
		return false;
	});

	// 日期组件
	laydate.render({
		elem: "#date",
	});

	//普通图片上传
	upload.render({
		elem: "#uploadFile",
		//改成您自己的上传接口
		url: "Newproduct/upload",
		// 自动上传
		auto: true,
		// 指定上传时校验的文件类型
		accept: "images",
		// 指定文件后缀名
		exts: "png|jpeg|jpg",
		size: 2048,
		field: "image",
		//上传前预览
		before: function (obj) {
			obj.preview(function (index, file, result) {
				$("#preview-image").attr("src", result);
				console.log(file.name);
			});
		},

		// 上传后
		done: function (res) {
			console.log(res);
			if (res.code < 0) {
				return layer.msg("上传失败");
			}
		},

		// 重新上传
		error: function () {
			var demoText = $("#demoText");
			demoText.html(
				'<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>'
			);
			demoText.find(".demo-reload").on("click", function () {
				uploadInst.upload();
			});
		},
	});

	table.render({
		elem: "#test",
		url: "Inventory/query",
		method: "POST",
		page: {
			layout: ["limit", "count", "prev", "page", "next", "skip"],
			curr: 1,
			limit: 10,
			limits: [10, 15, 20],
			groups: 1,
		},
		request: {
			// 页码的参数名称，默认：page
			pageName: "page",
			// 每页数据量的参数名，默认：limit
			limitName: "limit",
		},

		cols: [
			[
				{ field: "id", width: 80, title: "ID" },
				{
					field: "url",
					width: 100,
					title: "封面图片",
					templet: "#img",
				},
				{ field: "title", width: 200, title: "图书名称" },
				{ field: "desc", width: 200, title: "描述" },
				{ field: "price", width: 200, title: "价格" },
				{ field: "interest", width: 100, title: "图书分类" },
				{ field: "racking_time", width: 150, title: "上架时间", sort: true },
			],
		],

		done: function (res) {
			console.log(res);
		},
	});
});
