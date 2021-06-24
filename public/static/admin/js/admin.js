layui.use(["table"], function () {
	var table = layui.table;
	table.render({
		elem: "#test",
		url: "Admin/query",
		toolbar: "#toolbarDemo",
		defaultToolbar: [
			"filter",
			"exports",
			//自定义头部工具栏右侧图标。如无需自定义，去除该参数即可
			"print",
			{
				layEvent: "LAYTABLE_TIPS",
				icon: "layui-icon-tips",
			},
		],
		method: "POST",
		page: {
			layout: ["limit", "count", "prev", "page", "next", "skip"],
			curr: 1,
			limit: 5,
			limits: [5, 10, 15, 20],
			groups: 2,
		},
		request: {
			// 页码的参数名称，默认：page
			pageName: "page",
			// 每页数据量的参数名，默认：limit
			limitName: "limit",
		},
		cols: [
			[
				{ type: "checkbox", fixed: "left" },
				{ field: "id", width: 80, title: "ID" },
				{ field: "admin_user", width: 120, title: "管理员" },
				{ field: "phone", width: 200, title: "手机号" },
				{ field: "job", width: 200, title: "职位" },
				{ fixed: "right", title: "操作", toolbar: "#barDemo", minwidth: 200 },
			],
		],

		done: function (res) {
			console.log(res);
		},
	});
});
