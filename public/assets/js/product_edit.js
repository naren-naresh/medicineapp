$(document).ready(function () {
    oldCategory(oldParentCateId, oldChildCateId);
    // cover image show
    $("#coverImgPreview").attr(
        "src",
        "/assets/images/products/" + product_id + "/" + coverImage + ""
    );
});
const toolbarOptions = [
    ["bold", "italic", "underline", "strike"], // toggled buttons
    ["blockquote", "code-block"],
    ["link", "image", "video", "formula"],
    [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
    [{ direction: "rtl" }], // text direction
    [{ header: [1, 2, 3, 4, 5, 6, false] }],
    [{ color: [] }, { background: [] }], // dropdown with defaults from theme
    [{ font: [] }],
    [{ align: [] }],
    ["clean"], // remove formatting button
];

// quill editor configuration
const quill = new Quill("#description", {
    modules: {
        toolbar: toolbarOptions,
    },
    theme: "snow",
});

// getting values from the quill editor
$("#description").on("input", function () {
    var quillContent = quill.getText();
    $("#descriptionContent").text(quillContent);
});

/* csrf token*/
$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
var categoryObject = {
    parentCategory: null,
    childCategory: null,
};
var flag = false;
var string = {
    productName: null,
    categoryName: null,
};
/* passing parent id data to controller */
$(".parent-category").click(function () {
    let parentCatId = $(this).attr("parentCatID");
    $("#parentCategoryList").find(".parent-category").removeClass("active");
    $(this).addClass("active");
    categoryObject.parentCategory = {
        name: $(this).text(),
    };
    string.categoryName = {
        name: $(this).attr("parentCatName").slice(0, 2),
    };
    string.productName = {
        name: $("#productName").val().slice(0, 3),
    };
    categoryObject.childCategory = null;
    categoryPreview(parentCatId);
    $.ajax({
        data: {
            parentId: parentCatId,
        },
        url: productIndexRoute,
        type: "get",
        success: function (data) {
            $("#childCategoryList").empty();
            for (item of data) {
                $("#childCategoryList").append(
                    "<li class='child-category border-bottom py-1' role='button' childCatId=" +
                        item.id +
                        ">" +
                        item.name +
                        "</li>"
                );
            }
            $(".child-category").click(function () {
                let childCatId = $(this).attr("childCatId");
                $("#childCategoryList")
                    .find(".child-category")
                    .removeClass("active");
                $(this).addClass("active");
                categoryObject.childCategory = {
                    name: $(this).text(),
                };
                categoryPreview(childCatId);
            });
        },
        error: function (data) {
            console.log("Error:", data);
            $("#save").html("Save Changes");
        },
    });
});

// select category preview
function categoryPreview(id) {
    let categoryNames = "The Selected Category Was : ";
    if (categoryObject.parentCategory) {
        categoryNames += categoryObject.parentCategory.name + " ";
    }
    if (categoryObject.childCategory) {
        categoryNames += "-> " + categoryObject.childCategory.name;
    }
    $("#catPreview").html(categoryNames);
    $("#category").val(id);
    $("#category-error").text("");
}

// function for multi step form validation
$("#productForm").find(".step").slice(1).hide();
$(".error").hide();

function stepOne() {
    var firstStepFlag = true;

    if ($("#productName").val() === "") {
        $("#product-error").show();
        firstStepFlag = false;
    } else {
        $("#product-error").hide();
    }

    if ($("#category").val() === "") {
        $("#category-error").show();
        firstStepFlag = false;
    } else {
        $("#category-error").hide();
    }
    if ($("#descriptionContent").val() === "") {
        $("#descriptionContent-error").show();
        firstStepFlag = false;
    } else {
        $("#descriptionContent-error").hide();
    }
    if ($("#coverImage").val() === "") {
        $("#coverImage-error").show();
        firstStepFlag = false;
    } else {
        $("#coverImage-error").hide();
    }
}
$("#productName").keyup(function (e) {
    $("#product-error").hide();
});
$("#description").keyup(function (e) {
    $("#descriptionContent-error").hide();
});
$("#coverImage").change(function (e) {
    $("#coverImage-error").hide();
});

function stepTwo() {
    var secondStepFlag = true;
    if ($("#manufacturer").val() === "" || $("#manufacturer").val() === null) {
        $("#manufacturer-error").show();
        secondStepFlag = false;
    } else {
        $("#manufacturer-error").hide();
    }
    if ($("#manufacturerDate").val() === "") {
        $("#manufacturerDate-error").show();
        secondStepFlag = false;
    } else {
        $("#manufacturerDate-error").hide();
    }
    if ($("#expiryDate").val() === "") {
        $("#expiryDate-error").show();
        secondStepFlag = false;
    } else {
        $("#expiryDate-error").hide();
    }

    return secondStepFlag;
}
$("#manufacturer").change(function (e) {
    $("#manufacturer-error").hide();
});
$("#manufacturerDate").change(function (e) {
    $("#manufacturerDate-error").hide();
});
$("#expiryDate").change(function (e) {
    $("#expiryDate-error").hide();
});

function stepThree() {
    var thirdStepFlag = true;
    if ($("#retailPrice").val() === "") {
        $("#retailPrice-error").show();
        thirdStepFlag = false;
    } else {
        $("#retailPrice-error").hide();
    }
    if ($("#sellingPrice").val() === "") {
        $("#sellingPrice-error").show();
        thirdStepFlag = false;
    } else {
        $("#sellingPrice-error").hide();
    }
    return thirdStepFlag;
}
$("#retailPrice").keyup(function (e) {
    $("#retailPrice-error").hide();
});
$("#sellingPrice").keyup(function (e) {
    $("#sellingPrice-error").hide();
});

// first step validation
$("#firstNext").click(function () {
    // if (stepOne()) {
    $("#step_1").css("border-bottom", "unset");
    $("#step_2").css("border-bottom", "2px solid #385399");
    $("#step_3").css("border-bottom", "unset");
    $(".step-1").hide();
    $(".step-2").show();
    $(".step-3").hide();
    // }
});

// second step validation
$("#secondNext").click(function () {
    // if (stepOne() && stepTwo()) {
    $("#step_3").css("border-bottom", "2px solid #385399");
    $("#step_1").css("border-bottom", "unset");
    $("#step_2").css("border-bottom", "unset");
    $(".step-1").hide();
    $(".step-2").hide();
    $(".step-3").show();
    // }
});

// final submit validation
$("#productForm").submit(function (e) {
    $("#step_3").css("border-bottom", "2px solid #385399");
    $("#step_1").css("border-bottom", "unset");
    $("#step_2").css("border-bottom", "unset");
    if (stepOne() && stepTwo() && stepThree()) {
        $("#productForm").submit();
    } else {
        Swal.fire("Some details are missing kindly check before Submit!");
        e.preventDefault();
    }
});

// multiStep navigation
$(".step-container li").hover(function () {
    $(this).css("cursor", "pointer");
});
$("#step_1").click(function () {
    $(this).css("border-bottom", "2px solid #385399");
    $("#step_2").css("border-bottom", "unset");
    $("#step_3").css("border-bottom", "unset");
    $(".step-1").show();
    $(".step-2").hide();
    $(".step-3").hide();
});
$("#step_2").click(function () {
    if (stepOne()) {
        $(this).css("border-bottom", "2px solid #385399");
        $("#step_1").css("border-bottom", "unset");
        $("#step_3").css("border-bottom", "unset");
        $(".step-1").hide();
        $(".step-2").show();
        $(".step-3").hide();
    }
});
$("#step_3").click(function () {
    if (stepOne() && stepTwo()) {
        $("#step_3").css("border-bottom", "2px solid #385399");
        $("#step_1").css("border-bottom", "unset");
        $("#step_2").css("border-bottom", "unset");
        $(".step-1").hide();
        $(".step-2").hide();
        $(".step-3").show();
    }
});

//back button of multi step form
$(".prev-step").each(function () {
    $(this).click(function () {
        var currentStep = $(this).attr("step");
        if (currentStep > 1) {
            $(".step-circle-" + (currentStep - 2)).css(
                "border-bottom",
                "2px solid #385399"
            );
            $(".step-circle-" + (currentStep - 1)).css(
                "border-bottom",
                "unset"
            );
            $(".step-" + currentStep);
            currentStep--;
            setTimeout(function () {
                $(".step").hide();
                $(".step-" + currentStep).show();
            });
        }
    });
});
// custom tax for product
$("#tax").hide();
var defaultTaxOption = $('input[name ="taxInclude"]:checked');
$('input[name ="taxInclude"]').click(function () {
    if ($(this).val() == "0") {
        $("#tax").show();
    }
    if ($(this).val() === defaultTaxOption.val()) {
        $("#tax").hide();
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

// tax type functionality
$("#taxType").change(function () {
    let selectOption = $(this).val();
    let textField = $("#texValue");
    textField.off("input");
    textField.val("");
    if (selectOption == "1") {
        textField.on("input", function () {
            let value = $(this).val();
            if (value > 100) {
                $(this).val(100);
            }
        });
    }
});

// variation hide and show based on the radio check
$("#variationRow").hide();
$("#generateVariation").hide();
var defaultVarOption = $('input[name="is_variation"]:checked');
$('input[name="is_variation"]').click(function () {
    if ($(this).val() == "1") {
        $("#variationRow").show();
        $("#generateVariation").show();
    }
    if ($(this).val() === defaultVarOption.val()) {
        $("#variationRow").hide();
        $("#generateVariation").hide();
        $("#variationRow input").val("");
    }
});

// custom return policy option
$("#policyTypeContent").hide();
$('input[name="returnPolicy"]').click(function () {
    if ($(this).val() == "1") {
        $("#policyTypeContent").show();
    }
    if ($(this).val() == "0") {
        $("#policyTypeContent").hide();
    }
});
// selling price validation
$("#sellingPrice").keyup(function () {
    let retailAmount = parseFloat($("#retailPrice").val());
    let sellingAmount = parseFloat($("#sellingPrice").val());
    if (retailAmount < sellingAmount) {
        $("#sellingPrice").val(retailAmount);
    }
});
// Show category data form database
function oldCategory(id, childID) {
    categoryPreview(id);
    $(".parent-category ").each(function () {
        if ($(this).attr("parentcatid") == id) {
            $(this).addClass("active");
            categoryObject.parentCategory = {
                name: $(this).text(),
            };
            string.categoryName = {
                name: $(this).attr("parentCatName").slice(0, 2),
            };
            string.productName = {
                name: $("#productName").val().slice(0, 3),
            };
            categoryObject.childCategory = null;
            $.ajax({
                data: {
                    parentId: id,
                },
                url: productIndexRoute,
                type: "get",
                success: function (data) {
                    $("#childCategoryList").empty();
                    for (item of data) {
                        $("#childCategoryList").append(
                            "<li class='child-category border-bottom py-1 px-2' role='button' childCatId=" +
                                item.id +
                                ">" +
                                item.name +
                                "</li>"
                        );
                    }
                    $(".child-category").each(function () {
                        if ($(this).attr("childcatid") == childID) {
                            let childCatId = childID;
                            $("#childCategoryList")
                                .find(".child-category")
                                .removeClass("active");
                            $(this).addClass("active");
                            categoryObject.childCategory = {
                                name: $(this).text(),
                            };
                            categoryPreview(childCatId);
                        }
                    });
                },
                error: function (data) {
                    console.log("Error:", data);
                    $("#save").html("Save Changes");
                },
            });
        }
    });
}
//cover image preview
$("#coverImage").change(function (e) {
    var imageReader = new FileReader();
    imageReader.onload = function (e) {
        $("#imgIcon").hide();
        $("#coverImgPreview").attr("src", e.target.result);
    };
    imageReader.readAsDataURL(this.files[0]);
});
function thumbnailImage(id) {
    let thumbnailImg_html =
        `<label for='image` +
        id +
        `' class='ms-2 mb-3 picture d-flex justify-content-center align-items-center position-relative' index='` +
        id +
        `'>
        <i class='fa fa-plus-circle position-absolute' id='plusIcon' style='font-size: 1.5rem'></i>
        <img src='' id='imgPreview` +
        id +
        `' class='w-100'>
        <i class='fa fa-close position-absolute imageCancel' style='top:4px;right:4px;'></i>
    </label>
    <input type='file' name='image[]' id='image` +
        id +
        `' class='mt-2 d-none upload_image' accept="image/*" multiple>`;
    return thumbnailImg_html;
}
//  dynamic images and preview
$(document).on("change", ".upload_image", function (e) {
    $("#imgPreview,#plusIcon").hide();
    var imageReader = new FileReader();
    let thumbImgCount = $(".upload_image").length;
    let thumbnailImgHtml = thumbnailImage(thumbImgCount);
    $("#thumbImgDiv").append(thumbnailImgHtml);
    imageReader.onload = function (e) {
        $("#imgPreview" + (thumbImgCount - 1)).attr("src", e.target.result);
    };
    imageReader.readAsDataURL(this.files[0]);
});
// cancel selected image
$(document).on("click", ".imageCancel", function (e) {
    $(this).parent().remove();
});
$("#tax").hide();

// custom tax for product
var defaultTaxOption = $('input[name ="taxInclude"]:checked');
$('input[name ="taxInclude"]').click(function () {
    if ($(this).val() == "0") {
        $("#tax").show();
    }
    if ($(this).val() === defaultTaxOption.val()) {
        $("#tax").hide();
    }
});
