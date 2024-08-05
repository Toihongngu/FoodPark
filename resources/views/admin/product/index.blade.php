@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>List All Products</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                <nav class="navbar navbar-light">
                    <div class="section-title mt-0">
                    </div>
                    <form class="form-inline" action="{{ route('admin.product.index') }}" method="GET">
                        @csrf
                        <input class="form-control bg-light text-dark mr-sm-2" type="search" name="search"
                            placeholder="Search" aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-outline-success border border-light my-2 my-sm-0"
                            type="submit">Search</button>
                    </form>
                </nav>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Offer Price</th>
                            <th scope="col">Show At Home</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td><img src="{{ asset('storage/' . $product->thumb_image) }}" alt=""
                                        width="100px">
                                </td>
                                <td>{{ $product->name }}</td>
                                @foreach ($categories as $item)
                                    @if ($item->id == $product->category_id)
                                        <td>{{ $item->name }}</td>
                                    @endif
                                @endforeach
                                <td> {{currencyPosition($product->price)}}</td>
                                <td> {{currencyPosition($product->offer_price)}}</td>
                                <td>
                                    @if ($product->show_at_home === 1)
                                        <span class="badge badge-success">Yes</span>
                                    @endif
                                    @if ($product->show_at_home === 0)
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->status === 1)
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                    @if ($product->status === 0)
                                        <span class="badge badge-warning">InActive</span>
                                    @endif
                                </td>
                                <td scope="row" class="col-auto">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('admin.product.edit', $product->id) }}"
                                                class="btn btn-warning"><i class="fas fa-edit"
                                                    style="color: #ffffff;"></i></a>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-danger ml-2"
                                                onclick="confirmDelete({{ $product->id }})"><i class="fas fa-trash"
                                                    style="color: #ffffff;"></i></button>
                                            <form id="delete-form-{{ $product->id }}" style="display: none;"
                                                action="{{ route('admin.product.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                            </form>
                                        </div>
                                        <div class="btn-group dropleft ml-2">
                                            <button type="button" class="btn btn-dark dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropleft">
                                                <a class="dropdown-item" href="{{route('admin.product-gallery.show-index',$product->id)}}">Product Gallery</a>
                                                <a class="dropdown-item" href="{{route('admin.product-size.show-index',$product->id)}}">Product Size</a>
                                            {{--     <a class="dropdown-item" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Separated link</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>

                <div class="pagination-custom">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">«</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                            @endif

                            @foreach ($products->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">»</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
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
