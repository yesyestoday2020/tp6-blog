$(document).ready(function () {
    $(".animate-text").typed({
        strings: [
            "Hello..........!",
            "My name is heguohui",
            "I'm a software engineers",
            "I'm a Web Developer ",
            "And i'm also a Graphic Designer",
        ],
        typeSpeed: 0,
        backSpeed: 0,
        backDelay: 3500,
        loop: true,
    });

    $("button").click(function () {
        $(".ui.modal")
            .modal({
                blurring: true,
            })
            .modal("show");
    });
});
