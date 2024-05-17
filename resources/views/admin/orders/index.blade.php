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
    <nav class="w-100">
        <div class="status-nav nav nav-tabs d-flex justify-content-between" role="tablist">
            <button type="button" class="nav-btn nav-link active me-1" id="placed" status ='placed' data-bs-toggle="tab" role="tab" aria-selected="true">Placed</button>
            <button type="button" class="nav-btn nav-link me-1" id="processing" status ='processing' data-bs-toggle="tab" role="tab" aria-selected="false">Processing</button>
            <button type="button" class="nav-btn nav-link me-1" id="completed" status ='completed' data-bs-toggle="tab" role="tab" aria-selected="false">Completed</button>
            <button type="button" class="nav-btn nav-link" id="canceled" status ='canceled' data-bs-toggle="tab" role="tab" aria-selected="false">Canceled</button>
        </div>
    </nav>
    <div class="card w-100  mb-5 tab-content" style="border: unset">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Orders</h5>
            <div class="card-tools">
                <div id="daterange" class="float-end"
                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span>
                    <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
        <div class="card-body tab-pane fade show active" role="tabpanel" >
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" id=""></th>
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
    </div>
    <style>
        .nav-btn {
            background-color: #385399 !important;
            color: #fff !important;
            border: 1px solid #385399 !important;
            border-radius: unset !important;
            width: 24.7%;
        }
        .nav-btn.active{
            background-color: #fff !important;
            color: #385399 !important;
            cursor: pointer !important;
            border-bottom-color: #fff !important;
        }
        .nav-btn:hover {
            background-color: #fff !important;
            color: #385399 !important;
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
            $('#daterange').daterangepicker({
            }, function(start, end) {
                $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
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
    </script>
@endPushOnce
