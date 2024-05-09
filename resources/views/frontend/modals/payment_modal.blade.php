<!-- modal for addresses -->
<div class="modal" tabindex="-1" id="paymentModal" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" aria-label="Close"
                style="position: absolute; top: 10px; right: 10px; z-index: 999;" data-bs-dismiss="modal"></button>
            <div class="modal-body py-3 px-1">
                <div class="modal-heading  text-center pb-3">
                    {{-- <h5 class="modal-title" id="modelHeading">Payment Details</h5> --}}
                </div>
                <div class="container">
                    <p class="payment-heading">Choose Payment Method</p>
                    <div class="row payment-method justify-content-center px-5">
                        <div class="form-group col-6">
                            <label for="card" class="px-3 py-2 w-100 text-center">Credit / Debit Card</label>
                            <input type="radio" name="pay-method" id="card" class="d-none">
                        </div>
                        <div class="form-group col-6">
                            <label for="pay-on-delivery" class="p-3 py-2 w-100 text-center">Pay On Delivery</label>
                            <input type="radio" name="pay-method" id="pay-on-delivery" class="d-none">
                        </div>
                    </div>
                    <div class="card-form px-5 py-3 justify-content-center d-none">
                        <form action="" method="post" name="cardDetailsForm" id="cardDetailsForm">

                                <div class="form-group">
                                    <label for="name" class="pb-2">CARDHOLDER NAME</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            <div class="row py-2">
                                <div class="form-group col-3">
                                    <label for="expires" class="pb-2">EXPIRES</label>
                                    <input type="text" name="expires" id="expires" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="form-group col-3">
                                    <label for="cvc" class="pb-2">CVC</label>
                                    <input type="text" name="cvc" id="cvc" class="form-control" placeholder="CVC">
                                </div>
                                <div class="form-group col">
                                    <label for="cardNumber" class="pb-2">CARD NUMBER</label>
                                    <input type="text" name="cardNumber" id="cardNumber" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="pay-on-content d-none px-5 pt-3">
                       <p> You selected Pay on Delivery! Pay at your door with Cash/digital options when your order arrives on within three days(approx).
                         Be ready to receive it!</p>
                    </div>
                    <div class="row justify-content-end py-3 px-5 pay-btn-block d-none">
                        <div class="payable">
                            <p>Payable Amount:&nbsp;₹ {{ $totalPaid }}</p>
                        </div>
                        <button type="submit" class="placeOrder-btn py-1 me-3 col-3">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .payment-heading {
        font-size: 18px;
        font-weight: 500;
        text-align: center;
    }

    .payment-method label {
        border: 1px solid #385399;
        color: #385399;
        background-color: #fff;
        cursor: pointer;
    }

    .payment-method label:hover {
        color: #fff;
        background-color: #385399;
    }

    #cardDetailsForm .form-control:focus {
        border: 1px solid #385399 !important;
    }

    .placeOrder-btn,
    .pay-on-btn {
        color: #fff;
        background-color: #385399;
        border: 1px solid #385399
    }
    .payable p{
        font-size: 16px;
        font-weight: 500;
    }
    .pay-on-content p{
        line-height: 1.7;
        color: #7a7979;
    }
</style>
