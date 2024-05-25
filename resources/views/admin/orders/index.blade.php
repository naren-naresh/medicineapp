@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <h5>All Orders</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </div>
    </div>
    <nav class="w-100 mb-4">
        <div class="status-nav nav nav-tabs d-flex justify-content-between" role="tablist">
            <button type="button" class="nav-btn nav-link active" id="placed" status ='placed' selectValue = '4' data-bs-toggle="tab"
                role="tab" aria-selected="true">Placed Orders</button>
            <button type="button" class="nav-btn nav-link" id="processing" status ='shipped' selectValue = '6' data-bs-toggle="tab"
                role="tab" aria-selected="false">Shipped Orders</button>
            <button type="button" class="nav-btn nav-link" id="completed" status ='completed' selectValue = '7' data-bs-toggle="tab"
                role="tab" aria-selected="false">Completed Orders</button>
            <button type="button" class="nav-btn nav-link" id="canceled" status ='canceled' data-bs-toggle="tab"
                role="tab" aria-selected="false">Cancelled Orders</button>
        </div>
    </nav>
    <div class="card w-100  mb-5 tab-content">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center">
                <select name="status_menu" id="status_menu" class="form-control" style="border-radius:unset !important">
                    <option value='action' selected disabled> Action </option>
                    @foreach ($orderStatus as $item)
                    <option value="{{$item->id}}">{{$item->status}}</option>
                    @endforeach
                </select>
                <button type="button" class="btn py-1" id="whole-shipment-btn" style="border-radius:unset !important; padding:4.3px 7px !important;font-size:13px;">Apply</button>
            </div>
            <div class="card-tools">
                <div id="daterange" class="float-end text-secondary"
                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span>
                    <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
        <div class="card-body tab-pane fade show active" role="tabpanel">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="select-all" id="select-all"></th>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Send To</th>
                        <th>Status</th>
                        <th style="width: 170px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @include('admin.orders.shippment-modal')
        @include('admin.orders.out-for-delivery-modal')
    </div>
    <style>
        .nav-btn {
            background-color: #fff !important;
            color: #385399 !important;
            border: 1px solid #385399 !important;
            border-radius: unset !important;
            width: 25%;
            position: relative;
            z-index: 10;
        }

        .nav-btn.active {
            background-color: #385399 !important;
            color: #fff !important;
            cursor: pointer !important;
        }

        .nav-btn.active:after {
            content: '\f0dd';
            font-family: 'FontAwesome';
            font-size: 32px;
            position: absolute;
            bottom: 0;
            right: 50%;
            color: #385399;
            transform: translate(50%, 42%);
            z-index: 1;
        }
    </style>
