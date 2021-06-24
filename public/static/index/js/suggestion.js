$(document).ready(function () {
	$("#submit").click(function () {
		var question = $("#question").val();
		var content = $("#content").val();
		var form_data = {
			question: question,
			content: content,
		};
		$.ajax({
			type: "POST",
			url: "Suggestion/dosuggestion",
			data: form_data,
			success: function (response) {
				console.log(response);
			},
		});
	});
});
