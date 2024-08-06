@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>User</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>List All User</h4>
            </div>
            <div class="card-body">
                <nav class="navbar navbar-light">
                    <div class="section-title mt-0">
                    </div>
                    <form class="form-inline" action="{{ route('admin.user.index') }}" method="GET">
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
                            <th scope="col">Avatar</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td><img src="{{ asset('storage/' . $user->avatar) }}" alt="" width="100px"> </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="btn-group mb-2">
                                        <button @disabled(Auth::id() == $user->id)  class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @if ($user->role === 'admin')
                                                Admin
                                            @endif
                                            @if ($user->role === 'user')
                                                User
                                            @endif
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.user.update-role', $user->id) }}">Admin</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.user.update-role', $user->id) }}">User </a>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div class="btn-group mb-2">
                                        @if ($user->status === 1)
                                            <button @disabled(Auth::id() == $user->id)  class="btn btn-success btn-sm dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Active
                                            </button>
                                        @endif
                                        @if ($user->status === 0)
                                            <button @disabled(Auth::id() == $user->id)  class="btn btn-warning btn-sm dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                InActive
                                            </button>
                                        @endif
                                        <div class="dropdown-menu" >
                                            <a class="dropdown-item"
                                                href="{{ route('admin.user.update-status', $user->id) }}">Active</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.user.update-status', $user->id) }}">Inctive </a>
                                        </div>
                                    </div>





                                </td>
                                <td scope="row" class="col-auto">
                                    <div>
                                        <button type="submit" @disabled(Auth::id() == $user->id) class="btn btn-danger ml-2"
                                            onclick="confirmDelete({{ $user->id }})"><i class="fas fa-trash"
                                                style="color: #ffffff;"></i></button>
                                        <form id="delete-form-{{ $user->id }}" style="display: none;"
                                            action="{{ route('admin.user.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>

                <div class="pagination-custom">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">«</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                            @endif

                            @foreach ($users->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $users->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
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
