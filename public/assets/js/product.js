        // quil editor tool bar
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
                            "<li class='child-category border-bottom py-1 px-2' role='button' childCatId=" +
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

             // generating sku
             let date = new Date();
             let year = date.getFullYear();
             let month = date.getMonth() + 1;
             let lastTwoDigitsOfYear = year.toString().slice(-2);
             let lastTwoDigitsOfMonth = month.toString().slice(-2);
             var prefix = (string.productName.name + string.categoryName.name).toUpperCase();
             if (prefix.length < 5) {
                 prefix = prefix.padEnd("5", "0");
             }
             let suffix = lastTwoDigitsOfMonth + lastTwoDigitsOfYear;
             let sku = prefix + suffix;

             $("#sku").val(sku);
            return firstStepFlag;
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
            if (stepOne()) {
                $("#step_1").css("border-bottom", "unset");
                $("#step_2").css("border-bottom", "2px solid #385399");
                $("#step_3").css("border-bottom", "unset");
                $(".step-1").hide();
                $(".step-2").show();
                $(".step-3").hide();
            }
        });

        // second step validation
        $("#secondNext").click(function () {
            if (stepOne() && stepTwo()) {
                $("#step_3").css("border-bottom", "2px solid #385399");
                $("#step_1").css("border-bottom", "unset");
                $("#step_2").css("border-bottom", "unset");
                $(".step-1").hide();
                $(".step-2").hide();
                $(".step-3").show();
            }
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
         // thumbnail image html content
        function thumbnailImage(id){
            let thumbnailImg_html =
            `<label for='image`+id+`' class='ms-2 mb-3 picture d-flex justify-content-center align-items-center position-relative' index='`+id+`'>
                <i class='fa fa-plus-circle position-absolute' id='plusIcon' style='font-size: 1.5rem'></i>
                <img src='' id='imgPreview`+id+`' class='w-100'>
                <i class='fa fa-close position-absolute imageCancel' style='top:4px;right:4px;'></i>
            </label>
            <input type='file' name='image[]' id='image`+id+`' class='mt-2 d-none upload_image' accept="image/*" multiple>`;
            return thumbnailImg_html;
        }

        // cover image preview
        var imageChecked = false;
        $("#coverImage").change(function (e) {
            e.preventDefault();
            var files = e.target.files;
            var imageReader = new FileReader();
            var file = this.files[0];

            let thumbImgCount = $('.upload_image').length;

            if (file) {
                var fileType = file.type;
                if (!fileType.startsWith("image/")) {
                    alert("Please select an image file.");
                    $("#imageInput").val("");
                }
            }

            // The thumbnail label appends only onces
            if (this.value && !imageChecked) {
                let thumbnailImgHtml = thumbnailImage(thumbImgCount);
                $("#thumbImgDiv").append(thumbnailImgHtml);
                imageChecked = true;
            }
            imageReader.onload = function (e) {
                $("#imgIcon").hide();
                $("#coverImgPreview").attr("src", e.target.result);
            };
            imageReader.readAsDataURL(this.files[0]);
        });

        //  dynamic images and preview
        $(document).on('change','.upload_image', function (e) {
            $("#imgPreview,#plusIcon").hide();
            var imageReader = new FileReader();
            let thumbImgCount = $('.upload_image').length;
            let thumbnailImgHtml = thumbnailImage(thumbImgCount);
            $("#thumbImgDiv").append(thumbnailImgHtml);
            imageReader.onload = function (e) {
                $("#imgPreview"+(thumbImgCount - 1)).attr("src", e.target.result);
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
        // restrict price input fields
        function process(input) {
            let value = input.value;
            // Remove all non-numeric characters except the decimal point
            let validNumber = value.replace(/[^\d.]/g, "");
            // Ensure only one decimal point is present
            let cleanedValue = validNumber.replace(/(\..*)\./g, "$1");
            input.value = cleanedValue; // Update the input value
        }

        // expiry date functionality
        $("#manufacturerDate").change(function () {
            $("#expiryDate").attr("min", $(this).val());
            if ($("#expiryDate").val() < $(this).val()) {
                // Clear expiry date value if it's before manufacturer date
                $("#expiryDate").val("");
            }
        });

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
        var optionFlag = false;
        function checkOptionValidate() {
            optionFlag = true;
            $(".optionValue").each(function () {
                let inputVal = $(this);
                if (inputVal.val() === "") {
                    optionFlag = false;
                }
            });
        }

        // appending options and variations
        $(document).on("click", ".addOptions", function () {
            let optionVal = $("#options").val();
            let opLength = $(".optionValue").length;
            let varLength = $(".varContent .row").length;

             checkOptionValidate();

            if (optionFlag && optionVal !== "") {
                let optionDesign =
                    '<div class="appendedOption' +
                    opLength +
                    ' d-flex justify-content-between input-group mt-2"><input type="text" name="options['+ (varLength - 1) + '][]" id="options' +
                    (opLength - 1) +
                    '" class="optionValue form-control"><i class="fa fa-close optionCancel input-group-text p-2" id="optionCancel"></i></div>';
                $("#optionBlock" + (varLength - 1)).append(optionDesign);
            }
            //option cancel option
            $(document).on("click", ".optionCancel", function () {
                $(this).parent().remove();
            });
        });

        var optionValid = false;
        var varValid = false;

        function checkVariantValidate() {
            varValid = true;
            optionValid = true;

            $(".varContent .row").each(function () {
                var variationBlock = $(this).find(".variationBlock");
                var optionBlock = $(this).find(".optionBlock");

                if (variationBlock.find(".variationName").val() === "") {
                    varValid = false;
                }

                if (optionBlock.find(".optionValue").val() === "") {
                    optionValid = false;
                }
            });
        }
        // additional variation
        $(".addVariations").click(function () {
            let optionVal = $("#options").val();
            let variationVal = $("#variationName").val();
            let varLength = $(".varContent .row").length;
            let variantCount = varLength ++;

            // Validate the input fields
            checkVariantValidate();
            // Validate the options input fields
            checkOptionValidate();
            // Check if both variation name and options are valid and varLength is within limit
            if ( optionValid && varValid && optionFlag && varLength <= 3 && optionVal !== "" && variationVal !== "" ) {
                let VarDesign =
                    '<div class="row my-2" id="varRow"><div class="col-6 variationBlock"><label for="variationName">Variation ' +
                    (varLength + 1) +
                    '</label><input type="text" name="variationName[]" class="varName form-control mt-1 variationName"><span class="variationCancel badge bg-danger">Remove</span></div><div class="col-6"><div class="optionBlock" id="optionBlock' +
                    (varLength -1) +
                    '"><label for="options">Options</label><input type="text" name="options['+variantCount+'][]" class="optionValue form-control mt-1"></div><label for="addOptions" class="addOptions form-control d-flex  align-items-center justify-content-center  mt-2" style="border: 1px solid rgb(102, 102, 102) ; border-style:dotted;"><i class="fa fa-plus-circle mx-2"></i> Add Options</label></div></div>';

                $("#varContent").append(VarDesign);
                $("#variants-error").hide();
            } else {
                $("#variants-error").show();
            }
        });
        $(".varName,.optionValue").keyup(function (e) {
            $("#variants-error").hide();
        });
         //option cancel Variation
         $(document).on("click", ".variationCancel", function () {
            $(this).parent().closest('#varRow').remove();
        });
        // selling price validation
        $("#sellingPrice").keyup(function () {
            let retailAmount = parseFloat($("#retailPrice").val());
            let sellingAmount = parseFloat($("#sellingPrice").val());
            if (retailAmount < sellingAmount) {
                $("#sellingPrice").val(retailAmount);
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

     // variant generator
     $('#generateVariation').click(function () {
        checkVariantValidate();
        checkOptionValidate();
        var allVariants = {};
        var getRetailPrice = $("#retailPrice").val();
        var getSellingPrice = $("#sellingPrice").val();
        var getSKU = $("#sku").val();
        var getStock = $("#stocks").val();
        var getThresholdQty = $("#thresholdQty").val();
        if ($('.variation').val() == 1) {
            var varFlag = false;
            $('.varName').filter( function (){
                 if ($(this).val() != '') {
                     varFlag = true;
                     let varOptionValues = [];
                     let varValue = this.value;
                     $(this).closest(".row").find(".optionValue").each(function () {
                        varOptionValues.push($(this).val());
                    });
                    allVariants[varValue] = varOptionValues;
                    return false;
                 }
            });
            if (varFlag && stepThree() && optionFlag) {
                $.ajax({
                    type: "POST",
                    url: productVariantRoute,
                    data: {
                        selected_variants: allVariants,
                        retail_price: getRetailPrice,
                        selling_price: getSellingPrice,
                        sku: getSKU,
                        stock: getStock,
                        threshold_qty: getThresholdQty,
                    },
                    success: function (response) {
                        $("#productPreview").html(response);
                        selectRefresh();
                    },
                });
            }else if (!varFlag) {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    text: " At least one variant is required!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            }else if (!stepThree()) {
                stepThree();
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    text: "Please fill all required field.",
                    showConfirmButton: false,
                    timer: 2500,
                });
            } else if (!optionFlag) {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    text: "At least one option is required!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            }
        }
     });
