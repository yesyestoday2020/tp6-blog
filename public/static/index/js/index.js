$(document).ready(function () {
    $(".opensidebar").click(function () {
        $(".ui.sidebar").sidebar("toggle");
    });

    $(".preview").click(function () {
        $(".ui.modal").modal("show");
    });
});
