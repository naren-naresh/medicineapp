<table class="table">
    <thead class="border-top">
        <tr>
            @foreach ($variants as $head)
                <th class="title">{{ $head->variant }}</th>
            @endforeach
            <th class="required">Retail Price <small>($)</small></th>
            <th>Selling Price <small>($)</small></th>
            <th>Stock</th>
            <th>SKU</th>
            <th class="status">Status</th>
            <th>Threshold Quality</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; ?>
        @foreach ($product_variants as $productVariant )
            <tr>
                @foreach ($variants as $value)
                    <td>{{$productVariant->getOptionValue($productVariant['id'],$value['id'])}}</td>
                @endforeach
                <td>
                    <input type="text" class="form-control retail-price currency" name="old_product_variants[{{ $count }}][retail_price]" value="{{ $productVariant->retail_price }}" maxlength="10"  placeholder="0.00">
                    <span class="error generated-retail-price-error d-none">Retail price is required</span>
                </td>
                <td>
                    <input type="text" class="form-control selling-price currency" name="old_product_variants[{{ $count }}][selling_price]" value="{{ $productVariant->selling_price }}" maxlength="10" placeholder="0.00">
                </td>
                <td>
                    <input type="text" class="form-control" name="old_product_variants[{{ $count }}][stock]"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $productVariant->stock }}" maxlength="4" placeholder="0">
                </td>
                <td>
                    <input type="text" class="form-control" name="old_product_variants[{{ $count }}][sku]" value="{{ $productVariant->sku ? $productVariant->sku: null }}">
                </td>
                <td>
                    <label class="switch">
                        <input type="checkbox" name="old_product_variants[{{ $count }}][status]" @if($productVariant['status']) checked @endif value="1">
                        <span class="slider round"></span>
                    </label>
                    <input type="hidden" name="old_product_variants[{{ $count }}][variant_id]" value="{{ $productVariant['id'] }}" class="variant-id">
                </td>
                <td>
                    <input type="text" class="form-control" name="old_product_variants[{{ $count }}][threshold_qty]"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $productVariant->threshold_qty  }}" maxlength="4" placeholder="0">
                </td>
                <td>
                    <a data-count="{{ $count }}" class="remove-variant">Remove</a>
                </td>
            <?php $count++;  ?>
        @endforeach
    </tbody>
</table>
<button type="button" class="btn" id="changeBtn">Change</button>
