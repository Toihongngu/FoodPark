@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Categories</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>List All Categories</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                <nav class="navbar navbar-light">
                    <div class="section-title mt-0">
                    </div>
                    <form class="form-inline" action="{{ route('admin.category.index') }}" method="GET">
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
                            <th scope="col">Name</th>
                            <th scope="col">Show At Home</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if ($category->show_at_home === 1)
                                        <span class="badge badge-success">Yes</span>
                                    @endif
                                    @if ($category->show_at_home === 0)
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($category->status === 1)
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                    @if ($category->status === 0)
                                        <span class="badge badge-warning">InActive</span>
                                    @endif
                                </td>
                                <td scope="row" class="col-auto">
                                    <div class="d-flex justify-content-between">
                                        <div> <a href="{{ route('admin.category.edit', $category->id) }}"
                                                class="btn btn-warning"><i class="fas fa-edit"
                                                    style="color: #ffffff;"></i></a></div>
                                        <div>
                                            <button type="submit" class="btn btn-danger ml-2"
                                                onclick="confirmDelete({{ $category->id }})"><i class="fas fa-trash"
                                                    style="color: #ffffff;"></i></button>
                                            <form id="delete-form-{{ $category->id }}" style="display: none;"
                                                action="{{ route('admin.category.destroy', $category->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                            </form>
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
                            @if ($categories->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">«</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categories->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                            @endif

                            @foreach ($categories->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $categories->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($categories->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categories->nextPageUrl() }}" aria-label="Next">
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
            width: 10%; /* Thay đổi giá trị này theo nhu cầu */
        }
    </style>
@endpush
