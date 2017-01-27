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
$("th").on('click', function() {
    $("th").find(".fa").removeClass("fa-sort-asc fa-sort-desc").addClass("fa-sort");

    var fa = $(this).find(".fa");
    var asc = $(this).hasClass("sorting-asc");
    var desc = $(this).hasClass("sorting-desc");
    if (desc) {
        fa.removeClass("fa-sort-desc").addClass("fa-sort-asc");
    } else if (asc) {
        fa.addClass("fa-sort-desc").removeClass("fa-sort-asc");
    } else {
        // Add the icon class
        fa.addClass("fa-sort-asc").removeClass("fa-sort");
    }
});
