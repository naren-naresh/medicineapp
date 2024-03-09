@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <!--breadcrumbs of page-->
    <div class="row justify-content-between w-100 mt-3">
    </div>
    <div class="card w-100 mt-2 mb-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Add New Product</h5>
            <div aria-label="breadcrumb" class="col-6">
                <ol class="breadcrumb step-container d-flex justify-content-between float-end">
                    <li class="step-circle-0 mx-1" onclick="displayStep(1)" style="border-bottom: 2px solid #385399;"> Basic
                        Information</li>
                    <li class="step-circle-1 mx-1" onclick="displayStep(2)">Additional Information</li>
                    <li class="step-circle-2 mx-1" onclick="displayStep(3)">Sales Information</li>
                </ol>
            </div>
        </div>
        <div class="car-body px-5 py-3">
            <form action="{{ route('product.store') }}" name="productForm" id="productForm" method="post"
                enctype="multipart/form-data">
                @csrf
                <!--basic info-->
                <div class="step step-1">
                    <div class="row">
                        <div class="from-group col-12">
                            <label for="productName" class="required">Product Name</label>
                            <input type="text" name="productName" id="productName" placeholder="Enter product name"
                                class="form-control mt-2">
                            <label for="productName" class="error" id="productNameError"></label>
                            @if ($errors->has('productName'))
                               <span class="text-danger">{{ $errors->first('productName') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label for="category" class="required">Category</label>
                            <ul class="bg-white mt-2 list-unstyled" id="parentCategoryList">
                                @foreach ($categories as $categoryName)
                                    <li parentCatID="{{ $categoryName->id }}"
                                        class="parent-category border-bottom px-2 py-1" role="button"
                                        parentCatName="{{ $categoryName->name }}">
                                        {{ $categoryName->name }} <i class="fa fa-angle-right float-end"></i></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-6">
                            <label for="category" class="required">Sub Category</label>
                            <ul class="mt-2 bg-white list-unstyled px-2" id="childCategoryList">
                            </ul>
                        </div>
                        <input type="hidden" name="category" id="category">
                        @if ($errors->has('category'))
                          <span class="text-danger">{{ $errors->first('category') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <p id='catPreview' class=" mt-0"></p>
                        <p for="category" id="category-error" class="error"></p>
                    </div>
                    <hr class="mt-0 p-0">
                    <div class="row mt-2 w-100 ps-3">
                        <label for="description" class="mb-2 p-0 required">Product Description</label>
                        <div name="description" id="description" style="height: 200px "></div>
                        <textarea name="descriptionContent" id="descriptionContent" class="d-none"></textarea>
                        @if ($errors->has('descriptionContent'))
                          <span class="text-danger">{{ $errors->first('descriptionContent') }}</span>
                        @endif
                    </div>
                    <div class="mt-2 d-flex align-items-center">
                       <div class="row" id="imgDiv">
                        <label class="mb-3">Product Image</label>
                        <!-- cover image -->
                        <label for="coverImage" class="mb-3 coverImage d-flex justify-content-center align-items-center ms-3"
                            tabIndex="0"><i class="fa fa-plus-square display-1 position-absolute" id="imgIcon"></i><img
                                src="" class="w-100" id="coverImgPreview"></img></label>
                        <input type="file" name="coverImage" id="coverImage" class="d-none">
                       <!--Thumbnail images-->
                        <input type="file" name="image[]" id="image" class="mt-2 d-none upload_image" data-max_length="20"  accept="image/jpeg, image/jpg, image/png" multiple>
                       </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-inline">
                            <fieldset>
                                <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;">Status
                                </legend>
                                <input type="radio" name="status" id="active" value="1" class="status" checked>
                                <label for="active" class="me-2 ms-1">Active</label>
                                <input type="radio" name="status" id="inactive" value="0" class="status">
                                <label for="inactive" class="ms-1">InActive</label>
                            </fieldset>
                            <label for="status" class="ms-1 error" id="status-error"></label>
                        </div>
                    </div>
                    <div class="row mt-3 d-flex justify-content-between">
                        <button type="button" class="btn prev-step col-3">Back</button>
                        <button type="button" class="btn next-step col-3" id="firstNext">Next</button>
                    </div>
                </div>
                <!-- Additional info -->
                <div class="step step-2">
                    <div class="row">
                        <div class="from-group col-6">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control mt-2" value="1">
                        </div>
                        <div class="from-group col-6">
                            <label for="manufacturer" class="required">Manufacturer</label>
                            <input type="text" name="manufacturer" id="manufacturer" class="form-control mt-2" value="1">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="from-group col-6">
                            <label for="manufacturerDate" class="required">Manufacturer Date</label>
                            <input type="date" name="manufacturerDate" id="manufacturerDate"
                                placeholder="Ex: SteveVendor(SV)" class="form-control mt-2">
                        </div>
                        <div class="from-group col-6">
                            <label for="expiryDate" class="required">Expiry Date</label>
                            <input type="date" name="expiryDate" id="expiryDate" class="form-control mt-2">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="deliveryType">Delivery type</label>
                            <select class="form-control mt-2" name="deliveryType" id="deliveryType">
                                <option value="option_select" disabled selected>Select Delivery Mode</option>
                                @foreach ($deliveryTypes as $deliveryType)
                                    <option value="{{ $deliveryType->id }}">{{ $deliveryType->types }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="form-inline">
                                <fieldset>
                                    <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;">Tax
                                        Include ?
                                    </legend>
                                    <input type="radio" name="taxInclude" id="yes" value="1"
                                        class="taxInclude" checked>
                                    <label for="yes" class="me-2 ms-1">Yes</label>
                                    <input type="radio" name="taxInclude" id="taxNo" value="0"
                                        class="taxInclude">
                                    <label for="taxNo" class="ms-1">No</label>
                                </fieldset>
                                <label for="taxInclude" class="ms-1 error" id="taxInclude-error"></label>
                            </div>
                            <div id="tax">
                                <label for="texValue" class="mb-1">Tax Amount:</label>
                                <div class="form-inline">
                                    <input type="text" oninput="process(this)" name="texValue" id="texValue"
                                        maxlength="6" class=""><select name="taxType"
                                        id="taxType">
                                        <option value="1">Percentage</option>
                                        <option value="2" selected >Fixed</option>
                                    </select>
                                </div>
                                <div class="row"><label for="taxValue" id="taxValue-error" class=error></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 d-flex justify-content-between">
                        <button type="button" class="btn  prev-step col-3">Back</button>
                        <button type="button" class="btn next-step col-3" id='secondNext'>Next</button>
                    </div>
                </div>
                <!-- Sales Info -->
                <div class="step step-3">
                    <div class="row">
                        <div class="form-inline">
                            <fieldset>
                                <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;">Is had
                                    variation ?</legend>
                                <input type="radio" name="variation" id="variant_yes" value="1"
                                    class="variation">
                                <label for="yes" class="me-2 ms-1">Yes</label>
                                <input type="radio" name="variation" id="variant_no" value="0"
                                    class="variation" checked>
                                <label for="No" class="ms-1">No</label>
                            </fieldset>
                            <label for="variation" class="ms-1 error" id="variation-error"></label>
                        </div>
                    </div>
                    <!--Variation row -->
                    <div class="row mt-2">
                        <div class="row" id="variationRow">
                            <div class="row varContent" id="varContent">
                                <div class="row">
                                    <div class="col-6" id="variationBlock">
                                        <label for="variationName">Variation 1</label>
                                        <input type="text" name="variationName[]" id="variationName"
                                            class="varName form-control mt-1">
                                    </div>
                                    <div class="col-6">
                                        <div class="optionBlock" id="optionBlock0">
                                                <label for="options">Options</label>
                                                <input type="text" name="options[]" id="options0"
                                                class="optionValue form-control mt-1">
                                        </div>
                                        <label for="addOptions" id="addOptions"
                                            class="addOptions form-control d-flex justify-content-center mt-2"
                                            style="border: 1px solid rgb(102, 102, 102) ; border-style:dotted;"><i
                                                class="fa fa-plus-circle mt-2"></i> Add Options</label>
                                    </div>
                                </div>
                            </div>
                            <div id="addVar" class="col-6">
                                <label for="addVariations" id="addVariations"
                                    class="addVariations form-control d-flex justify-content-center mt-2"
                                    style="border: 1px solid rgb(102, 102, 102) ; border-style:dotted;"><i
                                        class="fa fa-plus-circle mt-2"></i> Add Variations</label>
                            </div>
                            <span id="varValidate-error" class='error'></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="from-group col-2">
                            <label for="retailPrice" class="required">Retail Price</label>
                            <input type="text" name="retailPrice" maxlength="6" id="retailPrice"
                                class="form-control mt-2"
                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <div class="from-group col-2">
                            <label for="sellingPrice" class="required">Selling Price</label>
                            <input type="text" name="sellingPrice" maxlength="6" id="sellingPrice"
                                class="form-control mt-2"
                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <div class="from-group col-2">
                            <label for="stocks">Stocks</label>
                            <input type="text" name="stocks" maxlength="6" id="stocks"
                                class="form-control mt-2"
                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <div class="from-group col-2">
                            <label for="thresholdQty">Threshold Qty</label>
                            <input type="text" name="thresholdQty" maxlength="6" id="thresholdQty"
                                class="form-control mt-2"
                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <div class="from-group col-2">
                            <label for="sku">Sku</label>
                            <input type="text" name="sku" id="sku" class="form-control mt-2">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-2">
                            <div class="form-inline">
                                <fieldset>
                                    <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;"> Have
                                        return
                                        policy ?
                                    </legend>
                                    <input type="radio" name="returnPolicy" id="policy_yes" value="1"
                                        class="returnPolicy">
                                    <label for="yes" class="me-2 ms-1">Yes</label>
                                    <input type="radio" name="returnPolicy" id="policy_no" value="0"
                                        class="returnPolicy" checked>
                                    <label for="no" class="ms-1">No</label>
                                </fieldset>
                                <label for="returnPolicy" class="ms-1 error" id="returnPolicy-error"></label>
                            </div>
                        </div>
                        <div class="col-3" id="policyTypeContent">
                            <label for="policyType">Select your policy</label>
                            <select class="form-control mt-2" name="policyType " id="policyType">
                                <option value="option_select" disabled selected>Select policy Type</option>
                                {{-- @foreach ($deliveryTypes as $deliveryType)
                                    <option value="{{ $deliveryType->id }}">{{ $deliveryType->types }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 d-flex justify-content-between">
                        <button type="button" class="btn  prev-step col-3">Back</button>
                        <div class="col-3"><button type="submit" class="btn" id="save">Submit</button></div>
                    </div>
                </div>
            </form>
        </div>
        @push('scripts')
            <!-- CK Editor -->
            <script src="{{ asset('assets/plugins/ck_editor/editor.js') }}" referrerpolicy="origin"></script>
            <script>
                // quill editor configuration
                const quill = new Quill('#description', {
                    theme: 'snow'
                });
                $('#description').keyup(function (e) {
                    var quillContent = quill.getText();
                     $('#descriptionContent').html(quillContent);
                    console.log(quillContent);
                });
                /* csrf token*/
                $(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                })
                var categoryObject = {
                    parentCategory: null,
                    childCategory: null,
                };
                var flag = false;
                var string = {
                    productName: null,
                    categoryName: null,
                }
                /* passing parent id data to controller*/
                $('.parent-category').click(function() {
                    let parentCatId = $(this).attr('parentCatID');
                    $('#parentCategoryList').find('.parent-category').removeClass('active');
                    $(this).addClass('active');
                    categoryObject.parentCategory = {
                        name: $(this).text()
                    };
                    string.categoryName = {
                        name: $(this).attr('parentCatName').slice(0, 2)
                    }
                    string.productName = {
                        name: $("#productName").val().slice(0, 3)
                    }
                    categoryObject.childCategory = null;
                    categoryPreview(parentCatId);
                    $.ajax({
                        data: {
                            'parentId': parentCatId
                        },
                        url: "{{ route('product.index') }}",
                        type: "get",
                        success: function(data) {
                            $('#childCategoryList').empty();
                            for (item of data) {
                                $('#childCategoryList').append(
                                    "<li class='child-category border-bottom py-1' role='button' childCatId=" +
                                    item.id + ">" +
                                    item.name +
                                    "</li>")
                            }
                            $('.child-category').click(function() {
                                let childCatId = $(this).attr('childCatId');
                                $('#childCategoryList').find('.child-category').removeClass('active');
                                $(this).addClass('active');
                                categoryObject.childCategory = {
                                    name: $(this).text()
                                };
                                categoryPreview(childCatId);
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#save').html('Save Changes');
                        }
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
                    $('#catPreview').html(categoryNames);
                    $("#category").val(id);
                    $('#category-error').text('');
                }
                $(".next-step").click(function() {
                    if ($('#category').val() != "") {
                        flag = true;
                    } else {
                        $('#category-error').text('Select your product category');
                    }
                });
                // Product form design js
                var currentStep = 1;
                $('#productForm').find('.step').slice(1).hide();
                $(".next-step").click(function() {
                    var basic = $('#productForm');
                    basic.validate({
                        rules: {
                            category: {
                                required: true
                            },
                            coverImage: 'required',
                            descriptionContent: {
                            required: true,
                            minlength: 10 },
                            productName: 'required',
                            manufacturer: 'required',
                            manufacturerDate: 'required',
                            expiryDate: 'required',
                            retailPrice: 'required',
                            sellingPrice: 'required',
                        },
                        message: {
                            coverImage:{
                                required: "Please select a file.",
                                extension: "Please select a file with a valid extension."
                            }
                        },
                    });
                    if (basic.valid() == true && flag == true) {
                        if (currentStep < 3) {
                            $('.step-circle-' + currentStep).css('border-bottom', '2px solid #385399');
                            $('.step-circle-' + (currentStep - 1)).css('border-bottom', 'unset');
                            $(".step-" + currentStep);
                            currentStep++;
                            setTimeout(function() {
                                $(".step").hide();
                                $(".step-" + currentStep).show();
                            });
                        }
                        $('.step-container li:first').click(function () {
                             alert('hello');
                        });
                    }
                    // generating sku
                    let date = new Date();
                    let year = date.getFullYear();
                    let month = date.getMonth() + 1;
                    let lastTwoDigitsOfYear = year.toString().slice(-2);
                    let lastTwoDigitsOfMonth = month.toString().slice(-2);
                    var prefix=string.productName.name+string.categoryName.name;
                    if (prefix.length<5) {
                       prefix=prefix.padEnd('5',"0");
                    }
                        let suffix=lastTwoDigitsOfMonth+lastTwoDigitsOfYear;
                        let sku = prefix+suffix;

                    $('#sku').val(sku);
                });
                 //multi step form navigation
                 function displayStep(stepNumber) {
                        if (stepNumber >= 1 && stepNumber <= 3) {
                            $(".step-" + currentStep).hide();
                            $(".step-" + stepNumber).show();
                            currentStep = stepNumber;
                        }
                    }
                //back button of multi step form
                $(".prev-step").click(function() {
                    if (currentStep > 1) {
                        $('.step-circle-' + (currentStep - 2)).css('border-bottom', '2px solid #385399');
                        $('.step-circle-' + (currentStep - 1)).css('border-bottom', 'unset');
                        $(".step-" + currentStep);
                        currentStep--;
                        setTimeout(function() {
                            $(".step").hide();
                            $(".step-" + currentStep).show();
                        });
                    }
                });
                // cover image preview
                    $('#coverImage').change(function (e) {
                        e.preventDefault();
                        var files = e.target.files;
                        let thumbnailImg_html = '<label for="image" class="mb-3 picture d-flex justify-content-center align-items-center ms-3" tabIndex="0"><i class="fa fa-plus-square display-1 position-absolute" id="plusIcon"></i><img src="" class="w-100" id="imgPreview0"></img></label>';
                        var imageReader = new FileReader();
                        imageReader.onload = function (e){
                            $('#imgIcon').hide();
                            $('#imgDiv').append(thumbnailImg_html);
                            $('#coverImgPreview').attr('src', e.target.result);
                        }
                        imageReader.readAsDataURL(this.files[0]);
                    });
                //  dynamic images and preview
                var imgArray = [];
                $('.upload_image').each(function (index, element) {
                    $(this).change(function(e) {
                    $('#imgPreview,#plusIcon').hide();
                    var maxLength = $(this).attr('data-max_length');
                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    let length = $('.picture').length;
                    filesArr.forEach(function(f,index){
                        if (imgArray.length > maxLength) {
                        return false
                    } else {
                        var len = 0;
                        for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                        }
                        if (len > maxLength) {
                        return false;
                        } else {
                        imgArray.push(f);
                        let imgDesign =
                        "<label for='image' class='ms-2 mb-3 picture d-flex justify-content-center align-items-center position-relative'index="+length+"><i class='fa fa-plus-square display-1 position-absolute' id='plusIcon'></i><img src='' id='imgPreview" +length + "' class='w-100'></img><i class='fa fa-close position-absolute imageCancel' style='top:4px;right:4px;'></i></label>";
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            console.log(imgArray);
                            $('#imgDiv').append(imgDesign);
                            $('#imgPreview' + (length - 1)).attr('src', e.target.result);
                        }
                        reader.readAsDataURL(f);
                        }
                    }
                    });
                });

                });
                // cancel selected image
                $(document).on("click",'.imageCancel', function (e) {
                    var index = $(this).parent().attr('index');
                    imgArray.splice(index, 1);
                    console.log(imgArray);
                    $(this).parent().remove();
                });
                $('#tax').hide();
                // custom tax for product
                var defaultTaxOption = $('input[name ="taxInclude"]:checked');
                $('input[name ="taxInclude"]').click(function () {
                   if ($(this).val() == '0') {
                    $('#tax').show();
                   }
                   if ($(this).val() === defaultTaxOption.val()) {
                    $('#tax').hide();
                   }

                });
                function process(input) {
                    let value = input.value;
                    let letters = value.replace(/\D/g, '');
                    input.value = letters;
                }
                // tax type functionality
                $("#taxType").change(function() {
                    let selectOption = $(this).val();
                    let textField = $('#texValue');
                    textField.off('input');
                    textField.val('100');
                    if (selectOption == '1') {
                        textField.on('input', function() {
                            let value = $(this).val();
                            if (value > 100) {
                                $(this).val(100);
                            }
                        });
                    }
                })
                // variation hide and show based on the radio check
                $('#variationRow').hide();
                var defaultVarOption = $('input[name="variation"]:checked');
                $('input[name="variation"]').click(function () {
                    if($(this).val()=='1'){
                        $('#variationRow').show();
                     }
                     if ($(this).val() === defaultVarOption.val()) {
                            $('#variationRow').hide();
                            $('#variationRow input').val('');
                     }
                });
                var optionFlag = false;
                function checkOptionValidate(){
                    optionFlag = true;
                    $(".optionValue").each(function () {
                       let inputVal = $(this);
                       if (inputVal.val() === "") {
                          optionFlag = false;
                       }
                    });
                }
                // appending options and variations
                $(document).on('click', '.addOptions', function() {
                    let optionVal = $('#options').val();
                    let opLength = $('.optionValue').length;
                    let varLength = $('.varContent .row').length;
                    checkOptionValidate();

                     if (optionFlag && optionVal !== "") {
                        let optionDesign =
                        '<div class="appendedOption'+opLength+' d-flex justify-content-between input-group mt-2"><input type="text" name="options[]" id="options'+(opLength-1)+'" class="optionValue form-control"><i class="fa fa-close optionCancel input-group-text p-2" id="optionCancel"></i></div>';
                        $('#optionBlock' + (varLength - 1)).append(optionDesign);
                     }
                     //option cancel option
                    $(document).on("click",'.optionCancel', function () {
                       $(this).parent().remove();
                     });
                });
                    var optionValid = false;
                    var varValid = false;

                    function checkVariantValidate() {
                        varValid = true;
                        optionValid = true;

                        $('.varContent .row').each(function () {
                            var variationBlock = $(this).find('.variationBlock');
                            var optionBlock = $(this).find('.optionBlock');

                            if (variationBlock.find('.variationName').val() === "") {
                                varValid = false;
                            }

                            if (optionBlock.find('.optionValue').val() === "") {
                                optionValid = false;
                            }
                        });
                    }
                    // additional variation
                    $('.addVariations').click(function() {
                    let optionVal = $('#options').val();
                    let variationVal = $('#variationName').val();
                    let varLength = $('.varContent .row').length;

                    // Validate the input fields
                    checkVariantValidate();
                    // Validate the options input fields
                    checkOptionValidate();
                    // Check if both variation name and options are valid and varLength is within limit
                    if (optionValid && varValid && optionFlag && varLength <= 3 && optionVal !== "" && variationVal !== "") {
                        let VarDesign =
                            '<div class="row"><div class="col-6 variationBlock"><label for="variationName">Variation '+(varLength+1)+'</label><input type="text" name="variationName[]" class="varName form-control mt-1 variationName"></div><div class="col-6"><div class="optionBlock" id="optionBlock'+varLength+'"><label for="options">Options</label><input type="text" name="options[]" class="optionValue form-control mt-1"></div><label for="addOptions" class="addOptions form-control d-flex justify-content-center mt-2" style="border: 1px solid rgb(102, 102, 102) ; border-style:dotted;"><i class="fa fa-plus-circle mt-2"></i> Add Options</label></div></div>';

                        $('#varContent').append(VarDesign);
                        $('#varValidate-error').html("");
                    } else {
                        $('#varValidate-error').html("Both variation and option fields are required, or maximum variations reached.");
                    }
                });
                // selling price validation
                $('#sellingPrice').keyup(function() {
                    let retailAmount = $('#retailPrice').val();
                    let sellingAmount = $('#sellingPrice').val();
                    if (retailAmount < sellingAmount) {
                        $('#sellingPrice').val(retailAmount);
                    }
                });
                // custom return policy option
                $('#policyTypeContent').hide();
                $('input[name="returnPolicy"]').click(function () {
                      if ($(this).val() == '1') {
                        $('#policyTypeContent').show();
                      }
                      if ($(this).val() == '0') {
                        $('#policyTypeContent').hide();
                      }
                });
                // ajax call for the product form
                // $("#productForm").submit(function(event) {

                //     event.preventDefault();

                //     var formData = imgArray;


                //     $.ajax({
                //     url: "{{ route('product.store')}}",
                //     type: "post",
                //     data: formData,
                //     processData: false,
                //     contentType: false,
                //     success: function(response) {
                //         console.log('array send successfully');
                //     },
                //     error: function(xhr, status, error) {
                //       console.log('good bye !');
                //     }
                //     });
                // });
            </script>
        @endpush
    @endsection
