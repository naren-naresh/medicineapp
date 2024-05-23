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
                <select name="status_menu" id="status_menu" class="form-control">
                    @foreach ($orderStatus as $item)
                    <option selected>--- Select Status ---</option>
                    <option value="{{$item->id}}">{{$item->status}}</option>
                    @endforeach
                </select>
                <button type="button" class="btn py-1" id="whole-shipment-btn">Apply</button>
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
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @include('admin.orders.shippment-modal')
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

        .nav-btn:hover {
            background-color: #385399 !important;
            color: #fff !important;
            cursor: pointer !important;
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
                typeValue = $(this).attr('status');
                var ajaxParams = table.ajax.params();
                ajaxParams.typeValue = typeValue;
                table.draw();
            });

            /* datatables*/
            var table = $('.data-table').DataTable({
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
                ]
            });
        });

        // mark as confirmed functionality
        $(document).on('click', '.confirm', function() {
            var status = $(this).attr('order_status');
            var orderId = $(this).attr('order_id');
            if (status == 2) {
                $.ajax({
                    type: "post",
                    url: "{{ route('order.confirmOrder') }}",
                    data: {
                        order_id: orderId,
                        order_status: status,
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            } else if (status < 2) {
                Swal.fire("View the orders detail first.");
            }
        });

        // select all functionality
        $('#select-all').change(function(params) {
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
                    if (order_statusId == id) {
                        checkedValues.push(order_id);
                    }else{
                        $(this).prop('checked', false);
                    }
                }
            });
            return checkedValues;
        }

        // bulk shipment
        $('#whole-shipment-btn').click(function () {
            var selectedValue = $("#status_menu").val() - 1 ;
            var checkedOrders = getCheckedAttributes(selectedValue);
               if (checkedOrders.length > 0) {
                $.ajax({
                    type: "post",
                    url: "{{ route('orders.shipment') }}",
                    data:{
                        order_id: checkedOrders,
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.data == true) {
                            location.reload();
                       }
                    }
                });
               }else{
                Swal.fire("Kindly select atleast one row.");
               }
        });

        //single shipment
        $(document).on('click','.shipped', function () {
            let order_id = [];
                order_id.push($(this).attr('order_id'));
            $('#staticBackdrop').modal('show');
            $('#confirm-shipment-btn').click(function () {
                 $.ajax({
                    type: "post",
                    url: "{{ route('orders.shipment') }}",
                    data:{
                        order_id : order_id,
                    },
                    success: function (response) {
                       if (response.data == true) {
                            location.reload ();
                       }
                    }
                 });
            });
        });

         $(document).ready(function () {
            let selectMenu = $("select#status_menu");
            selectMenu.find("option").hide();
            selectMenu.find("option[value='" + 4 + "']").show();
         });

        $(document).on('click','.nav-btn', function () {
            let statusValue = $(this).attr('selectValue');
            let selectMenu = $("select#status_menu");
            selectMenu.find("option").hide();
            selectMenu.find("option[value='" + statusValue + "']").show();
        });
    </script>
@endPushOnce
