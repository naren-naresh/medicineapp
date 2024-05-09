$(".change-btn").click(function () {
    $("#addressModal").modal("show");
});
$(".address-item").click(function () {
    $id = $(this).attr("addressId");
    $html = $(this).parent().html();
    $(".address-content").html($html);
    $("#addressModal").modal("hide");
});
$(".address-item").each(function (index, element) {
    if (
        $(this).attr("addressId") ==
        $(".address-content").children("li").attr("addressId")
    ) {
        $(this).addClass("address-active");
        $(this).find("i").addClass("address-active");
    }
});
$(".continue-btn").click(function () {
    $("#paymentModal").modal("show");
});
/* payment modal functionality */
$("#card").click(function () {
    if ($(this).is(":checked")) {
        $(this).siblings("label").addClass("paymentActive");
        $("#pay-on-delivery").siblings("label").removeClass("paymentActive");
        $(".card-form").removeClass("d-none");
        $(".pay-btn-block").removeClass("d-none");
        $(".pay-on-content").addClass("d-none");
    }
});
$("#pay-on-delivery").click(function () {
    if ($(this).is(":checked")) {
        $(this).siblings("label").addClass("paymentActive");
        $("#card").siblings("label").removeClass("paymentActive");
        $(".card-form").addClass("d-none");
        $(".pay-btn-block").removeClass("d-none");
        $(".pay-on-content").removeClass("d-none");
    }
});
$('#cardDetailsForm').validate({
     rules:{
        cardNumber:'required',
        expires:'required',
        cvc:'required',
        name:'required',
     },
     message:{
        cardNumber:{
            required:'Card number is required.',
        },
        expires:{
            required:'Expiry date is required.'
        },
        cvc:{
            required:'Cvc number is required.',
        },
        name:{
             required:'Name is required.'
        }
     }
});

