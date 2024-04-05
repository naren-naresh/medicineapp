jQuery(document).ready(function ($) {

    // This is for the auto sliding
    setInterval(function () {
        moveRight();
    }, 4000);

    //variables
    var slideCount = $('#slider-section ul li').length;
    var slideWidth = $('#slider-section ul li').width();
    var slideHeight = $('#slider-section ul li').height();
    var sliderUlWidth = slideCount * slideWidth;

    $('#slider-section').css({ width: slideWidth, height: slideHeight });

    $('#slider-section ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

    $('#slider-section ul li:last-child').prependTo('#slider-section ul');

    function moveLeft() {
        $('#slider-section ul').animate({
            left: + slideWidth
        }, 300, function () {
            $('#slider-section ul li:last-child').prependTo('#slider-section ul');
            $('#slider-section ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider-section ul').animate({
            left: - slideWidth
        }, 300, function () {
            $('#slider-section ul li:first-child').appendTo('#slider-section ul');
            $('#slider-section ul').css('left', '');
        });
    };
});
