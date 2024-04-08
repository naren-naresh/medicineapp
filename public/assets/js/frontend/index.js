jQuery(document).ready(function ($) {
    // This is for the auto sliding
    setInterval(function () {
        moveRight();
    }, 4000);

    //variables
    var slideCount = $("#slider-section ul li").length;
    var slideWidth = $("#slider-section ul li").width();
    var slideHeight = $("#slider-section ul li").height();
    var sliderUlWidth = slideCount * slideWidth;

    $("#slider-section").css({ width: slideWidth, height: slideHeight });

    $("#slider-section ul").css({
        width: sliderUlWidth,
        marginLeft: -slideWidth,
    });

    $("#slider-section ul li:last-child").prependTo("#slider-section ul");

    function moveLeft() {
        $("#slider-section ul").animate(
            {
                left: +slideWidth,
            },
            300,
            function () {
                $("#slider-section ul li:last-child").prependTo(
                    "#slider-section ul"
                );
                $("#slider-section ul").css("left", "");
            }
        );
    }

    function moveRight() {
        $("#slider-section ul").animate(
            {
                left: -slideWidth,
            },
            300,
            function () {
                $("#slider-section ul li:first-child").appendTo(
                    "#slider-section ul"
                );
                $("#slider-section ul").css("left", "");
            }
        );
    }
});

// search field of the page
/* csrf token*/
$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
let typingTimer;
const doneTypingInterval = 500; // milliseconds

$('#search-input').keyup(function () {
    clearTimeout(typingTimer);
    let searchData = $(this).val();

    // Clear previous results
    $('.search-result').empty();

    if (searchData.length >= 1) {
        typingTimer = setTimeout(function () {
            $.ajax({
                type: "post",
                url: search,
                data: {
                    search_data: searchData,
                },
                success: function (data) {
                    if (data.length > 0) {
                        data.forEach(element => {
                            let content = `<li>` + element.name + `<li>`;
                            $('.search-result').append(content);
                        });
                    } else {
                        $('.search-result').append("<li>No results found</li>");
                    }
                },
                error: function (error) {
                    console.error(error.responseText);
                }
            });
        }, doneTypingInterval);
    }
});

