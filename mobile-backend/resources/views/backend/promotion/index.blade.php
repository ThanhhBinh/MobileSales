@extends('layouts.admin')
@section('title', ' Khuyến mãi')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 ps-3"> Khuyến mãi</h1>
                            </div>
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn btn-success" href="{{ route('admin.promotion.create') }}">
                                        <i class="fas fa-plus"></i> Thêm mới
                                    </a>
                                </div>
                            </div>
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

                                            <div class="card card-default card-search">
                                                <div class="card-body">
                                                    @error('start_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <form method="GET" action="{{ route('admin.promotion.index') }}"
                                                        class="form-horizontal">
                                                        <div class="row search-row opened"
                                                            data-hideattribute="promotionListPage.HideSearchBlock">
                                                            <div class="search-text">Tìm kiếm</div>
                                                            <div class="icon-search"><i class="fas fa-search"
                                                                    aria-hidden="true"></i></div>
                                                        </div>
                                                        <div class="search-body">
                                                            <div class="row pl-5 pr-5 mt-3">
                                                                <div class="col-md-6">
                                                                    <!-- Ngày bắt đầu -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="name">
                                                                            Ngày bắt đầu:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" class="form-control"
                                                                                id="start_date" name="start_date"
                                                                                placeholder="Từ ngày"
                                                                                value="{{ request('start_date') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Ngày kết thúc -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="name">
                                                                            Ngày kết thúc:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" class="form-control"
                                                                                id="end_date" name="end_date"
                                                                                placeholder="Đến ngày"
                                                                                value="{{ request('end_date') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Trạng thái Khuyến mãi -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="discount_type">
                                                                            Loại giảm giá:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control" id="discount_type"
                                                                                name="discount_type">
                                                                                <option value="">Chọn loại giảm giá
                                                                                </option>
                                                                                @foreach (\App\Models\Promotion::getDiscountTypes() as $key => $value)
                                                                                    <option value="{{ $key }}"
                                                                                        {{ request('discount_type') == $key ? 'selected' : '' }}>
                                                                                        {{ $value }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <!-- Số điện thoại thanh toán -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="requires_coupon">
                                                                            Mã giảm giá :
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="requires_coupon"
                                                                                name="requires_coupon" type="text"
                                                                                value="{{ request('requires_coupon') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Địa chỉ Email thanh toán -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="name">
                                                                            Tên giảm giá :
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="name"
                                                                                name="name" type="text"
                                                                                value="{{ request('name') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Phương thức thanh toán -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="name">
                                                                            Đang hoạt động :
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control" id="is_active"
                                                                                name="is_active">
                                                                                <option value="">Tất cả</option>
                                                                                <option value="1"
                                                                                    {{ request('is_active') == '1' ? 'selected' : '' }}>
                                                                                    Đang hoạt động</option>
                                                                                <option value="0"
                                                                                    {{ request('is_active') == '0' ? 'selected' : '' }}>
                                                                                    Không hoạt động</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="text-center col-12">
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

                                    <div class="card">
                                        <div class="card-body">
                                            {{-- Thông báo thành công --}}
                                            @if (session('success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert">
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
                                                    @if ($list->isEmpty())
                                                        <div class="alert alert-info">
                                                            Không có sản phẩm nào để hiển thị.
                                                        </div>
                                                    @else
                                                        <table class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Tên</th>
                                                                    <th class="text-center">Loại giảm giá</th>
                                                                    <th class="text-center">Giảm giá</th>
                                                                    <th class="text-center">Ngày bắt đầu</th>
                                                                    <th class="text-center">Ngày kết thúc</th>
                                                                    <th class="text-center">Thời gian sử dụng</th>
                                                                    <th class="text-center">Đang hoạt động</th>
                                                                    <th class="text-center" style="width:30px">Chỉnh sửa
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($list as $row)
                                                                    <tr>
                                                                        <td>{!! $row->name !!}</td>
                                                                        <td>{!! \App\Models\Promotion::getDiscountTypes()[$row->discount_type] !!}</td>
                                                                        </td>
                                                                        <td class="text-center">{!! $row->discount_amount !!}
                                                                        </td>
                                                                        <td>{!! $row->start_date !!}</td>
                                                                        <td>{!! $row->end_date !!}</td>
                                                                        <td>{!! \Carbon\Carbon::parse($row->start_date)->locale('vi')->diffForHumans(\Carbon\Carbon::parse($row->end_date), true) !!}</td>
                                                                        <td class="text-center" style="width:150px">
                                                                            {!! $row->is_active == 1
                                                                                ? '<i class="fas fa-check true-icon" style="color: rgb(88, 155, 222); font-size: 24px" ></i>'
                                                                                : '<i class="fas fa-times false-icon" style="color: rgb(224, 57, 57); font-size: 24px"></i>' !!}
                                                                        </td>
                                                                        <td class="text-center" style="width:150px">
                                                                            <a href="{{ route('admin.promotion.edit', $row->id) }}"
                                                                                class="btn btn-sm btn-primary">
                                                                                Chỉnh sửa
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                        {{-- Phân trang --}}
                                                        <div class="row margin-t-5 justify-content-center">
                                                            <div class="col-lg-5 col-xs-12">
                                                                <div class="float-lg-left">
                                                                    <div class="dataTables_paginate paging_simple_numbers">
                                                                        <ul class="pagination">
                                                                            {{-- Previous Button --}}
                                                                            <li
                                                                                class="paginate_button page-item {{ $list->onFirstPage() ? 'disabled' : '' }}">
                                                                                <a href="{{ $list->previousPageUrl() }}"
                                                                                    class="page-link">Trước</a>
                                                                            </li>

                                                                            {{-- Pagination Links --}}
                                                                            @for ($i = 1; $i <= $list->lastPage(); $i++)
                                                                                <li
                                                                                    class="paginate_button page-item {{ $i == $list->currentPage() ? 'active' : '' }}">
                                                                                    <a href="{{ $list->url($i) }}"
                                                                                        class="page-link">{{ $i }}</a>
                                                                                </li>
                                                                            @endfor

                                                                            {{-- Next Button --}}
                                                                            <li
                                                                                class="paginate_button page-item {{ $list->hasMorePages() ? '' : 'disabled' }}">
                                                                                <a href="{{ $list->nextPageUrl() }}"
                                                                                    class="page-link">Kế tiếp</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Chọn số lượng hiển thị --}}
                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <form method="GET"
                                                                    action="{{ route('admin.promotion.index') }}"
                                                                    class="form-horizontal">
                                                                    <div class="text-center d-flex align-items-center">
                                                                        <div class="dataTables_length">
                                                                            <label>Số lượng
                                                                                <select style="width:62px"
                                                                                    name="items_per_page"
                                                                                    onchange="this.form.submit()"
                                                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                                                    <option value="7"
                                                                                        {{ $list->perPage() == 7 ? 'selected' : '' }}>
                                                                                        7</option>
                                                                                    <option value="15"
                                                                                        {{ $list->perPage() == 15 ? 'selected' : '' }}>
                                                                                        15</option>
                                                                                    <option value="20"
                                                                                        {{ $list->perPage() == 20 ? 'selected' : '' }}>
                                                                                        20</option>
                                                                                    <option value="50"
                                                                                        {{ $list->perPage() == 50 ? 'selected' : '' }}>
                                                                                        50</option>
                                                                                    <option value="100"
                                                                                        {{ $list->perPage() == 100 ? 'selected' : '' }}>
                                                                                        100</option>
                                                                                </select> Sản phẩm
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            {{-- Thông tin phân trang --}}
                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <div class="float-lg-right text-center">
                                                                    <div class="dataTables_info" role="status"
                                                                        aria-live="polite">
                                                                        {{ $list->firstItem() }} đến
                                                                        {{ $list->lastItem() }} của {{ $list->total() }}
                                                                        sản phẩm
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Nút làm mới --}}
                                                            <div class="col-lg-1 col-xs-12 mt-2">
                                                                <div
                                                                    class="float-lg-right text-center data-tables-refresh">
                                                                    <div class="btn-group">
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
            var checkboxes = document.querySelectorAll('.promotion-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });

        document.getElementById('delete-selected').addEventListener('click', function(event) {
            event.preventDefault();

            var checkboxes = document.querySelectorAll('.promotion-checkbox:checked');
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
