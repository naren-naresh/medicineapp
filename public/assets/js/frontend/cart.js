$(".quantity-div .minus").click(function () {
    var y = $(this).siblings(".quantity").val();
    if ( $(this).siblings(".quantity").val() > 1) {
        $(this).siblings(".quantity").attr("value", --y);
        var cartId = $(this).siblings(".quantity").attr('cartId');
        update(cartId,y);
    }
});
$(".quantity-div .plus").click(function () {
    var z = $(this).siblings(".quantity").val();
    $(this).siblings(".quantity").attr("value", ++z);
    var cartId = $(this).siblings(".quantity").attr('cartId');
    update(cartId,z);
});
$(".quantity").keypress(function () {
    const currentValue = $(this).val();
    let newValue = currentValue.replace(/[^0-9]/g, "");
    newValue = Math.max(1, newValue);
    $(this).val(newValue);
});
/* csrf token*/
$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
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
function update(Id,quant) {
    $.ajax({
        type: "post",
        url: updateRoute,
        data:{
            cartId : Id,
            quantity:quant,
        },
        success: function (response) {
            console.log(response.success);
            location.reload();
        }
      });
}
