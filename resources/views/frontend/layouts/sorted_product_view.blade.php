@foreach ($products as $product)
<div class="col-3 p-card pt-5">
    <div class="pc-con">
        <div class="pc-img">
            <img
                src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}">
            <span class="heartSpan"><a href="#"><i
                        class="far fa-heart"></i></a></span>
        </div>
        <div class="pc-text py-3">
            <p class="pc-title"><a
                    href="#">{{ Illuminate\Support\Str::limit($product->name, 40) }}</a>
            </p>
            <div class="price py-1">$ {{ $product->selling_price }}</div>
            <span class="d-status text-success">Delivery available</span>
            <div class="pc-view pt-2">
                <a href="#" class="pc-btn">View</a>
            </div>
        </div>
    </div>
</div>
@endforeach
