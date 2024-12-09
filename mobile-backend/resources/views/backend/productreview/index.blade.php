@extends('layouts.admin')
@section('title', 'Đánh giá sản phẩm')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Đánh giá sản phẩm</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn btn-danger" href="{{ route('admin.productreview.trash') }}">
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
                                                            <form method="GET"
                                                                action="{{ route('admin.productreview.index') }}"
                                                                class="form-horizontal">


                                                                <!-- Body của form tìm kiếm -->
                                                                <div class="search-body">
                                                                    <div class="row px-5 mt-3">

                                                                        @if ($errors->any())
                                                                            <div class=" col-md-12 alert alert-danger">
                                                                                <ul>
                                                                                    @foreach ($errors->all() as $error)
                                                                                        <li style="list-style: none">
                                                                                            {{ $error }}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        @endif
                                                                        <!-- Trường tìm kiếm theo tên Đánh giá sản phẩm -->
                                                                        <div class="col-md-6">


                                                                            <div class="form-group row mb-3">
                                                                                <label
                                                                                    class="col-md-4 col-form-label text-right"
                                                                                    for="start_date">Từ ngày:</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="date"
                                                                                        class="form-control" id="start_date"
                                                                                        name="start_date"
                                                                                        placeholder="Từ ngày"
                                                                                        value="{{ request('start_date') }}"
                                                                                        max="{{ date('Y-m-d') }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-3">
                                                                                <label
                                                                                    class="col-md-4 col-form-label text-right"
                                                                                    for="end_date">Đến ngày:</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="date"
                                                                                        class="form-control" id="end_date"
                                                                                        name="end_date"
                                                                                        placeholder="Đến ngày"
                                                                                        value="{{ request('end_date') }}"
                                                                                        max="{{ date('Y-m-d') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Trường lọc theo trạng thái -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row mb-3">
                                                                                <label
                                                                                    class="col-md-4 col-form-label text-right"
                                                                                    for="status">Tán thành:</label>
                                                                                <div class="col-md-8">
                                                                                    <select name="status" id="status"
                                                                                        class="form-control">
                                                                                        <option value="">Tất cả
                                                                                        </option>
                                                                                        <option value="1"
                                                                                            {{ request('status') == '1' ? 'selected' : '' }}>
                                                                                            Chấp thuận
                                                                                        </option>
                                                                                        <option value="2"
                                                                                            {{ request('status') == '2' ? 'selected' : '' }}>
                                                                                            Không chấp thuận</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label
                                                                                    class="col-md-4 col-form-label text-right"
                                                                                    for="name">Tên sản phẩm:</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="text"
                                                                                        class="form-control" id="name"
                                                                                        name="name"
                                                                                        placeholder="Tên sản phẩm"
                                                                                        value="{{ request('name') }}">
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
                                                <div class="alert alert-danger alert-dismissible fade show"
                                                    role="alert">
                                                    {{ session('error') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endif


                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if ($reviews->isEmpty())
                                                        <div class="alert alert-info">
                                                            Không có dánh giá sản phẩm nào để hiển thị.
                                                        </div>
                                                    @else
                                                        <div class="mb-3" style="display:flex">
                                                            <form
                                                                action="{{ route('admin.productreview.delete_multiple') }}"
                                                                method="POST" id="delete-form">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger mr-3"
                                                                    id="delete-selected">
                                                                    <i class="fas fa-trash"></i>
                                                                    Xóa đã chọn
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('admin.productreview.publish_multiple') }}"
                                                                method="POST" id="publish-form">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success mr-3"
                                                                    id="publish-selected">
                                                                    <i class="fas fa-check-square"></i>
                                                                    Phê duyệt đã chọn
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('admin.productreview.unpublish_multiple') }}"
                                                                method="POST" id="unpublish-form">
                                                                @csrf
                                                                <button type="submit" class="btn  btn-secondary"
                                                                    id="unpublish-selected">
                                                                    <i class="fas fa-minus-square"></i>
                                                                    Không chấp nhận mục đã chọn
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <table class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" style="width:30px">
                                                                        <input type="checkbox" id="select-all">
                                                                    </th>
                                                                    <th class="text-center" style="width:150px">Hình</th>
                                                                    <th class="text-center">Tên sản phẩm</th>
                                                                    <th class="text-center">Khách hàng</th>
                                                                    <th class="text-center">Tiêu đề</th>
                                                                    <th class="text-center">Đánh giá</th>
                                                                    <th class="text-center">Trả lời</th>
                                                                    <th class="text-center">Xếp hạng</th>
                                                                    <th class="text-center">Đã được chấp thuận</th>
                                                                    <th class="text-center">Ngày tạo</th>
                                                                    <th class="text-center" style="width:150px">Chức năng
                                                                    </th>
                                                                    <th class="text-center" style="width:30px">ID</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($reviews as $row)
                                                                    <tr>
                                                                        @php
                                                                            $args = ['review_id' => $row->review_id];
                                                                        @endphp
                                                                        <td class="text-center">
                                                                            <input type="checkbox"
                                                                                class="product-checkbox"
                                                                                value="{{ $row->review_id }}"
                                                                                name="checkId[]">
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @if ($row->media_url)
                                                                                <img src="{{ asset('storage/' . $row->media_url) }}" alt="Product Image" width="100">
                                                                            @else
                                                                                <img src="/path/to/default/image.jpg" alt="Default Image" width="100">
                                                                            @endif
                                                                        </td>
                                                                        <td style="width:200px">{{ $row->productname }}
                                                                        </td>
                                                                        <td>{!! $row->username !!}</td>
                                                                        <td>{!! $row->title !!}</td>
                                                                        <td style="width:300px">
                                                                            <div
                                                                                style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-overflow: ellipsis;">
                                                                                {!! $row->review_text !!}
                                                                            </div>
                                                                        </td>
                                                                        <td style="width:300px">
                                                                            <div
                                                                                style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-overflow: ellipsis;">
                                                                                {!! $row->replay !!}
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center" style="width:50px">
                                                                            {!! $row->rating !!}</td>
                                                                        <td class="text-center" style="width:100px">
                                                                            @if ($row->review_status == 1)
                                                                                <i style="color: rgb(38, 184, 38); font-size: 20px"
                                                                                    class="fas fa-check"></i>
                                                                                <!-- Chấp thuận -->
                                                                            @elseif ($row->review_status == 2)
                                                                                <i style="color: red; font-size: 20px"
                                                                                    class="fas fa-times"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center">{!! $row->created_at !!}
                                                                        </td>

                                                                        <td class="text-center">

                                                                            <a href="{{ route('admin.productreview.replay', $args) }}"
                                                                                class="btn btn-sm btn-primary">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <a href="{{ route('admin.productreview.delete', $args) }}"
                                                                                class="btn btn-sm btn-danger">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">{{ $row->review_id }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="row margin-t-5 justify-content-center">
                                                            <div class="col-lg-5 col-xs-12">
                                                                <div class="float-lg-left">
                                                                    <div class="dataTables_paginate paging_simple_numbers"
                                                                        id="reviews-grid_paginate">
                                                                        <ul class="pagination">
                                                                            {{-- Previous Button --}}
                                                                            <li class="paginate_button page-item {{ $reviews->onFirstPage() ? 'disabled' : '' }}"
                                                                                id="reviews-grid_previous">
                                                                                <a href="{{ $reviews->previousPageUrl() }}"
                                                                                    aria-controls="reviews-grid"
                                                                                    class="page-link">Trước</a>
                                                                            </li>

                                                                            {{-- Pagination Links --}}
                                                                            @for ($i = 1; $i <= $reviews->lastPage(); $i++)
                                                                                <li
                                                                                    class="paginate_button page-item {{ $i == $reviews->currentPage() ? 'active' : '' }}">
                                                                                    <a href="{{ $reviews->url($i) }}"
                                                                                        class="page-link">{{ $i }}</a>
                                                                                </li>
                                                                            @endfor

                                                                            {{-- Next Button --}}
                                                                            <li class="paginate_button page-item {{ $reviews->hasMorePages() ? '' : 'disabled' }}"
                                                                                id="reviews-grid_next">
                                                                                <a href="{{ $reviews->nextPageUrl() }}"
                                                                                    aria-controls="reviews-grid"
                                                                                    class="page-link">Kế tiếp</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <form method="GET"
                                                                    action="{{ route('admin.productreview.index') }}"
                                                                    class="form-horizontal">

                                                                    <div class="text-center d-flex align-items-center">
                                                                        <div class="dataTables_length"
                                                                            id="reviews-grid_length">
                                                                            <label>Số lượng
                                                                                <select style="width:62px"
                                                                                    name="items_per_page"
                                                                                    onchange="this.form.submit()"
                                                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                                                    <option value="7"
                                                                                        {{ $reviews->perPage() == 7 ? 'selected' : '' }}>
                                                                                        7</option>
                                                                                    <option value="15"
                                                                                        {{ $reviews->perPage() == 15 ? 'selected' : '' }}>
                                                                                        15</option>
                                                                                    <option value="20"
                                                                                        {{ $reviews->perPage() == 20 ? 'selected' : '' }}>
                                                                                        20</option>
                                                                                    <option value="50"
                                                                                        {{ $reviews->perPage() == 50 ? 'selected' : '' }}>
                                                                                        50</option>
                                                                                    <option value="100"
                                                                                        {{ $reviews->perPage() == 100 ? 'selected' : '' }}>
                                                                                        100</option>
                                                                                </select> Sản phẩm
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <div class="float-lg-right text-center">
                                                                    <div class="dataTables_info" id="reviews-grid_info"
                                                                        role="status" aria-live="polite">
                                                                        {{ $reviews->firstItem() }} đến
                                                                        {{ $reviews->lastItem() }} của
                                                                        {{ $reviews->total() }} sản phẩm
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

        //Xóa các mục đã chọn
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

        //publish
        document.getElementById('publish-selected').addEventListener('click', function(event) {
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

            var form = document.getElementById('publish-form');
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids';
            input.value = ids.join(',');
            form.appendChild(input);

            form.submit();
        });

        //unpublish
        document.getElementById('unpublish-selected').addEventListener('click', function(event) {
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

            var form = document.getElementById('unpublish-form');
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids';
            input.value = ids.join(',');
            form.appendChild(input);

            form.submit();
        });
    </script>
@endsection
