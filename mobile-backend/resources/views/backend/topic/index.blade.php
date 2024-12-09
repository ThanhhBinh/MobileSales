@extends('layouts.admin')
@section('title', 'Bài viết')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 pl-3">Bài viết</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn btn-success" href="{{ route('admin.topic.create') }}">
                                        <i class="fas fa-plus"></i> Thêm mới
                                    </a>
                                    <a class="btn btn-danger" href="{{ route('admin.topic.trash') }}">
                                        <i class="fas fa-trash-alt"></i> Thùng rác
                                    </a>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- Search --}}

                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                                                <div class="card-header with-border clearfix">

                                                    <div class="card-title">
                                                        <i class="fas fa-search"></i>
                                                        Tìm kiếm
                                                    </div>
                                                    <div class="card-tools float-right">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse">
                                                            <i class="fa toggle-icon fa-minus"></i> </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="display: block;">
                                                    <div class="row">
                                                        <div class="card-body">
                                                            <form method="GET" action="{{ route('admin.topic.index') }}"
                                                                class="form-horizontal">


                                                                <!-- Body của form tìm kiếm -->
                                                                <div class="search-body">
                                                                    <div class="row px-5 mt-3">
                                                                        <!-- Trường tìm kiếm theo tên chủ đề -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label
                                                                                    class="col-md-4 col-form-label text-right"
                                                                                    for="name">Tên chủ đề:</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="text"
                                                                                        class="form-control" id="name"
                                                                                        name="name"
                                                                                        placeholder="Tên chủ đề"
                                                                                        value="{{ request('name') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Trường lọc theo trạng thái -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label
                                                                                    class="col-md-4 col-form-label text-right"
                                                                                    for="status">Trạng thái:</label>
                                                                                <div class="col-md-8">
                                                                                    <select name="status" id="status"
                                                                                        class="form-control">
                                                                                        <option value="">Tất cả
                                                                                        </option>
                                                                                        <option value="1"
                                                                                            {{ request('status') == '1' ? 'selected' : '' }}>
                                                                                            Xuất
                                                                                            bản
                                                                                        </option>
                                                                                        <option value="2"
                                                                                            {{ request('status') == '2' ? 'selected' : '' }}>
                                                                                            Chưa
                                                                                            xuất bản</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Nút tìm kiếm -->
                                                                <div class="row mt-3">
                                                                    <div class="col-12 text-center">
                                                                        <button type="submit"
                                                                            class="btn p-2 btn-primary btn-search">
                                                                            <i class="fas fa-search"></i> Tìm kiếm
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card">
                                        <div class="card-body">

                                            {{-- Thông báo thành công --}}
                                            @if (session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endif

                                            {{-- Thông báo thất bại --}}
                                            @if (session('error'))
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    {{ session('error') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endif

                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if ($topic->isEmpty())
                                                        <div class="alert alert-info">
                                                            Không có chủ đề nào để hiển thị.
                                                        </div>
                                                    @else
                                                        <div class="mb-3">

                                                            <form action="{{ route('admin.topic.delete_multiple') }}"
                                                                method="POST" id="delete-form">
                                                                @csrf
                                                                <button type="submit" class="btn  btn-danger"
                                                                    id="delete-selected">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                    Xóa đã chọn
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <table class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" style="width:30px">
                                                                        <input type="checkbox" id="select-all">
                                                                    </th>
                                                                    <th>Tên chủ đề</th>
                                                                    <th>Slug</th>
                                                                    <th class="text-center" style="width:150px">Thứ tự
                                                                        hiển
                                                                        thị</th>
                                                                    <th class="text-center" style="width:200px">Chức năng
                                                                    </th>
                                                                    <th class="text-center" style="width:30px">ID</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($topic as $row)
                                                                    <tr>
                                                                        @php
                                                                            $args = ['id' => $row->id];
                                                                        @endphp
                                                                        <td class="text-center">
                                                                            <input type="checkbox"
                                                                                class="product-checkbox"
                                                                                value="{{ $row->id }}"
                                                                                name="checkId[]">
                                                                        </td>
                                                                        <td>{{ $row->name }}</td>
                                                                        <td>{!! $row->slug !!}</td>
                                                                        <td>{!! $row->sort_order !!}</td>
                                                                        <td class="text-center">
                                                                            @if ($row->status == 1)
                                                                                <a href="{{ route('admin.topic.status', $row->id) }}"
                                                                                    class="btn btn-sm btn-success">
                                                                                    <i class="fas fa-toggle-on"></i>
                                                                                </a>
                                                                            @else
                                                                                <a href="{{ route('admin.topic.status', $row->id) }}"
                                                                                    class="btn btn-sm btn-danger">
                                                                                    <i class="fas fa-toggle-off"></i>
                                                                                </a>
                                                                            @endif
                                                                            <a href="{{ route('admin.topic.show', $row->id) }}"
                                                                                class="btn btn-sm btn-info">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                            <a href="{{ route('admin.topic.edit', $args) }}"
                                                                                class="btn btn-sm btn-primary">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <a href="{{ route('admin.topic.delete', $args) }}"
                                                                                class="btn btn-sm btn-danger">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">{{ $row->id }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="row margin-t-5 justify-content-center">
                                                            <div class="col-lg-5 col-xs-12">
                                                                <div class="float-lg-left">
                                                                    <div class="dataTables_paginate paging_simple_numbers"
                                                                        id="topic-grid_paginate">
                                                                        <ul class="pagination">
                                                                            {{-- Previous Button --}}
                                                                            <li class="paginate_button page-item {{ $topic->onFirstPage() ? 'disabled' : '' }}"
                                                                                id="topic-grid_previous">
                                                                                <a href="{{ $topic->previousPageUrl() }}"
                                                                                    aria-controls="topic-grid"
                                                                                    class="page-link">Trước</a>
                                                                            </li>

                                                                            {{-- Pagination Links --}}
                                                                            @for ($i = 1; $i <= $topic->lastPage(); $i++)
                                                                                <li
                                                                                    class="paginate_button page-item {{ $i == $topic->currentPage() ? 'active' : '' }}">
                                                                                    <a href="{{ $topic->url($i) }}"
                                                                                        class="page-link">{{ $i }}</a>
                                                                                </li>
                                                                            @endfor

                                                                            {{-- Next Button --}}
                                                                            <li class="paginate_button page-item {{ $topic->hasMorePages() ? '' : 'disabled' }}"
                                                                                id="topic-grid_next">
                                                                                <a href="{{ $topic->nextPageUrl() }}"
                                                                                    aria-controls="topic-grid"
                                                                                    class="page-link">Kế tiếp</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <form method="GET"
                                                                    action="{{ route('admin.topic.index') }}"
                                                                    class="form-horizontal">

                                                                    <div class="text-center d-flex align-items-center">
                                                                        <div class="dataTables_length"
                                                                            id="topic-grid_length">
                                                                            <label>Số lượng
                                                                                <select style="width:62px"
                                                                                    name="items_per_page"
                                                                                    onchange="this.form.submit()"
                                                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                                                    <option value="7"
                                                                                        {{ $topic->perPage() == 7 ? 'selected' : '' }}>
                                                                                        7</option>
                                                                                    <option value="15"
                                                                                        {{ $topic->perPage() == 15 ? 'selected' : '' }}>
                                                                                        15</option>
                                                                                    <option value="20"
                                                                                        {{ $topic->perPage() == 20 ? 'selected' : '' }}>
                                                                                        20</option>
                                                                                    <option value="50"
                                                                                        {{ $topic->perPage() == 50 ? 'selected' : '' }}>
                                                                                        50</option>
                                                                                    <option value="100"
                                                                                        {{ $topic->perPage() == 100 ? 'selected' : '' }}>
                                                                                        100</option>
                                                                                </select> Sản phẩm
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <div class="float-lg-right text-center">
                                                                    <div class="dataTables_info" id="topic-grid_info"
                                                                        role="status" aria-live="polite">
                                                                        {{ $topic->firstItem() }} đến
                                                                        {{ $topic->lastItem() }} của
                                                                        {{ $topic->total() }} sản phẩm
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1 col-xs-12 mt-2">
                                                                <div
                                                                    class="float-lg-right text-center data-tables-refresh">
                                                                    <div class="btn-group ">
                                                                        <button class="btn btn-secondary"
                                                                            onclick="window.location.reload()"
                                                                            type="button">
                                                                            <span><i class="fas fa-sync-alt"></i></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </section>

    <!-- Thêm mã JavaScript của TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/fyqw5r3tchqm35wywjd85ij01v092q71nea4psfi1ar9sai4/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'advlist autolink lists link image charmap preview anchor textcolor',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: 'https://www.tiny.cloud/css/codepen.min.css'
        });
    </script>

    <!-- JavaScript để tự động ẩn thông báo sau 5 giây -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy tất cả các thông báo
            const alerts = document.querySelectorAll('.alert');

            // Đặt thời gian hiển thị (5000ms = 5 giây)
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.remove();
                });
            }, 5000);
        });

        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });

        document.getElementById('delete-selected').addEventListener('click', function(event) {
            event.preventDefault();

            var checkboxes = document.querySelectorAll('.product-checkbox:checked');
            var ids = [];

            checkboxes.forEach(function(checkbox) {
                ids.push(checkbox.value);
            });

            if (ids.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm.');
                return;
            }

            var form = document.getElementById('delete-form');
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids';
            input.value = ids.join(',');
            form.appendChild(input);

            form.submit();
        });
    </script>
@endsection
