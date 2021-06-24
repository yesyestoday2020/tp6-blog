layui.use(["table"], function () {
	var table = layui.table;
	table.render({
		elem: "#test",
		url: "UserList/getData",
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
				{ field: "id", width: 80, title: "ID" },
				{ field: "username", width: 80, title: "用户名" },
				{ field: "email", width: 200, title: "电子邮件" },
			],
		],

		done: function (res) {
			console.log(res);
		},
	});
});
