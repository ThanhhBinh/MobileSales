@extends('layouts.admin')
@section('title', ' Đơn hàng')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 ps-3"> Đơn hàng</h1>
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
                                                    <form method="GET" action="{{ route('admin.order.index') }}"
                                                        class="form-horizontal">
                                                        <div class="search-body">
                                                            <div class="row pl-5 pr-5 mt-3">
                                                                <div class="col-md-6">
                                                                    <!-- Ngày bắt đầu -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="start_date">Ngày bắt đầu:</label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="start_date"
                                                                                name="start_date" type="date"
                                                                                value="{{ request('start_date') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Ngày kết thúc -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="end_date">Ngày kết thúc:</label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="end_date"
                                                                                name="end_date" type="date"
                                                                                value="{{ request('end_date') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Trạng thái đơn hàng -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="order_status">Trạng thái đơn hàng:</label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control" id="status"
                                                                                name="status">
                                                                                <option value="">Chọn trạng thái giao
                                                                                    hàng</option>
                                                                                @foreach (\App\Models\Order::status() as $key => $value)
                                                                                    <option value="{{ $key }}"
                                                                                        {{ (string) request('status') === (string) $key ? 'selected' : '' }}>
                                                                                        {{ $value }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Trạng thái thanh toán -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="payment_status">Trạng thái thanh
                                                                            toán:</label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control" id="payment_status"
                                                                                name="payment_status">
                                                                                <option value="">Chọn trạng thái thanh
                                                                                    toán</option>
                                                                                @foreach (\App\Models\Order::payment_status() as $key => $value)
                                                                                    <option value="{{ $key }}"
                                                                                        {{ (string) request('payment_status') === (string) $key ? 'selected' : '' }}>
                                                                                        {{ $value }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Trạng thái vận chuyển -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="shipping_method_id">
                                                                            Trạng thái vận chuyển:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control"
                                                                                id="shipping_method_id"
                                                                                name="shipping_method_id">
                                                                                <option value="">Chọn trạng thái giao
                                                                                    hàng</option>
                                                                                @foreach (\App\Models\Order::shipping_status() as $key => $value)
                                                                                    <option value="{{ $key }}"
                                                                                        {{ (string) request('shipping_method_id') === (string) $key ? 'selected' : '' }}>
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
                                                                            for="phone_number">Số điện thoại thanh
                                                                            toán:</label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="phone_number"
                                                                                name="phone_number" type="text"
                                                                                value="{{ request('phone_number') }}"
                                                                                placeholder="Số điện thoại">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Địa chỉ Email thanh toán -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="email">Địa chỉ Email thanh toán:</label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="email"
                                                                                name="email" type="text"
                                                                                value="{{ request('email') }}"
                                                                                placeholder="Email">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Phương thức thanh toán -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="payment_method">Phương thức thanh
                                                                            toán:</label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control" id="status"
                                                                                name="payment_method">
                                                                                <option value="">Chọn trạng thái
                                                                                    giao
                                                                                    hàng</option>
                                                                                @foreach ($payment as $row)
                                                                                    <option
                                                                                        value="{{ $row->payment_method_id }}">
                                                                                        {{ $row->method_name }}
                                                                                    </option>
                                                                                @endforeach
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
                                                                    <th class="text-center" style="width:30px">
                                                                        <input type="checkbox" id="select-all">
                                                                    </th>
                                                                    <th class="text-center">Đặt hàng #
                                                                    </th>
                                                                    <th class="text-center">Trạng thái đơn hàng</th>
                                                                    <th class="text-center">Phương thức thanh toán</th>
                                                                    <th class="text-center">Trạng thái thanh toán</th>
                                                                    <th class="text-center">Tình trạng vận chuyển</th>
                                                                    <th class="text-center">Khách hàng
                                                                    </th>
                                                                    <th class="text-center">Được tạo ra vào
                                                                    </th>
                                                                    <th class="text-center">Tổng đơn hàng
                                                                    </th>
                                                                    <th class="text-center" style="width:100px">Xem</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($list as $row)
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <input type="checkbox" class="order-checkbox"
                                                                                value="{{ $row->order_id }}"
                                                                                name="checkId[]">
                                                                        </td>

                                                                        <td>{!! $row->order_id !!}</td>
                                                                        <td class="text-center">
                                                                            @php
                                                                                $status = \App\Models\Order::status()[
                                                                                    $row->status
                                                                                ];
                                                                                switch ($row->status) {
                                                                                    case 1:
                                                                                        $statusClass = 'bg-warning';
                                                                                        break;
                                                                                    case 2:
                                                                                        $statusClass = 'bg-info';
                                                                                        break;
                                                                                    case 3:
                                                                                        $statusClass = 'bg-success';
                                                                                        break;
                                                                                    case 4:
                                                                                        $statusClass = 'bg-danger';
                                                                                        break;
                                                                                    default:
                                                                                        $statusClass = 'bg-danger';
                                                                                        break;
                                                                                }
                                                                            @endphp
                                                                            <span
                                                                                class="text-white p-2 {{ $statusClass }}">{{ $status }}</span>
                                                                        </td>
                                                                        <td>{!! $row->method_name !!}</td>
                                                                        <td>{!! \App\Models\Order::payment_status()[$row->payment_status] !!}</td>
                                                                        <td>{!! \App\Models\Order::shipping_status()[$row->shipping_method_id] !!}</td>
                                                                        <td>{!! $row->last_name !!}</td>
                                                                        <td>{!! $row->created_at !!}</td>
                                                                        <td>{{ number_format($row->total_order, 0, ',', '.') }}₫
                                                                        </td>
                                                                        <td class="text-center">

                                                                            <a href="{{ route('admin.order.edit', $row->order_id) }}"
                                                                                class="btn btn-sm btn-primary">
                                                                                <i class="far fa-eye"></i>
                                                                                Xem
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="row margin-t-5 justify-content-center">
                                                            <div class="col-lg-5 col-xs-12">
                                                                <div class="float-lg-left">
                                                                    <div class="dataTables_paginate paging_simple_numbers"
                                                                        id="list-grid_paginate">
                                                                        <ul class="pagination">
                                                                            {{-- Previous Button --}}
                                                                            <li class="paginate_button page-item {{ $list->onFirstPage() ? 'disabled' : '' }}"
                                                                                id="list-grid_previous">
                                                                                <a href="{{ $list->previousPageUrl() }}"
                                                                                    aria-controls="list-grid"
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
                                                                            <li class="paginate_button page-item {{ $list->hasMorePages() ? '' : 'disabled' }}"
                                                                                id="list-grid_next">
                                                                                <a href="{{ $list->nextPageUrl() }}"
                                                                                    aria-controls="list-grid"
                                                                                    class="page-link">Kế tiếp</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <form method="GET"
                                                                    action="{{ route('admin.order.index') }}"
                                                                    class="form-horizontal">

                                                                    <div class="text-center d-flex align-items-center">
                                                                        <div class="dataTables_length"
                                                                            id="list-grid_length">
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

                                                            <div class="col-lg-3 col-xs-12 mt-3">
                                                                <div class="float-lg-right text-center">
                                                                    <div class="dataTables_info" id="list-grid_info"
                                                                        role="status" aria-live="polite">
                                                                        {{ $list->firstItem() }} đến
                                                                        {{ $list->lastItem() }} của
                                                                        {{ $list->total() }} sản phẩm
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
            var checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });

        document.getElementById('delete-selected').addEventListener('click', function(event) {
            event.preventDefault();

            var checkboxes = document.querySelectorAll('.order-checkbox:checked');
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
