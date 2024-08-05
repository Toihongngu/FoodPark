@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Why Choose Us</h1>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <div id="accordion">
                        <div class="accordion">
                            <div class="accordion-header collapsed bg-primary text-light p-2" role="button"
                                data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                                <h4>Section Title ( why choose ... )</h4>
                            </div>
                            <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                                <form action="{{ route('admin.why-choose-title.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Top Title</label>
                                        <input type="text" class="form-control" name="why_choose_top_title"
                                            value="{{ @$titles['why_choose_top_title'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Main Title</label>
                                        <input type="text" class="form-control" name="why_choose_main_title"
                                            value="{{ @$titles['why_choose_main_title'] }}">
                                    </div>
                                    <div class="form-group ">
                                        <label>Sub Title</label>
                                        <input type="text" class="form-control" name="why_choose_sub_title"
                                            value="{{ @$titles['why_choose_sub_title'] }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-1">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>List All Items</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.why-choose-us.create') }}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                <nav class="navbar navbar-light">
                    <div class="section-title mt-0">
                    </div>
                    <form class="form-inline" action="{{ route('admin.why-choose-us.index') }}" method="GET">
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
                            <th scope="col">Icon</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whyChooseUss as $index => $whyChooseUs)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $whyChooseUs->title }}</td>
                                <td><i style="font-size: 35px" class="{{ $whyChooseUs->icon }} "></i></td>
                                <td>{{ $whyChooseUs->short_description }}</td>
                                <td>
                                    @if ($whyChooseUs->status === 1)
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                    @if ($whyChooseUs->status === 0)
                                        <span class="badge badge-warning">InActive</span>
                                    @endif
                                </td>
                                <td scope="row">
                                    <div class="d-flex justify-content-between">
                                        <div> <a href="{{ route('admin.why-choose-us.edit', $whyChooseUs->id) }}"
                                                class="btn btn-warning"><i class="fas fa-edit"
                                                    style="color: #ffffff;"></i></a></div>
                                        <div>
                                            <button type="submit" class="btn btn-danger ml-2"
                                                onclick="confirmDelete({{ $whyChooseUs->id }})"><i class="fas fa-trash"
                                                    style="color: #ffffff;"></i></button>
                                            <form id="delete-form-{{ $whyChooseUs->id }}" style="display: none;"
                                                action="{{ route('admin.why-choose-us.destroy', $whyChooseUs->id) }}"
                                                method="post">
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
                            @if ($whyChooseUss->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">«</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $whyChooseUs->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                            @endif

                            @foreach ($whyChooseUss->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $whyChooseUss->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($whyChooseUss->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $whyChooseUss->nextPageUrl() }}" aria-label="Next">
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
