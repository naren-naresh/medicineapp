const toolbarOptions = [
    ["bold", "italic", "underline", "strike"], // toggled buttons
    ["blockquote", "code-block"],
    ["link", "image", "video", "formula"],
    [
        {
            list: "ordered",
        },
        {
            list: "bullet",
        },
        {
            list: "check",
        },
    ],
    [
        {
            direction: "rtl",
        },
    ], // text direction
    [
        {
            header: [1, 2, 3, 4, 5, 6, false],
        },
    ],
    [
        {
            color: [],
        },
        {
            background: [],
        },
    ], // dropdown with defaults from theme
    [
        {
            font: [],
        },
    ],
    [
        {
            align: [],
        },
    ],
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
 $('#generateVariation').hide();
 var defaultVarOption = $('input[name="is_variation"]:checked');
 $('input[name="is_variation"]').click(function () {
     if ($(this).val() == "1") {
         $("#variationRow").show();
         $('#generateVariation').show();
     }
     if ($(this).val() === defaultVarOption.val()) {
         $("#variationRow").hide();
         $('#generateVariation').hide();
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
