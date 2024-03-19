@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <h5>Products</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-2 mb-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Products</h5>
            <div class="card-tools">
                <a href="{{ route('product.add')}}" class="btn">Add</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Stock In Hands</th>
                        <th>Status</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @pushOnce('scripts')
     <script>
        /* datatables*/
        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.index') }}",
        columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
        },
        {
            data: 'cover_image',
            name: 'cover_image',
        },
        {
        data: 'name',
        name: 'name',
        },
        {
        data: 'category_id',
        name: 'category_id',
        },
        {
        data: 'stock',
        name: 'stock',
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
      </script>

    @endPushOnce
@endsection
