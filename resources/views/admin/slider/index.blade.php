@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>List All Items</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                <nav class="navbar navbar-light">
                    <div class="section-title mt-0">
                    </div>
                    <form class="form-inline" action="{{ route('admin.slider.index') }}" method="GET">
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
                            <th scope="col">Title</th>
                            <th scope="col">Image</th>
                            <th scope="col">Offer</th>
                            <th scope="col">Sub Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Button Link</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $index => $slider)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $slider->title }}</td>
                                <td><img src="{{ asset('storage/' . $slider->image) }}" alt="" width="100px"></td>
                                <td>{{ $slider->offer }}</td>
                                <td>{{ $slider->sub_title }}</td>
                                <td>{{ $slider->short_description }}</td>
                                <td>{{ $slider->button_link }}</td>
                                <td>
                                    @if ($slider->status === 1)
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                    @if ($slider->status === 0)
                                        <span class="badge badge-warning">InActive</span>
                                    @endif
                                </td>
                                <td scope="row">
                                    <div class="d-flex justify-content-between">
                                        <div> <a href="{{ route('admin.slider.edit', $slider->id) }}"
                                                class="btn btn-warning"><i class="fas fa-edit"
                                                    style="color: #ffffff;"></i></a></div>
                                        <div>
                                            <button type="submit" class="btn btn-danger ml-2"
                                                onclick="confirmDelete({{ $slider->id }})"><i class="fas fa-trash"
                                                    style="color: #ffffff;"></i></button>
                                            <form id="delete-form-{{ $slider->id }}" style="display: none;"
                                                action="{{ route('admin.slider.destroy', $slider->id) }}" method="post">
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
                            @if ($sliders->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">«</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $sliders->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                            @endif

                            @foreach ($sliders->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $sliders->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($sliders->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $sliders->nextPageUrl() }}" aria-label="Next">
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
@endpush
