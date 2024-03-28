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
        @foreach ($existOptions as $option)
            <tr>
                @foreach ($option as $key => $value)
                    <td>
                        <input type="hidden" name="old_product_variants[{{ $count }}][value][]" value="{{ $value }}">
                        {{ $value }}
                    </td>
                @endforeach
                <td>
                    <input type="text" class="form-control retail-price currency" name="product_variants[{{ $count }}][retail_price]" value="{{ $product->retail_price }}" maxlength="10"  placeholder="0.00">
                    <span class="error generated-retail-price-error d-none">Retail price is required</span>
                </td>
                <td>
                    <input type="text" class="form-control selling-price currency" name="product_variants[{{ $count }}][selling_price]" value="{{ $product->selling_price }}" maxlength="10" placeholder="0.00">
                </td>
                <td>
                    <input type="text" class="form-control" name="product_variants[{{ $count }}][stock]"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $product->stock }}" maxlength="4" placeholder="0">
                </td>
                <td>
                    <input type="text" class="form-control" name="product_variants[{{ $count }}][sku]" value="{{ $product->sku ? $product->sku.$count : null }}">
                </td>
                <td>
                    <label class="switch">
                        <input type="checkbox" name="product_variants[{{ $count }}][status]" checked value="1">
                        <span class="slider round"></span>
                    </label>
                </td>
                <td>
                    <input type="text" class="form-control" name="product_variants[{{ $count }}][threshold_qty]"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $product->threshold_qty  }}" maxlength="4" placeholder="0">
                </td>
                <td>
                    <a data-count="{{ $count }}" class="remove-variant">Remove</a>
                </td>
            <?php $count++;  ?>
        @endforeach
    </tbody>
</table>
<button type="button" class="btn" id="changeBtn">Change</button>
