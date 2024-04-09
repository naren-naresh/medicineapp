jQuery(document).ready(function ($) {
   var existCode = $('#postal_code').text();
   if (!existCode) {
    showPostalCodePopup();
   }
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

$("#search-input").keyup(function () {
    clearTimeout(typingTimer);
    let searchData = $(this).val();

    // Clear previous results
    $(".search-result").empty();

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
                        data.forEach((element) => {
                            let content =
                                `<li class ="py-1 px-2"><a href=''>` +
                                element.name +
                                `</a><li>`;
                            $(".search-result").append(content);
                        });
                    } else {
                        $(".search-result").append("<li>No results found</li>");
                    }
                },
                error: function (error) {
                    console.error(error.responseText);
                },
            });
        }, doneTypingInterval);
    }
});

// Flag to track whether to show the popup
var showPopup = true;

// Function to show the SweetAlert popup
function showPostalCodePopup(errorMessage) {
    if (showPopup) {
        var swalConfig = {
            // title: "Enter Postal Code",
            input: "text",
            inputAutoFocus:false,
            imageUrl: brandLogo,
            imageWidth: 250,
            inputPlaceholder: "Enter Your Postal Code",
            showCancelButton: false,
            confirmButtonText: "Submit",
            confirmButtonColor: "#385399",
            allowOutsideClick: false,
            showCloseButton: false,
            inputAttributes: {
                maxlength: 4,
                pattern: "\\d*",
                onkeypress:
                    "return event.charCode >= 48 && event.charCode <= 57",
            },
            inputValidator: (value) => {
                if (!value) {
                    return "Postal code is required!";
                }
                if (!/^\d{4}$/.test(value)) {
                    return "Postal code must be exactly four digits!";
                }
            },
        };

        // Add error message to SweetAlert configuration if provided
        if (errorMessage) {
            swalConfig["inputErrorMessage"] = errorMessage;
        }

        // Show SweetAlert popup
        Swal.fire(swalConfig).then((result) => {
            if (result.isConfirmed) {
                submitPostalCode(result.value);
            } else {
                // Redirect or handle cancellation
            }
        });
    }
}

// Function to submit the postal code
function submitPostalCode(postalCode) {
    // Make an AJAX request to submit the postal code
    $.ajax({
        type: "post",
        url: postalCheck,
        data: {
            postal_code: postalCode,
        },
        success: function (response) {
            if (response.valid) {
                showPopup = false;
                location.reload();
            } else {
                showPostalCodePopup(
                    "Invalid postal code. Please enter a valid four-digit postal code."
                );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}
$('#postalChange').click(function (e) {
    showPostalCodePopup();
});
