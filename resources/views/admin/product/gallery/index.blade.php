@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Gallery</h1>
        </div>

        <div>
            <a href="{{route('admin.product.index')}}" class="btn btn-primary my-3">Go Back</a>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Insert Image By Product ( {{ $product->name }} )</h4>
            </div>
            <div class="card-body">
                <div class="col-md-8">
                    <form action="{{ route('admin.product-gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="image" id="" class="form-control">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>List All Image By Product ( {{ $product->name }} ) </h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $item)
                            <tr>
                                <td><img src="{{ asset('storage/' . $item->image) }}" alt="" width="100px"></td>
                                <td>
                                    <div>
                                        <button type="submit" class="btn btn-danger ml-2"
                                            onclick="confirmDelete({{ $item->id }})"><i class="fas fa-trash"
                                                style="color: #ffffff;"></i></button>
                                        <form id="delete-form-{{ $item->id }}" style="display: none;"
                                            action="{{ route('admin.product-gallery.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if (count($images) === 0)
                            <tr>
                                <td colspan="2" class="text-center">No Have Data!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
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
