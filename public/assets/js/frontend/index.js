jQuery(document).ready(function ($) {
    var existCode = $("#postal_code").text();
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

    if (searchData.length >= 2) {
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
                            console.log(element.category_id);
                            var categoryUrl = singleProductUrl.replace(':id', element.id);
                            var imageUrl = image+'/'+element.id+''+'/'+element.cover_image+'';
                            let content =
                                `<li class ="py-1 px-2"><img src="`+imageUrl+`" style='width:25px; padding-right:2px;'><a href='`+categoryUrl+`'>` +
                                element.name +
                                `</a><li>`;
                            $(".search-result").append(content);
                        });
                    } else {
                        $(".search-result").append(`<li class="py-1 px-2">No results found</li>`);
                    }
                },
                error: function (error) {
                    console.error(error.responseText);
                },
            });
        }, doneTypingInterval);
    }
});

function showPostalCodePopup(errorMessage) {
    var swalConfig = {
        // title: "Enter Postal Code",
        input: "text",
        inputAutoFocus: false,
        imageUrl: brandLogo,
        imageWidth: 250,
        inputPlaceholder: "Enter Your Postal Code",
        html: `<p style="font-size:16px">Enter delivery destination postal code.</p>
        <span style="color: red">${errorMessage || ""}</span>`,
        showCancelButton: false,
        confirmButtonText: "Submit",
        confirmButtonColor: "#385399",
        allowOutsideClick: false,
        showCloseButton: false,
        inputAttributes: {
            maxlength: 4,
            pattern: "\\d*",
            onkeypress: "return event.charCode >= 48 && event.charCode <= 57",
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
    // Show SweetAlert popup
    Swal.fire(swalConfig).then((result) => {
        if (result.isConfirmed) {
            submitPostalCode(result.value);
        }
        if (result.dismiss === Swal.DismissReason.cancel) {
            location.reload();
        }
    });
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
                showPostalCodePopup(response.message);

                var modalContainer = document.querySelector(".swal2-modal");
                // Hide the input field by finding it within the modal container and setting its display style to 'none'
                var inputField = modalContainer.querySelector(".swal2-input");
                if (inputField) {
                    inputField.style.display = "none";
                }
                Swal.update({
                    showConfirmButton: false,
                    showCancelButton: true,
                    input: false,
                    cancelButtonText: "Continue",
                    html: `<div class="d-flex flex-column justify-content-between align-items-center"><img src=`+success+` style="width:100px">
                    <span style="color: #79C043">Continue Shopping.</span></div>`,
                });
            } else {
                showPostalCodePopup(response.message);
                Swal.update({
                    html: `<div class="d-flex flex-column justify-content-between align-items-center"><img src=`+error+` style="width:100px">
                    <span style="color: red">Enter valid postal code.</span></div>`,
                });
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

$("#postalChange").click(function (e) {
    showPostalCodePopup();
    Swal.update({
        input: false,
        showCloseButton: true,
    });
});
/** signIn form validation */
 $("#signInForm").validate({
    rules:{
        email: {
            required: true,
            email: true
          },
          password:{
            required:true,
            minlength:6,
            maxlength:16,
          }
    },
 });

 /** signUp form validation */
 $("#signUpForm").validate({
    rules:{
        firstName:"required",
        email: {
            required: true,
            email: true
          },
          password:{
            required:true,
            minlength:6,
            maxlength:16,
          },
          confirmPassword: {
            required: true,
            minlength: 6,
            maxlength: 15,
            equalTo: '#password1',
        },
    },
 });
/** password hide and show  */
 $('#eyeIcon').mousedown(function() {
    $('.password').attr('type', 'text');
    $(this).removeClass('fa-eye-slash');
    $(this).addClass('fa-eye');

});

$('#eyeIcon').on('mouseup mouseleave', function() {
    $('.password').attr('type', 'password');
    $(this).addClass('fa-eye-slash');
    $(this).removeClass('fa-eye');
});
/** singUp form */
$('#eyeIcon1').mousedown(function() {
    $('.password1').attr('type', 'text');
    $(this).removeClass('fa-eye-slash');
    $(this).addClass('fa-eye');
});

$('#eyeIcon1').on('mouseup mouseleave', function() {
    $('.password1').attr('type', 'password');
    $(this).addClass('fa-eye-slash');
    $(this).removeClass('fa-eye');
});
/** confirm password  */
$('#cIcon').mousedown(function() {
    $('.confirmPassword').attr('type', 'text');
    $(this).removeClass('fa-eye-slash');
    $(this).addClass('fa-eye');
});

$('#cIcon').on('mouseup mouseleave', function() {
    $('.confirmPassword').attr('type', 'password');
    $(this).addClass('fa-eye-slash');
    $(this).removeClass('fa-eye');
});
