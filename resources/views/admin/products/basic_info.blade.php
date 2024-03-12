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
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h5 class="card-title m-0">Add New Product</h5>
            <div aria-label="breadcrumb" class="col-6">
                <ol class="breadcrumb step-container d-flex justify-content-between float-end m-0">
                    <li class="step-circle-0 mx-1" style="border-bottom: 2px solid #385399;" step='1' id='step_1'> Basic
                        Information</li>
                    <li class="step-circle-1 mx-1" step='2' id='step_2'>Additional Information</li>
                    <li class="step-circle-2 mx-1" step='3' id='step_3'>Sales Information</li>
                </ol>
            </div>
        </div>
        <div class="car-body px-4 py-3">
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
                            @if ($errors->has('productName'))
                               <span class="text-danger">{{ $errors->first('productName') }}</span>
                            @endif
                            <span id="product-error" class="error">Product name is required.</span>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label for="category" class="required">Category</label>
                            <ul class="bg-white my-2 list-unstyled" id="parentCategoryList" style="border: 1px solid #b3b3b3">
                                @foreach ($categories as $categoryName)
                                    <li parentCatID="{{ $categoryName->id }}"
                                        class="parent-category border-bottom px-2 py-2" role="button"
                                        parentCatName="{{ $categoryName->name }}">
                                        {{ $categoryName->name }} <i class="fa fa-angle-right float-end"></i></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="mt-4 bg-white list-unstyled px-2" id="childCategoryList">
                            </ul>
                        </div>
                        <input type="hidden" name="category" id="category">
                        @if ($errors->has('category'))
                          <span class="text-danger">{{ $errors->first('category') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <p id='catPreview' class=" mt-0"></p>
                        <span id="category-error" class="error">Product category is required.</span>
                    </div>
                    <hr style="color:#b3b3b3;">
                    <div class="row mt-2 w-100 ps-3">
                        <label for="description" class="mb-2 p-0 required">Product Description</label>
                        <div name="description" id="description" style="height: 200px "></div>
                        <textarea name="descriptionContent" id="descriptionContent" class="d-none"></textarea>
                        <span id="descriptionContent-error" class="error">Product description is required.</span>
                        @if ($errors->has('descriptionContent'))
                          <span class="text-danger">{{ $errors->first('descriptionContent') }}</span>
                        @endif
                    </div>
                    <div class="mt-2 d-flex align-items-center">
                       <div class="row" id="imgDiv">
                        <label class="mb-3 required">Product Image</label>
                        <!-- cover image -->
                        <label for="coverImage" class="mb-3 coverImage d-flex justify-content-center align-items-center ms-3"
                            tabIndex="0"><i class="fa fa-plus-circle position-absolute" id="imgIcon" style="font-size: 1.5rem"></i><img
                                src="" class="w-100" id="coverImgPreview"></img></label>
                        <input type="file" name="coverImage" id="coverImage" class="d-none">
                       <!--Thumbnail images-->
                        <input type="file" name="image[]" id="image" class="mt-2 d-none upload_image" data-max_length="20"  accept="image/jpeg, image/jpg, image/png" multiple>
                       </div>
                    </div>
                    <span id="coverImage-error" class="error">At least one product image is required.</span>
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
                    <hr style="color:#b3b3b3;">
                    <div class="row my-3 py-2 d-flex justify-content-between">
                        <button type="button" class="btn prev-step col-3">Cancel</button>
                        <button type="button" class="btn next-step col-3" id="firstNext">Next</button>
                    </div>
                </div>
                <!-- Additional info -->
                <div class="step step-2">
                    <div class="row">
                        <div class="from-group col-6">
                            <label for="brand">Brand</label>
                            <select class="form-control mt-2" name="brand" id="brand">
                                <option value="option_select" disabled selected>Select product brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="from-group col-6">
                            <label for="manufacturer" class="required">Manufacturer</label>
                            <select class="form-control mt-2" name="manufacturer" id="manufacturer">
                                <option value="option_select" disabled selected>Select manufacturer</option>
                                @foreach ($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                @endforeach
                            </select>
                            <span id="manufacturer-error" class="error">Product manufacturer is required.</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="from-group col-6">
                            <label for="manufacturerDate" class="required">Manufacturer Date</label>
                            <input type="date" name="manufacturerDate" id="manufacturerDate"
                                placeholder="Ex: SteveVendor(SV)" class="form-control mt-2">
                                <span id="manufacturerDate-error" class="error">Product manufacturer date is required.</span>
                        </div>
                        <div class="from-group col-6">
                            <label for="expiryDate" class="required">Expiry Date</label>
                            <input type="date" name="expiryDate" id="expiryDate" class="form-control mt-2">
                            <span id="expiryDate-error" class="error">Product expiry date is required.</span>
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
                            <div class="row">
                                <div class="form-inline col-3">
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
                                <div id="tax" class="col-3">
                                    <label for="texValue" class="mb-1">Tax Amount:</label>
                                    <div class="form-inline d-flex justify-content-between">
                                        <input type="text" oninput="process(this)" name="texValue" id="texValue" maxlength="6" class="form-control" style="width: 100px">
                                        <select name="taxType" id="taxType" class="form-control" style="width: 100px">
                                            <option value="1">Percentage</option>
                                            <option value="2" selected >Fixed</option>
                                        </select>
                                    </div>
                                    <div class="row"><label for="taxValue" id="taxValue-error" class=error></label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3 d-flex justify-content-between">
                        <button type="button" class="btn  prev-step col-3" step='2'>Back</button>
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
                    <hr style="color:#b3b3b3;">
                    <div class="row my-2 justify-content-between">
                        <div class="from-group col-2">
                            <label for="retailPrice" class="required">Retail Price</label>
                            <input type="text" name="retailPrice" maxlength="6" id="retailPrice"
                                class="form-control mt-2"
                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                <span id="retailPrice-error" class="error">Product retail price is required.</span>
                        </div>
                        <div class="from-group col-2">
                            <label for="sellingPrice" class="required">Selling Price</label>
                            <input type="text" name="sellingPrice" maxlength="6" id="sellingPrice"
                                class="form-control mt-2"
                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                <span id="sellingPrice-error" class="error">Product selling price is required.</span>
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
                                @foreach ($returnPolicies as $policy)
                                    <option value="{{ $policy->id }}">{{ $policy->policy_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr style="color:#b3b3b3;">
                    <div class="row my-3 d-flex justify-content-between">
                        <button type="button" class="btn  prev-step col-3" step='3'>Back</button>
                        <div class="col-3"><button type="submit" class="btn" id="save">Submit</button></div>
                    </div>
                </div>
            </form>
        </div>
        @push('scripts')
            <!-- CK Editor -->
            <script src="{{ asset('assets/plugins/ck_editor/editor.js') }}" referrerpolicy="origin"></script>
            <script>
                const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],
                ['link', 'image', 'video', 'formula'],

                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction

                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean']                                         // remove formatting button
                ];

                // quill editor configuration
                const quill = new Quill('#description', {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    theme: 'snow'
                });
                // getting values from the quill editor
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
                /* passing parent id data to controller */
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
                // function for multi step form validation
                $('#productForm').find('.step').slice(1).hide();
                $('.error').hide();
                function stepOne() {
                    var firstStepFlag = true;

                    if ($('#productName').val() === '') {
                        $('#product-error').show();
                        firstStepFlag = false;
                    } else {
                        $('#product-error').hide();
                    }

                    if ($('#category').val() === '') {
                        $('#category-error').show();
                        firstStepFlag = false;
                    } else {
                        $('#category-error').hide();
                    }
                    if ($('#descriptionContent').val() === '') {
                        $('#descriptionContent-error').show();
                        firstStepFlag = false;
                    } else {
                        $('#descriptionContent-error').hide();
                    }
                    if ($('#coverImage').val() === '') {
                        $('#coverImage-error').show();
                        firstStepFlag = false;
                    } else {
                        $('#coverImage-error').hide();
                    }

                    return firstStepFlag;
                }

                function stepTwo(){
                    var secondStepFlag = true;
                    if ($('#manufacturer').val() === '') {
                        $('#manufacturer-error').show();
                        secondStepFlag = false;
                    } else {
                        $('#manufacturer-error').hide();
                    }
                    if ($('#manufacturerDate').val() === '') {
                        $('#manufacturerDate-error').show();
                        secondStepFlag = false;
                    } else {
                        $('#manufacturerDate-error').hide();
                    }
                    if ($('#expiryDate').val() === '') {
                        $('#expiryDate-error').show();
                        secondStepFlag = false;
                    } else {
                        $('#expiryDate-error').hide();
                    }

                    return secondStepFlag;

                }
                function stepThree() {

                    var thirdStepFlag = true;
                    if ($('#retailPrice').val() === '') {
                        $('#retailPrice-error').show();
                        thirdStepFlag = false;
                    } else {
                        $('#retailPrice-error').hide();
                    }
                    if ($('#sellingPrice').val() === '') {
                        $('#sellingPrice-error').show();
                        thirdStepFlag = false;
                    } else {
                        $('#sellingPrice-error').hide();
                    }
                    return thirdStepFlag;
                }
                // first step validation
                $('#firstNext').click(function () {
                    if (stepOne()) {
                        $('#step_1').css('border-bottom', 'unset');
                        $('#step_2').css('border-bottom', '2px solid #385399');
                        $('#step_3').css('border-bottom', 'unset');
                      $('.step-1').hide();
                      $('.step-2').show();
                      $('.step-3').hide();
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
                    }

                });
                // second step validation
                $('#secondNext').click(function () {
                       if ( stepOne() && stepTwo()) {
                            $('#step_3').css('border-bottom', '2px solid #385399');
                            $('#step_1').css('border-bottom', 'unset');
                            $('#step_2').css('border-bottom', 'unset');
                            $('.step-1').hide();
                            $('.step-2').hide();
                            $('.step-3').show();
                       }else{
                        Swal.fire("Some details are missing kindly check it!");
                       }
                });
                // final submit validation
                $('#productForm').submit(function (e) {
                           $('#step_3').css('border-bottom', '2px solid #385399');
                            $('#step_1').css('border-bottom', 'unset');
                            $('#step_2').css('border-bottom', 'unset');
                    if (stepOne() && stepTwo() && stepThree()) {
                        Swal.fire({
                        title: "Details submitted successfully!",
                        text: "Thank you!",
                        icon: "success"
                        });
                        $('#productForm').submit();
                    }else{
                        Swal.fire("Some details are missing kindly check before Submit!");
                        e.preventDefault();
                    }

                });
                // multiStep navigation
                $('#step_1').click(function () {
                    $(this).css('border-bottom', '2px solid #385399');
                    $('#step_2').css('border-bottom', 'unset');
                    $('#step_3').css('border-bottom', 'unset');
                    $('.step-1').show();
                    $('.step-2').hide();
                    $('.step-3').hide();
                });
                $('#step_2').click(function () {
                          if (stepOne()) {
                            $(this).css('border-bottom', '2px solid #385399');
                            $('#step_1').css('border-bottom', 'unset');
                            $('#step_3').css('border-bottom', 'unset');
                            $('.step-1').hide();
                            $('.step-2').show();
                            $('.step-3').hide();
                          }
                });
                $('#step_3').click(function () {
                          if (stepOne() && stepTwo()) {
                            $('#step_3').css('border-bottom', '2px solid #385399');
                            $('#step_1').css('border-bottom', 'unset');
                            $('#step_2').css('border-bottom', 'unset');
                            $('.step-1').hide();
                            $('.step-2').hide();
                            $('.step-3').show();
                          }
                });
                //back button of multi step form
                $(".prev-step").each(function() {
                   $(this).click(function () {
                    var currentStep = $(this).attr('step');
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
