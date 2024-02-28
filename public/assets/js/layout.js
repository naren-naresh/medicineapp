$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
    $("span.text").toggleClass("active");
});
$("#settings").click(function () {
    $("#smenu").toggleClass('sadd');
 })
 $("#products").click(function () {
    $("#productMenu").toggleClass('productAdd');
 })
 $("#delivery").click(function () {
    $("#deliveryMenu").toggleClass('deliveryAdd');
 })
$("#menu-toggle").click(function () {
    $("#sidebar-wrapper").hover(function () {
        $this=$(this);
        if ($this.hasClass("active")) {
            $("#sidebar-wrapper").removeClass("active");
            $("span.text").removeClass("active");
        } else {
            $("#sidebar-wrapper").addClass("active");
            $("span.text").addClass("active")
        }
        }, function () {
          $("#sidebar-wrapper").addClass("active");
          $("span.text").addClass("active")
        }
    );
});


