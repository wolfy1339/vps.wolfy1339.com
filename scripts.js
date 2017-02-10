$(".highlight").on('click', function(c) {
    c.preventDefault();
    $(this).attr("disabled", "disabled");
    $("#source").each(function(i, block) {
        hljs.highlightBlock(block);
    });
    var b = $("code").css("background-color");
    $("pre").css("background-color", b);
});

$(".modal").on("hidden.bs.modal", function() {
    $(this).find(".highlight").removeAttr("disabled");
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
$("#bs-table").stupidtable();
