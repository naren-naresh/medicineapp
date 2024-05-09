<!-- modal for addresses -->
<div class="modal" tabindex="-1" id="addressModal" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" aria-label="Close"
                style="position: absolute; top: 10px; right: 10px; z-index: 999;" data-bs-dismiss="modal"></button>
            <div class="modal-body p-5">
                <div class="modal-heading  text-center pb-3">
                    <h5 class="modal-title" id="modelHeading">Addresses</h5>
                </div>
                <ul class="address-list list-unstyled">
                    @foreach ($addresses as $address)
                        <div class="list-con">
                            <li class="border p-3 my-2 address-item" addressId={{ $address->id }}>
                                <p><i class="fa fa-house-chimney"></i>&nbsp;Home</p>
                                <p>
                                    <span><i class="fa fa-user"></i>&nbsp; {{ $address->name }}</span>
                                    <span class="ps-5"><i
                                            class="fa fa-phone"></i>&nbsp;{{ $address->contact_number }}</span>
                                </p>
                                <p><i class="fa fa-map-location"></i>
                                    &nbsp;{{ $address->address }}({{ $address->postal_code }})</p>
                            </li>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<style>
    .address-item i {
        color: #385399;
    }
    .address-item{
        cursor: pointer;
    }
</style>
