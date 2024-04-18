//Initialize product gallery
$(document).ready(function () {
    $(".showImage").zoomImage();
    $("#show-img").hover(function () {
        $("#big-img").attr("src", $(this).attr("src"));
    });
});
$(".show-small-img:first-of-type").css({
    border: "solid 1px #385399",
    padding: "2px",
});
$(".show-small-img:first-of-type")
    .attr("alt", "now")
    .siblings()
    .removeAttr("alt");
$(".show-small-img").click(function () {
    $("#show-img").attr("src", $(this).attr("src"));
    $("#big-img").attr("src", $(this).attr("src"));
    $(this).attr("alt", "now").siblings().removeAttr("alt");
    $(this)
        .css({ border: "solid 1px #385399", padding: "2px" })
        .siblings()
        .css({ border: "none", padding: "0" });
    if ($("#small-img-roll").children().length > 4) {
        if (
            $(this).index() >= 3 &&
            $(this).index() < $("#small-img-roll").children().length - 1
        ) {
            $("#small-img-roll").css(
                "left",
                -($(this).index() - 2) * 76 + "px"
            );
        } else if (
            $(this).index() ==
            $("#small-img-roll").children().length - 1
        ) {
            $("#small-img-roll").css(
                "left",
                -($("#small-img-roll").children().length - 4) * 76 + "px"
            );
        } else {
            $("#small-img-roll").css("left", "0");
        }
    }
});

//Enable the next button

$("#next-img").click(function () {
    $("#show-img").attr(
        "src",
        $(".show-small-img[alt='now']").next().attr("src")
    );
    $("#big-img").attr(
        "src",
        $(".show-small-img[alt='now']").next().attr("src")
    );
    $(".show-small-img[alt='now']")
        .next()
        .css({ border: "solid 1px #385399", padding: "2px" })
        .siblings()
        .css({ border: "none", padding: "0" });
    $(".show-small-img[alt='now']")
        .next()
        .attr("alt", "now")
        .siblings()
        .removeAttr("alt");
    if ($("#small-img-roll").children().length > 4) {
        if (
            $(".show-small-img[alt='now']").index() >= 3 &&
            $(".show-small-img[alt='now']").index() <
                $("#small-img-roll").children().length - 1
        ) {
            $("#small-img-roll").css(
                "left",
                -($(".show-small-img[alt='now']").index() - 2) * 76 + "px"
            );
        } else if (
            $(".show-small-img[alt='now']").index() ==
            $("#small-img-roll").children().length - 1
        ) {
            $("#small-img-roll").css(
                "left",
                -($("#small-img-roll").children().length - 4) * 76 + "px"
            );
        } else {
            $("#small-img-roll").css("left", "0");
        }
    }
});

//Enable the previous button

$("#prev-img").click(function () {
    $("#show-img").attr(
        "src",
        $(".show-small-img[alt='now']").prev().attr("src")
    );
    $("#big-img").attr(
        "src",
        $(".show-small-img[alt='now']").prev().attr("src")
    );
    $(".show-small-img[alt='now']")
        .prev()
        .css({ border: "solid 1px #385399", padding: "2px" })
        .siblings()
        .css({ border: "none", padding: "0" });
    $(".show-small-img[alt='now']")
        .prev()
        .attr("alt", "now")
        .siblings()
        .removeAttr("alt");
    if ($("#small-img-roll").children().length > 4) {
        if (
            $(".show-small-img[alt='now']").index() >= 3 &&
            $(".show-small-img[alt='now']").index() <
                $("#small-img-roll").children().length - 1
        ) {
            $("#small-img-roll").css(
                "left",
                -($(".show-small-img[alt='now']").index() - 2) * 76 + "px"
            );
        } else if (
            $(".show-small-img[alt='now']").index() ==
            $("#small-img-roll").children().length - 1
        ) {
            $("#small-img-roll").css(
                "left",
                -($("#small-img-roll").children().length - 4) * 76 + "px"
            );
        } else {
            $("#small-img-roll").css("left", "0");
        }
    }
});
/** quantity field logic */
var x = 1;
$("#quantity").attr("value", x);
$(".quantity-option #minus").click(function () {
    if ($("#quantity").val() > 1) {
        $("#quantity").attr("value", --x);
    }
});
$(".quantity-option #plus").click(function () {
    $("#quantity").attr("value", ++x);
});
$("#quantity").keypress(function () {
    const currentValue = $(this).val();
    let newValue = currentValue.replace(/[^0-9]/g, "");
    newValue = Math.max(1, newValue);
    $(this).val(newValue);
});
/** select variant options */
$(".product-variant-options span").click(function () {
    $(this).siblings().removeClass("activeSelect");
    $(this).addClass("activeSelect");
});
/** postal check functionality */
/* csrf token*/
$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
$("#postalCodeCheck").click(function () {
    var postalCode = $("#postalCode").val();
    if (postalCode.length >= 4) {
        $.ajax({
            type: "post",
            url: DeliveryCode,
            data: {
                postalCode: postalCode,
            },
            success: function (response) {
                if (response.success) {
                    $("#checkDisplay").html(response.success);
                    $("#checkDisplay").removeClass("text-danger");
                    $("#checkDisplay").addClass("text-success");
                }
                if (response.error) {
                    $("#checkDisplay").html(response.error);
                    $("#checkDisplay").removeClass("text-success");
                    $("#checkDisplay").addClass("text-danger");
                }
            },
        });
    } else {
        $("#checkDisplay").html("Postal code must contain four digits.");
        $("#checkDisplay").removeClass("text-success");
        $("#checkDisplay").addClass("text-danger");
    }
});
// restrict price input fields
function process(input) {
    let value = input.value;
    // Remove all non-numeric characters except the decimal point
    let validNumber = value.replace(/[^\d.]/g, "");
    // Ensure only one decimal point is present
    let cleanedValue = validNumber.replace(/(\..*)\./g, "$1");
    input.value = cleanedValue; // Update the input value
}


let variantCount = $(".product-variant").length;
let variantOptionData = [];
$('.product-variant-options span').on('click', function() {
    let variantOptionDataObject = {};
    var variantId = $(this).parent().attr('variantId');
    var optionId = $(this).attr("optionId");
    let existingIndex = variantOptionData.findIndex(item => item.variant_id === variantId); // find the index of current variant_id using arrow function

    if ($(this).hasClass('activeSelect')) {
        if (existingIndex !== -1) {
            // Update existing object
            variantOptionData[existingIndex].optionId = optionId;
        } else {
            // Create new object values
             variantOptionDataObject = {
                variant_id: variantId,
                optionId: optionId
            };
            variantOptionData.push(variantOptionDataObject);
        }
    } else {
        // Remove the object from the array if option is deselected
        if (existingIndex !== -1) {
            variantOptionData.splice(existingIndex, 1);
        }
    }
});

// add to cart ajax call
$("#addToCart").click(function (e) {
    let productId = $(this).attr("productId");
    let quantity = $('#quantity').val();
    let zoneId = $('#postalCode').val();
    if (variantCount === variantOptionData.length) {
        // console.log(variantOptionData);
        $.ajax({
            type: "post",
            url: Cart,
            data: {
                product_id : productId,
                variants_data : variantOptionData,
                quantity : quantity,
                zone_id : zoneId,
            },
            success: function (response) {
              console.log(response);
            }
        });
    }else{
        alert('please select the options properly');
        e.preventDefault()
    }
});
