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
    var productId = $(this).parent().attr('productId');
  $.ajax({
    type: "post",
    url: destroy,
    data:{
        productId : productId,
    },
    success: function (response) {
        console.log(response.success);
    }
  });
  $(this).parent().closest('.row.mainRow').remove();
});
