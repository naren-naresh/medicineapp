$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
    $("span.text").toggleClass("active");
});

function initMenu() {
    $('#menu ul').hide();
    $('#menu ul').children('.current').parent().show();
    // $('#menu ul:first').show();
    $('#menu li a').mouseenter(
        function() {
            $('#menu ul').show();
        }
    );
    $('#menu li a').mouseleave(function () {
        $('#menu ul').hide();
    });
}
$(document).ready(function() {
    initMenu();
});
