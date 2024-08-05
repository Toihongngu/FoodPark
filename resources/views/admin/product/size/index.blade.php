@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Sizes</h1>
        </div>

        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-3">Go Back</a>
        </div>
        <div class="row">
            {{-- size --}}
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Size</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.product-size.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" id="" class="form-control">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>List All Size By Product ( {{ $product->name }} ) </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td> {{currencyPosition($item->price)}}</td>
                                        <td>
                                            <div>
                                                <button type="submit" class="btn btn-danger ml-2"
                                                    onclick="confirmDelete({{ $item->id }})"><i class="fas fa-trash"
                                                        style="color: #ffffff;"></i></button>
                                                <form id="delete-form-{{ $item->id }}" style="display: none;"
                                                    action="{{ route('admin.product-size.destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($sizes) === 0)
                                    <tr>
                                        <td colspan="4" class="text-center">No Have Data!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            {{-- option --}}
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Option ( Select additional products )</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.product-option.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" id="" class="form-control">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>List All Option By Product {{ $product->name }} ( Select additional products )</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td> {{currencyPosition($item->price)}}</td>
                                        <td>
                                            <div>
                                                <button type="submit" class="btn btn-danger ml-2"
                                                    onclick="confirmDelete({{ $item->id }})"><i class="fas fa-trash"
                                                        style="color: #ffffff;"></i></button>
                                                <form id="delete-form-{{ $item->id }}" style="display: none;"
                                                    action="{{ route('admin.product-option.destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($options) === 0)
                                    <tr>
                                        <td colspan="4" class="text-center">No Have Data!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi form xóa
                    document.getElementById('delete-form-' + id).submit();

                    // Hiển thị thông báo thành công sau khi xóa
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                }
            });
        }
    </script>
    <style>
        .table .col-auto {
            width: 10%;
            /* Thay đổi giá trị này theo nhu cầu */
        }
    </style>
@endpush
