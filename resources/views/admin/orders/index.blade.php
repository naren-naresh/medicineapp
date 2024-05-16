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
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </div>
    </div>
    <div class="status-nav row justify-content-between w-100 my-3">
        <div class="nav-btn col-2 p-2 text-center" id="placed" type ='placed'>Placed</div>
        <div class="nav-btn col-2 p-2 text-center" id="processing" type ='processing'>Processing</div>
        <div class="nav-btn col-2 p-2 text-center" id="completed" type ='completed'>Completed</div>
        <div class="nav-btn col-2 p-2 text-center" id="canceled" type ='canceled'>Canceled</div>
    </div>
    <div class="card w-100 mt-2 mb-5">
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
        <div class="card-body">
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
        .nav-btn{
            background-color: #385399;
            color: #fff;
            border: 1px solid #385399;
        }
        .nav-btn:hover{
          background-color: #fff;
          color: #385399;
          cursor: pointer;
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

            var start_date = moment().subtract(1, 'M');

            var end_date = moment();

            $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

            $('#daterange').daterangepicker({
                startDate: start_date,
                endDate: end_date
            }, function(start_date, end_date) {
                $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format(
                    'MMMM D, YYYY'));

                table.draw();
            });
            $('.nav-btn').click(function() {
                typeValue = $(this).attr('type');
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
                        data.from_date = $('#daterange').data('daterangepicker').startDate.format(
                            'YYYY-MM-DD');
                        data.to_date = $('#daterange').data('daterangepicker').endDate.format(
                            'YYYY-MM-DD');
                        data.typeValue = typeValue;

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
