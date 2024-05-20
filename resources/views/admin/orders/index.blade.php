@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <h5>Orders</h5>
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
            <button type="button" class="nav-btn nav-link active" id="placed" status ='placed' data-bs-toggle="tab"
                role="tab" aria-selected="true">Placed Orders</button>
            <button type="button" class="nav-btn nav-link" id="processing" status ='shipped' data-bs-toggle="tab"
                role="tab" aria-selected="false">Shipped Orders</button>
            <button type="button" class="nav-btn nav-link" id="completed" status ='completed' data-bs-toggle="tab"
                role="tab" aria-selected="false">Completed Orders</button>
            <button type="button" class="nav-btn nav-link" id="canceled" status ='canceled' data-bs-toggle="tab"
                role="tab" aria-selected="false">Cancelled Orders</button>
        </div>
    </nav>
    <div class="card w-100  mb-5 tab-content">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Orders</h5>
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
                $('#daterange span').html('');
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
                language: {
                    lengthMenu: 'Show _MENU_ entries',
                },
                ajax: {
                    url: "{{ route('orders.adminIndex') }}",
                    data: function(data) {
                        var start = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
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
                    },
                    {
                        data: 'status',
                        name: 'status',
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
        $('#select-all').change(function(params) {
            if ($(this).is(':checked')) {
                $('.check').attr('checked', 'checked');
            }
        });
        $(document).ready(function() {
            $('.confirm').each(function() {
                $(this).children('i').removeClass('far');
            });
        });
    </script>
@endPushOnce
