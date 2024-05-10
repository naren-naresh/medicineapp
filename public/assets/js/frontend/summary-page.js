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
$("#cardDetailsForm").validate({
    rules: {
        cardNumber: {
          required: true,
          minlength: 13,
        },
        expires: {
          required: true,
          minlength: 4,
        },
        cvc: {
          required: true,
          minlength: 3,
        },
        name: 'required'
      },
      messages: {
        cardNumber: {
          required: 'Card number is required.',
          minlength: 'Card number must be between 13 and 19 digits.',
        },
        expires: {
          required: 'Expiry date is required.',
          minlength: 'Expiry date must be in MM/YY format.',
        },
        cvc: {
          required: 'Cvc number is required.',
          minlength: 'CVC/CVV must be between 3 and 4 digits.',
        },
        name: 'Name is required.'
      }
});
$("#placeOrder").click(function (e) {
    e.preventDefault();
    if ($("#cardDetailsForm").valid()) {
        console.log("valid");
    } else {
        console.log("not valid");
    }
});
// restrict price input fields
function process(input) {
    let value = input.value;
    let validNumber = value.replace(/[^\d.]/g, "");
    let cleanedValue = validNumber.replace(/(\.*)\./g, "$1");
    input.value = cleanedValue;
}
