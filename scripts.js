$(".highlight").click(function (c) {
    c.preventDefault();
    $(".highlight").attr("disabled", "disabled");
    $("#source").each(function(e) {
        hljs.highlightBlock(e);
    });
    var b = $("code").css("background-color");
    $("pre").css("background-color", b);
});

$(".modal").on("hidden.bs.modal", function () {
    $(".highlight").removeAttr("disabled");
});

