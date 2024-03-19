$("#generateVariantList").on("click", function () {
        var allVariants = {};
        var getretailPrice = $("#retailPrice").val();
        var getsellingPrice = $("#sellingPrice").val();
        var getSKU = $("#sku").val();
        var getStock = $("#stock").val();
        var getThresholdQty = $("#thresholdQty").val();
        if ($("#haveVariant").val() == 1) {
            var flag = false;
            $(".variant-name").filter(function () {
                if (this.value != "") {
                    flag = true;
                    let all_variants = [];
                    let attributes = this.value;
                    $(this).closest(".form-row").find(".option-value").each(function () {
                        all_variants.push($(this).val());
                    });
                    allVariants[attributes] = all_variants;
                    return false;
                }
            });
            if (!flag) {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    text: "Please add atleast one variant.",
                    showConfirmButton: false,
                    timer: 2500,
                });
            }
            if (checkVariantInfoValidate()) {
                $.ajax({
                    type: "POST",
                    url: productVariantRoute,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {
                        selected_variants: allVariants,
                        retail_price: getretailPrice,
                        selling_price: getsellingPrice,
                        sku: getSKU,
                        stock: getStock,
                        threshold_qty: getThresholdQty,
                    },
                    success: function (response) {
                        $("#variantList").html(response);
                        selectRefresh();
                    },
                });
            }
        }
    });
