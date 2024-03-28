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
            <h5 class="card-title m-0">Edit Product</h5>
            <div aria-label="breadcrumb" class="col-6">
                <ol class="breadcrumb step-container d-flex justify-content-between float-end m-0">
                    <li class="step-circle-0 mx-1" style="border-bottom: 2px solid #385399;" step='1' id='step_1'>
                        Basic
                        Information</li>
                    <li class="step-circle-1 mx-1" step='2' id='step_2'>Additional Information</li>
                    <li class="step-circle-2 mx-1" step='3' id='step_3'>Sales Information</li>
                </ol>
            </div>
        </div>
        <div class="car-body px-4 py-3">
            <form action="{{ route('product.update',$product->id) }}" name="productForm" id="productForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!--basic info-->
                <div class="step step-1">
                    <div class="row">
                        <div class="from-group col-12">
                            <label for="productName" class="required">Product Name</label>
                            <input type="text" name="productName" id="productName" class="form-control mt-2"
                                value="{{ $product->name }}">
                            @if ($errors->has('productName'))
                                <span class="text-danger">{{ $errors->first('productName') }}</span>
                            @endif
                            <span id="product-error" class="error">Product name is required.</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="parentCategoryList" class="required py-1">Category</label>
                            <ul class="bg-white my-2 list-unstyled border border-bottom-0" id="parentCategoryList"
                                style="height: 180px; overflow-y:auto">
                                @foreach ($categories as $categoryName)
                                    <li parentCatID="{{ $categoryName->id }}"
                                        class="parent-category border-bottom px-2 py-2" role="button"
                                        parentCatName="{{ $categoryName->name }}">
                                        {{ $categoryName->name }} <i class="fa fa-angle-right float-end"></i></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="mt-5 bg-white list-unstyled px-2" id="childCategoryList">
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
                        <label for="descriptionContent" class="mb-2 p-0 py-1 required">Product Description</label>
                        <div name="description" id="description" style="height: 200px ">{{ $product->description }}</div>
                        <textarea name="descriptionContent" id="descriptionContent" class="d-none">{{ $product->description }}</textarea>
                        <span id="descriptionContent-error" class="error p-0">Product description is required.</span>
                        @if ($errors->has('descriptionContent'))
                            <span class="text-danger">{{ $errors->first('descriptionContent') }}</span>
                        @endif
                    </div>
                    <div class="row mt-3 align-items-center">
                        <label for="coverImage" class="pb-2 required">Product Image</label>
                        <div class="d-flex align-items-center  product-image-sec">
                            <!-- cover image -->
                            <div class="" id="imgDiv">
                                <label for="coverImage"
                                    class="mb-3 coverImage d-flex justify-content-center align-items-center ms-3"
                                    tabIndex="0">
                                    <img src="" class="w-100" id="coverImgPreview"></label>
                                <input type="file" name="coverImage" id="coverImage" class="d-none" accept="image/*">
                                <input type="hidden" name="oldCoverImage" value="{{ $product->cover_image }}">
                            </div>
                            <!--Thumbnail images-->
                            <div class="d-flex align-items-center" id="thumbImgDiv"></div>
                            <input type="hidden" name="oldThumbnailImage" value="{{ $product->thumbnail_images }}">
                        </div>
                    </div>
                    <span id="coverImage-error" class="error">At least one product image is required.</span>
                    <div class="row mt-2">
                        <div class="form-inline">
                            <fieldset>
                                <legend class="py-1" style=" font-size:15px;font-weight:unset !important;">Status
                                </legend>
                                <input type="radio" name="status" id="active" value="1" class="status"
                                    checked>
                                <label for="active" class="me-2 ms-1">Active</label>
                                <input type="radio" name="status" id="inactive" value="0" class="status">
                                <label for="inactive" class="ms-1">InActive</label>
                            </fieldset>
                            <label for="active" class="ms-1 error" id="status-error"></label>
                        </div>
                    </div>
                    <hr style="color:#b3b3b3;">
                    <div class="row my-3 py-2 d-flex justify-content-between">
                        <div class="col-3"><a href="{{ route('product.index') }}" class="btn">Cancel</a></div>
                        <div class="col-3"><button type="button" class="btn next-step float-end"
                                id="firstNext">Next</button></div>
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
                                    <option value="{{ $manufacturer->id }}"
                                        @if ($product->manufacturer_id === $manufacturer->id) selected @endif>{{ $manufacturer->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="manufacturer-error" class="error">Product manufacturer is required.</span>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="from-group col-6">
                            <label for="manufacturerDate" class="required">Manufacturer Date</label>
                            <input type="date" name="manufacturerDate" id="manufacturerDate"
                                class="form-control mt-2" value="{{ $product->manufacturer_date }}">
                            <span id="manufacturerDate-error" class="error">Product manufacturer date is required.</span>
                        </div>
                        <div class="from-group col-6">
                            <label for="expiryDate" class="required">Expiry Date</label>
                            <input type="date" name="expiryDate" id="expiryDate" class="form-control mt-2"
                                value="{{ $product->expiry_date }}">
                            <span id="expiryDate-error" class="error">Product expiry date is required.</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="deliveryType">Delivery type</label>
                            <select class="form-control mt-2" name="deliveryType" id="deliveryType">
                                <option value="option_select" disabled selected>Select Delivery Mode</option>
                                @foreach ($deliveryTypes as $deliveryType)
                                    <option value="{{ $deliveryType->id }}"
                                        @if ($product->delivery_type_id === $deliveryType->id) selected @endif>{{ $deliveryType->types }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="form-inline col-3">
                                    <fieldset>
                                        <legend class="mb-1" style=" font-size:15px;font-weight:unset !important;">Tax
                                            Include ?
                                        </legend>
                                        <input type="radio" name="taxInclude" id="yes" value="1" class="taxInclude" {{ $product->tax_include == '1' ? 'checked' : '' }}>
                                        <label for="yes" class="me-2 ms-1">Yes</label>
                                        <input type="radio" name="taxInclude" id="taxNo" value="0" class="taxInclude" {{ $product->tax_include == '0' ? 'checked' : '' }}>
                                        <label for="taxNo" class="ms-1">No</label>
                                    </fieldset>
                                    <label class="ms-1 error" id="taxInclude-error"></label>
                                </div>
                                <div id="tax" class="col-3">
                                    <label for="texValue" class="mb-1">Tax Amount:</label>
                                    <div class="form-inline d-flex justify-content-between">
                                        <input type="text" oninput="process(this)" name="texValue" id="texValue"
                                            maxlength="6" class="form-control" style="width: 100px" value="{{ $product->tax}}">
                                        <select name="taxType" id="taxType" class="form-control" style="width: 100px">
                                            <option value="1">Percentage</option>
                                            <option value="2" selected>Fixed</option>
                                        </select>
                                    </div>
                                    <div class="row"><label id="taxValue-error" class=error></label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-5" style="color:#b3b3b3">
                    <div class="row my-3 d-flex justify-content-between">
                        <div class="col-3"><button type="button" class="btn  prev-step" step='2'>Back</button>
                        </div>
                        <div class="col-3"><button type="button" class="btn next-step float-end"
                                id='secondNext'>Next</button></div>
                    </div>
                </div>
                <!-- Sales Info -->
                <div class="step step-3">
                    <div class="row">
                        <div class="form-inline">
                            <fieldset>
                                <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;">Is had
                                    variation ?</legend>
                                <input type="radio" name="is_variation" id="variant_yes" value="1"{{ $product->have_variation == '1' ? 'checked' : '' }}
                                    class="variation">
                                <label for="variant_yes" class="me-2 ms-1">Yes</label>
                                <input type="radio" name="is_variation" id="variant_no" value="0"{{ $product->have_variation == '0' ? 'checked' : '' }}
                                    class="variation">
                                <label for="variant_no" class="ms-1">No</label>
                            </fieldset>
                            <label class="ms-1 error" id="variation-error"></label>
                        </div>
                    </div>
                    <!--Variation row -->
                    <div class="row mt-2">
                        <div class="row" id="variationRow">
                            <div class="row varContent" id="varContent">
                                <?php $flag = 1 ?>
                                @if ($variants->count() > 0)
                                @foreach ( $variants as $dbVariant )
                                <div class="row">
                                    <div class="col-6" id="variationBlock">
                                        <label for="variationName">Variation {{$flag}}</label>
                                        <input type="text" name="variationName[]" id="variationName"
                                            class="varName form-control mt-1" value="{{$dbVariant->variant}}">
                                    </div>
                                    <div class="col-6">
                                        <div class="optionBlock" id="optionBlock{{$flag-1}}">
                                            <?php $opFlag=0;?>
                                            @php
                                                $optionValues = $options->where('variant_option_id', $dbVariant->id);
                                            @endphp
                                            <label for="options{{$opFlag}}">Options</label>
                                            @foreach ( $optionValues as $opValue )
                                                <input type="text" name="options[{{$flag-1}}][]" id="options{{$opFlag}}" class="optionValue form-control mt-1" value="{{ $opValue->variant_option_values}}">
                                                <?php $opFlag++;?>
                                            @endforeach
                                        </div>
                                        <label id="addOptions"
                                            class="addOptions form-control d-flex align-items-center justify-content-center mt-2"
                                            style="border: 1px solid rgb(102, 102, 102) ; border-style:dotted;"><i
                                                class="fa fa-plus-circle mx-2"></i> Add Options</label>
                                    </div>
                                </div>
                                 <?php $flag++; ?>
                                @endforeach
                                @else
                                    <div class="row">
                                        <div class="col-6" id="variationBlock">
                                            <label for="variationName">Variation 1</label>
                                            <input type="text" name="variationName[]" id="variationName"
                                                class="varName form-control mt-1">
                                        </div>
                                        <div class="col-6">
                                            <div class="optionBlock" id="optionBlock0">
                                                    <label for="options0">Options</label>
                                                    <input type="text" name="options[0][]" id="options0"
                                                    class="optionValue form-control mt-1">
                                            </div>
                                            <label id="addOptions"
                                                class="addOptions form-control d-flex align-items-center justify-content-center mt-2"
                                                style="border: 1px solid rgb(102, 102, 102) ; border-style:dotted;"><i
                                                    class="fa fa-plus-circle mx-2"></i> Add Options</label>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div id="addVar" class="col-6">
                                <label id="addVariations"
                                    class="addVariations form-control d-flex align-items-center justify-content-center mt-2"
                                    style="border: 1px solid rgb(102, 102, 102) ; border-style:dotted;"><i
                                        class="fa fa-plus-circle mx-2"></i> Add Variations</label>
                            </div>
                            <span id="variants-error" class='error'>Both variation and option fields are required, or
                                maximum variations reached.</span>
                        </div>
                    </div>
                    <hr style="color:#b3b3b3;">
                    <div class="row my-2 justify-content-between" id="priceRow">
                        <div class="from-group col">
                            <label for="retailPrice" class="required">Retail Price</label>
                            <input type="text" name="retailPrice" maxlength="8" id="retailPrice"
                                class="form-control mt-2" onkeyup="process(this)" value="{{ $product->retail_price }}">
                            <span id="retailPrice-error" class="error">Product retail price is required.</span>
                        </div>
                        <div class="from-group col">
                            <label for="sellingPrice" class="required">Selling Price</label>
                            <input type="text" name="sellingPrice" maxlength="8" id="sellingPrice"
                                class="form-control mt-2" onkeyup="process(this)" value="{{ $product->selling_price }}">
                            <span id="sellingPrice-error" class="error">Product selling price is required.</span>
                        </div>
                        <div class="from-group col">
                            <label for="stocks">Stocks</label>
                            <input type="text" name="stocks" maxlength="6" id="stocks"
                                class="form-control mt-2" onkeyup="process(this)" value="{{ $product->stock }}">
                        </div>
                        <div class="from-group col">
                            <label for="thresholdQty">Threshold Qty</label>
                            <input type="text" name="thresholdQty" maxlength="3" id="thresholdQty"
                                class="form-control mt-2" onkeyup="process(this)" value="{{ $product->threshold_qty }}">
                        </div>
                        <div class="from-group col">
                            <label for="sku">Sku</label>
                            <input type="text" name="sku" id="sku" class="form-control mt-2"
                                value="{{ $product->sku }}">
                        </div>
                        <div><button type="button" class="btn mt-3 float-end" id="generateVariation">Apply</button>
                        </div>
                        <div id="productPreview" class="my-4"></div>
                    </div>
                    @if ($variants->count() > 0)
                    <div id="existingProductPreview" class="my-4"> @include('admin.products.editvariants')</div>
                    @endif
                    <hr style="color: #b3b3b3">
                    <div class="row mt-3">
                        <div class="col-2">
                            <div class="form-inline">
                                <fieldset>
                                    <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;"> Have
                                        return
                                        policy ?
                                    </legend>
                                    <input type="radio" name="returnPolicy" id="policy_yes" value="1" class="returnPolicy" {{ $product->return_policy_applicable == '1' ? 'checked' : '' }}>
                                    <label for="policy_yes" class="me-2 ms-1">Yes</label>
                                    <input type="radio" name="returnPolicy" id="policy_no" value="0" class="returnPolicy" {{ $product->return_policy_applicable == '0' ? 'checked' : '' }}>
                                    <label for="policy_no" class="ms-1">No</label>
                                </fieldset>
                                <label class="ms-1 error" id="returnPolicy-error"></label>
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
                        <div class="col-3"><button type="button" class="btn  prev-step" step='3'>Back</button>
                        </div>
                        <div class="col-3"><button type="submit" class="btn float-end" id="save">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <style>
              .disabled-label {
        opacity: 0.5;
        cursor: default;
        }
        </style>
        @pushOnce('styles')
            <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
        @endPushOnce
        @pushOnce('scripts')
            <!-- quill editor -->
            <script src="{{ asset('assets/plugins/quill/quill.js') }}"></script>
            <!-- data attributes for global routes -->
            <script>
                var productIndexRoute = "{{ route('product.add') }}";
                var destroyProductVariantRoute = "{{ route('product.destroyVariant')}}"
                var productVariantRoute = "{{ route('productVariant') }}";
                var oldParentCateId = "{{ $parentCatId }}"
                var oldChildCateId = "{{ $childCatId }}"
                var product_id = "{{ $product->id }}"
                var coverImage = "{{ $product->cover_image}}"
                var thumbnailImages = {!! $thumbnailImages !!};
                var variants = {!! $variants !!};
                var options = {!! $options !!}
                var product = {!! $product !!}
                var oldCombo = {!! $comboArray !!}
            </script>
            <script src="{{ asset('assets/js/product_edit.js') }}"></script>
        @endPushOnce
    @endsection