@endsection
@pushOnce('scripts')
    <script>
        /* csrf token*/
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
        var typeValue;
        var table;
        $(function() {
            $('#daterange span').html('D-MM-YYYY' + ' to ' + 'D-MM-YYYY');
            $('#daterange').daterangepicker({}, function(start, end) {
                $('#daterange span').html(start.format('D-MM-YYYY') + ' to ' + end.format('D-MM-YYYY'));
                table.draw();
            });
            $(document).on('click', '.daterangepicker .cancelBtn', function(e) {
                e.preventDefault();
                $('#daterange span').html('D-MM-YYYY' + ' to ' + 'D-MM-YYYY');
                table.ajax.reload();
            });
            $('.nav-btn').click(function() {
                $('#status_menu').prop('selectedIndex',0);
                typeValue = $(this).attr('status');
                var ajaxParams = table.ajax.params();
                ajaxParams.typeValue = typeValue;
                table.draw();
            });

            /* datatables */
           table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                rowReorder: true,
                // columnDefs: [
                //     { orderable: true, className: 'reorder', targets: [1,2,3,4] },
                //     { orderable: false, targets: '_all' }
                // ],
                'aaSorting': [
                    [1, 'asc']
                ],
                language: {
                    lengthMenu: 'Show _MENU_ entries',
                },
                ajax: {
                    url: "{{ route('orders.adminIndex') }}",
                    data: function(data) {
                        var start = $('#daterange').data('daterangepicker').startDate.format(
                            'YYYY-MM-DD');
                        var end = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                        data.typeValue = typeValue;
                        if (start && end) {
                            data.start = start;
                            data.end = end;
                        }
                        return data;
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                    },
                    {
                        data: 'order_date',
                        name: 'order_date',
                    },
                    {
                        data: 'items',
                        name: 'items',
                    },
                    {
                        data: 'price',
                        name: 'price',
                    },
                    {
                        data: 'address',
                        name: 'address',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                drawCallback: function(settings) {
                    $('.data-table thead input[type="checkbox"]').prop('checked', false);
                }
            });
        });

        // mark as confirmed functionality
        $(document).on('click', '.confirm', function() {
            var status = $(this).attr('order_status');
            var orderId = $(this).attr('order_id');
            Swal.fire({
                title: "Are you sure?",
                text: "Confirm this order.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#385399",
                cancelButtonColor: "#202020",
                confirmButtonText: "Yes, confirm it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    if (status == 2) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('order.confirmOrder') }}",
                            data: {
                                order_id: orderId,
                                order_status: status,
                            },
                            success: function(response) {
                                if (response.data == true) {
                                    table.ajax.reload(null, false);
                            }
                            }
                        });
                    } else if (status < 2) {
                        Swal.fire("View the orders detail first.");
                    }

                    Swal.fire({
                    title: "Confirmed!",
                    text: "Order confirmed.",
                    icon: "success",
                    confirmButtonColor: "#385399"
                    });
                }
            });
        });

        // select all functionality
        $('#select-all').change(function() {
            if ($(this).is(':checked')) {
                $('.check').prop('checked', true);
            } else {
                $('.check').prop('checked', false);
            }
        });

        // get all checkout row order_id
        function getCheckedAttributes(id) {
            var checkedValues = [];
            $('.check').each(function() {
                if ($(this).is(":checked")) {
                    order_id = $(this).attr("orderid");
                    let order_statusId = $(this).attr('statusid');
                    if (order_statusId == id || order_statusId == id-1 ) {
                        checkedValues.push(order_id);
                    }else{
                        $(this).prop('checked', false);
                    }
                }
            });
            return checkedValues;
        }

        // bulk status change functionality
        $('#whole-shipment-btn').click(function () {
            var selectedValue = $("#status_menu").val() - 1 ;
            var updateValue = $("#status_menu").val();
            var checkedOrders = getCheckedAttributes(selectedValue);
            if (checkedOrders.length > 0) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Confirm this action.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#385399",
                    cancelButtonColor: "#202020",
                    confirmButtonText: "Yes, confirm it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                url: "{{ route('orders.shipment') }}",
                                data:{
                                    order_id: checkedOrders,
                                    update_value : updateValue,
                                },
                                success: function (response) {
                                    console.log(response);
                                    if (response.data == true) {
                                        table.ajax.reload(null, false);
                                }
                                }
                            });
                        Swal.fire({
                        title: "Completed!",
                        icon: "success",
                        confirmButtonColor: "#385399"
                        });
                    }else{
                        table.ajax.reload(null, false);
                        $('#status_menu').prop('selectedIndex',0);
                    }
                });
            }else{
                Swal.fire({
                    text:"Kindly select atleast one row and action.",
                    icon: "warning",
                    confirmButtonColor: "#385399"
                });
            }
        });

        //single shipment
        $(document).on('click','.shipped', function () {
            let order_id = [];
                order_id.push($(this).attr('order_id'));
            let updateValue = parseInt($(this).attr('order_status')) + 1;
                Swal.fire({
                    title: "Are you sure?",
                    text: "Move the order to shipment.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#385399",
                    cancelButtonColor: "#202020",
                    confirmButtonText: "Yes, move it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('orders.shipment') }}",
                            data:{
                                order_id : order_id,
                                update_value : updateValue,
                            },
                            success: function (response) {
                            if (response.data == true) {
                                table.ajax.reload(null, false);
                            }
                            }
                        });
                        Swal.fire({
                        title: "Shipped!",
                        text: "Order is shipped.",
                        icon: "success",
                        confirmButtonColor: "#385399"
                        });
                    }
                });


        });

        // single out for delivery
        $(document).on('click','.delivered', function () {
            let order_id = [];
                order_id.push($(this).attr('order_id'));
            let updateValue = parseInt($(this).attr('order_status')) + 1;
                Swal.fire({
                    title: "Are you sure?",
                    text: "To deliver this order.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#385399",
                    cancelButtonColor: "#202020",
                    confirmButtonText: "Yes, deliver it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('orders.shipment') }}",
                            data:{
                                order_id : order_id,
                                update_value : updateValue,
                            },
                            success: function (response) {
                            if (response.data == true) {
                                table.ajax.reload(null, false);
                                $('#outForDeliveryModal').modal('hide');
                            }
                            }
                        });
                        Swal.fire({
                        title: "Delivered!",
                        text: "Order has been Delivered.",
                        icon: "success",
                        confirmButtonColor: "#385399"
                        });
                    }
                });
        });

         $(document).ready(function () {
            let selectMenu = $("select#status_menu");
            selectMenu.find("option").hide();
            selectMenu.find("option[value='" + 3 + "']").show();
            selectMenu.find("option[value='" + 4 + "']").show();
         });

        $(document).on('click','.nav-btn', function () {
            let statusValue = $(this).attr('selectValue');
            let beforeStatus = statusValue - 1 ;
            let selectMenu = $("select#status_menu");
            selectMenu.find("option").hide();
            if (statusValue <= 6 ) {
                selectMenu.find("option[value='" + beforeStatus + "']").show();
            }
            selectMenu.find("option[value='" + statusValue + "']").show();
        });

        // change checked row based on status select-menu
        $('#status_menu').change(function () {
            var id = $(this).val();
            $('.check').each(function() {
                if ($(this).is(":checked")) {
                    order_id = $(this).attr("orderid");
                    let order_statusId = $(this).attr('statusid');
                    if (order_statusId ==id-1 ) {
                        $(this).prop('checked', true);
                    }else{
                        $(this).prop('checked', false);
                    }
                }
            });

        });
    </script>
@endPushOnce
