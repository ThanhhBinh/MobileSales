@extends('layouts.admin')
@section('title', ' Vận chuyển')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 ps-3"> Vận chuyển</h1>
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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-default card-search">
                                                <div class="card-body">
                                                    <form method="GET" action="{{ route('admin.shipping.index') }}"
                                                        class="form-horizontal">
                                                        <div class="row search-row opened">
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
                                                                            for="start_date">
                                                                            Ngày bắt đầu:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="start_date"
                                                                                name="start_date" type="date"
                                                                                value="{{ request('start_date') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Ngày kết thúc -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="end_date">
                                                                            Ngày kết thúc:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="end_date"
                                                                                name="end_date" type="date"
                                                                                value="{{ request('end_date') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">

                                                                    <!-- Tiểu bang/tỉnh -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="status">
                                                                            Trạng thái giao hàng:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control" id="status"
                                                                                name="status">
                                                                                <option value="">Chọn trạng thái giao
                                                                                    hàng</option>
                                                                                @foreach (\App\Models\ShippingMethod::status() as $key => $value)
                                                                                    <option value="{{ $key }}"
                                                                                        {{ (string) request('status') === (string) $key ? 'selected' : '' }}>
                                                                                        {{ $value }}
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
                                                    @if ($list->isEmpty())
                                                        <div class="alert alert-info">
                                                            Không có sản phẩm nào để hiển thị.
                                                        </div>
                                                    @else
                                                        <table class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" style="width:100px">Lô hàng #
                                                                    </th>
                                                                    <th class="text-center" style="width:150px">Đặt hàng #
                                                                    </th>
                                                                    <th class="text-center" style="width:150px">Tổng trọng
                                                                        lượng</th>
                                                                    <th class="text-center">Thời gian giao hàng
                                                                    </th>
                                                                    <th class="text-center">Ngày giao hàng
                                                                    </th>
                                                                    <th class="text-center">Trạng thái giao hàng
                                                                    </th>
                                                                    </th>
                                                                    <th class="text-center" style="width:150px">Xem</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($list as $row)
                                                                    <tr>
                                                                        <td class="text-center">{!! $row->shipping_method_id !!}
                                                                        </td>
                                                                        <td class="text-center">{!! $row->order_id !!}
                                                                        </td>
                                                                        <td class="text-center">{!! $row->total_weight !!}
                                                                        </td>
                                                                        <td>{!! $row->estimated_delivery_time !!}</td>
                                                                        <td>{!! $row->created_at !!}</td>
                                                                        <td class="text-center">
                                                                            @if ($row->status == 0)
                                                                                <span
                                                                                    style="background-color: #3082ec; padding: 5px">Chưa
                                                                                    được vận chuyển</span>
                                                                            @elseif ($row->status == 1)
                                                                                <span
                                                                                    style="background-color: #118d21; padding: 5px">Đã
                                                                                    vận chuyển</span>
                                                                            @elseif ($row->status == 3)
                                                                                <span
                                                                                    style="background-color: #d8d53f; padding: 5px">Không
                                                                                    cần vận chuyển</span>
                                                                            @else
                                                                                <span
                                                                                    style="background-color: #e61d1d; padding: 5px">Vận
                                                                                    chuyển thất bại</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center"><a
                                                                                href="{{ route('admin.shipping.edit', $row->shipping_method_id) }}"
                                                                                class="btn btn-sm btn-info">
                                                                                <i class="fas fa-eye"></i>
                                                                                Xem
                                                                            </a></td>
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
                                                                    action="{{ route('admin.shipping.index') }}"
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
