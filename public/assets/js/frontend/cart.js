var y = 1;
$("#quantity").attr("value", y);
$(".quantity-div #minus").click(function () {
    if ($("#quantity").val() > 1) {
        $("#quantity").attr("value", --y);
    }
});
$(".quantity-div #plus").click(function () {
    $("#quantity").attr("value", ++y);
});
$("#quantity").keypress(function () {
    const currentValue = $(this).val();
    let newValue = currentValue.replace(/[^0-9]/g, "");
    newValue = Math.max(1, newValue);
    $(this).val(newValue);
});
$('.cancel-btn').click(function () {
   $(this).parent().closest('.row').remove();
});
