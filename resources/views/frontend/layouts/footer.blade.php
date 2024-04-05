<footer class="footer-section">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <h3>Shop By Category</h3>
                <ul class="option-list p-0">
                    @foreach ($parent_categories as $pCat )
                     <li><a href="#">{{$pCat->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col">
                <h3>Information</h3>
                <ul class="option-list p-0">
                    <li><a href="#">Term of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Shipping, Postage & Returns</a></li>
                    <li><a href="#">Trade Account Application</a></li>
                </ul>
            </div>
            <div class="col">
                <h3>Quick Link</h3>
                <ul class="option-list p-0">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="col">
                <h3>Download The App</h3>
                <div class="store-images d-flex">
                    <div class="image1 me-1"><a href="#"><img src="{{ asset('assets/frontend/images/google-play.png') }}"></a></div>
                    <div class="image2"><a href="#"><img src="{{ asset('assets/frontend/images/app-store.png') }}"></a></div>
                </div>
            </div>
        </div>
        <div class="row py-5">
            <div class="copyright col"><h5>&copy 2024 Medicine Plus. All Rights Reserved.</h5></div>
            <div class="social col-4">
                <ul class="social-list list-unstyled d-flex justify-content-around">
                    <li class="social-item"><a href="#"><img src="{{ asset('assets/frontend/images/fb.png') }}"></a></li>
                    <li class="social-item"><a href="#"><img src="{{ asset('assets/frontend/images/tw.png') }}" alt=""></a></li>
                    <li class="social-item"><a href="#"><img src="{{ asset('assets/frontend/images/in.png') }}" alt=""></a></li>
                    <li class="social-item"><a href="#"><img src="{{ asset('assets/frontend/images/yt.png') }}" alt=""></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
