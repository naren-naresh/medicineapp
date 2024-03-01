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
                    <li class="step-circle-0 mx-1" onclick="displayStep(1)" style="border-bottom: 2px solid #385399;">Basic
                        Information</li>
                    <li class="step-circle-1 mx-1" onclick="displayStep(2)">Additional Information</li>
                    <li class="step-circle-2 mx-1" onclick="displayStep(3)">Sales Information</li>
                </ol>
            </div>
        </div>
        <div class="car-body px-5 py-3">
            <form action="{{ route('product.basicInfo.post') }}" name="productForm" id="productForm" method="post"
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
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="category" class="required">Category</label>
                            <ul class="bg-white mt-2 list-unstyled" id="parentCategoryList">
                                @foreach ($categories as $categoryName)
                                    <li parentCatID="{{ $categoryName->id }}"
                                        class="parent-category border-bottom px-2 py-1" role="button">
                                        {{ $categoryName->name }} <i class="fa fa-angle-right float-end"></i></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-6">
                            <label for="category" class="required">Sub Category</label>
                            <ul class="mt-2 bg-white list-unstyled px-2" id="childCategoryList">
                            </ul>
                        </div>
                        <p for="category" id="category-error" class="error"></p>
                        <input type="hidden" name="category" id="category">
                    </div>
                    <div class="row">
                        <p id='catPreview'></p>
                    </div>
                    <div class="row mt-2">
                        <label for="description" class="mb-2">Product Description</label>
                        <div name="description" id="description" class="mt-2"></div>
                    </div>
                    <div class="row mt-2" id="imgDiv">
                        <label class="mb-3">Product Image</label>
                        <label for="image" class="mb-3 picture d-flex justify-content-center align-items-center"
                            tabIndex="0"><img src="" class="imgPreview w-100 "></img></label>
                        <input type="file" name="image[]" id="image" class="mt-2 d-none" multiple>
                    </div>
                    <div class="row mt-2">
                        <div class="form-inline">
                            <fieldset>
                                <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;">Status
                                </legend>
                                <input type="radio" name="status" id="active" value="1" class="status">
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
                            <input type="text" name="brand" id="brand" class="form-control mt-2">
                        </div>
                        <div class="from-group col-6">
                            <label for="manufacturer" class="required">Manufacturer</label>
                            <input type="text" name="manufacturer" id="manufacturer" class="form-control mt-2">
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
                            <select class="form-control mt-2" name="deliveryType " id="deliveryType">
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
                                        class="taxInclude">
                                    <label for="yes" class="me-2 ms-1">Yes</label>
                                    <input type="radio" name="taxInclude" id="no" value="0"
                                        class="taxInclude">
                                    <label for="no" class="ms-1">No</label>
                                </fieldset>
                                <label for="taxInclude" class="ms-1 error" id="taxInclude-error"></label>
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
                        <div class="from-group col-2">
                            <label for="retailPrice" class="required">Retail Price</label>
                            <input type="text" name="retailPrice" id="retailPrice" class="form-control mt-2">
                        </div>
                        <div class="from-group col-2">
                            <label for="sellingPrice" class="required">Selling Price</label>
                            <input type="text" name="sellingPrice" id="sellingPrice" class="form-control mt-2">
                        </div>
                        <div class="from-group col-2">
                            <label for="stocks">Stocks</label>
                            <input type="text" name="stocks" id="stocks" class="form-control mt-2">
                        </div>
                        <div class="from-group col-2">
                            <label for="thresholdQty">Threshold Qty</label>
                            <input type="text" name="thresholdQty" id="thresholdQty" class="form-control mt-2">
                        </div>
                        <div class="from-group col-2">
                            <label for="sku">Sku</label>
                            <input type="text" name="sku" id="sku" class="form-control mt-2">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
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
                                        class="returnPolicy">
                                    <label for="no" class="ms-1">No</label>
                                </fieldset>
                                <label for="returnPolicy" class="ms-1 error" id="returnPolicy-error"></label>
                            </div>
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
                /* passing parent id data to controller*/
                $('.parent-category').click(function() {
                    let parentCatId = $(this).attr('parentCatID');
                    $('#parentCategoryList').find('.parent-category').removeClass('active');
                    $(this).addClass('active');
                    categoryObject.parentCategory = {
                        name: $(this).text()
                    };
                    categoryObject.childCategory = null;
                    categoryPreview(parentCatId);
                    $.ajax({
                        data: {
                            'parentId': parentCatId
                        },
                        url: "{{ route('product.basicInfo') }}",
                        type: "get",
                        success: function(data) {
                            $('#childCategoryList').empty();
                            for (item of data) {
                                $('#childCategoryList').append(
                                    "<li class='child-category border-bottom py-1' role='button'>" +
                                    item.name +
                                    "</li>")
                            }
                            $('.child-category').click(function() {
                                $('#childCategoryList').find('.child-category').removeClass('active');
                                $(this).addClass('active');
                                categoryObject.childCategory = {
                                    name: $(this).text()
                                };
                                categoryPreview(parentCatId);
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#save').html('Save Changes');
                        }
                    });
                });

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
                            productName: 'required',
                            manufacturer: 'required',
                            manufacturerDate: 'required',
                            expiryDate: 'required',
                            retailPrice: 'required',
                            sellingPrice: 'required',
                        },
                        message: {
                            required: "This field is required",
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
                    }
                });

                // function displayStep(stepNumber) {
                //     if (stepNumber >= 1 && stepNumber <= 3) {
                //         $(".step-" + currentStep).hide();
                //         $(".step-" + stepNumber).show();
                //         currentStep = stepNumber;
                //     }
                // }
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
                // dynamic images upload
                var readURL = function(input) {
                    let imgDesign="<label for='image' class='ms-2 mb-3 picture d-flex justify-content-center align-items-center'><img src='' class='imgPreview w-100'></img></label>";
                    if (input.files && input.files[0]) {
                        let length=$('.picture').length;
                        console.log(length);
                        $('#imgDiv').after('#image').append(imgDesign);
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('.imgPreview').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#image").change(function (){
                    readURL(this);
                });
            </script>
        @endpush
    @endsection
