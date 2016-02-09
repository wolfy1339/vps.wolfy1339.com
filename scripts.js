$(".highlight").click(function(c) {
    c.preventDefault();
    $(this).attr("disabled", "disabled");
    $("#source").each(function(e) {
        hljs.highlightBlock(e);
    });
    var b = $("code").css("background-color");
    $("pre").css("background-color", b);
});

$(".modal").on("hidden.bs.modal", function () {
    $(".highlight").removeAttr("disabled");
});
$("th").click(function() {
    var asc = $(this).hasClass("sorting-asc");
    var desc = $(this).hasClass("sorting-desc");
    $("th .fa").removeClass("fa-sort-asc").removeClass("fa-sort-desc");
    if (asc) {
        $(this).find(".fa").addClass("fa-sort-asc");
    } else if (desc) {
        $(this).find(".fa").addClass("fa-sort-desc");
    }
});
