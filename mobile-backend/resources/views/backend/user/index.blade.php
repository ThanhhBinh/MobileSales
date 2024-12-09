@extends('layouts.admin')
@section('title', 'Người dùng')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 ps-3">Người dùng</h1>
                            </div>
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn btn-success" href="{{ route('admin.user.create') }}">
                                        <i class="fas fa-plus"></i> Thêm mới
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
                                            <div class="card card-default card-search">
                                                <div class="card-body">
                                                    <form method="GET" action="{{ route('admin.user.index') }}"
                                                        class="form-horizontal">
                                                        <div class="row search-row opened"
                                                            data-hideattribute="userListPage.HideSearchBlock">
                                                            <div class="search-text">Tìm kiếm</div>
                                                            <div class="icon-search"><i class="fas fa-search"
                                                                    aria-hidden="true"></i></div>
                                                        </div>
                                                        <div class="search-body">
                                                            <div class="row pl-5 pr-5 mt-3">
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
                                                                <div class="col-md-6">
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="start_date">Ngày đăng ký từ:</label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" class="form-control"
                                                                                id="start_date" name="start_date"
                                                                                placeholder="Ngày đăng ký từ"
                                                                                value="{{ request('start_date') }}"
                                                                                max="{{ date('Y-m-d') }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="end_date">Ngày đăng ký đến:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" class="form-control"
                                                                                id="end_date" name="end_date"
                                                                                placeholder="Ngày đăng ký đến"
                                                                                value="{{ request('end_date') }}"
                                                                                max="{{ date('Y-m-d') }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Trạng thái đơn hàng -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="email">
                                                                            Email:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="email"
                                                                                name="email" type="text"
                                                                                value="{{ request('email') }}" placeholder="Email">
                                                                        </div>
                                                                    </div>
                                                                    <!-- Họ -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="first_name">
                                                                            Họ:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="first_name"
                                                                                name="first_name" type="text"
                                                                                value="{{ request('first_name') }}" placeholder="Họ">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Tên đầu tiên -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="last_name">
                                                                            Tên đầu tiên:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="last_name"
                                                                                name="last_name" type="text"
                                                                                value="{{ request('last_name') }}" placeholder="Tên đầu tiên">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">

                                                                    <!-- Ngày hoạt động cuối cùng đến -->
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="start_action_date">Ngày hoạt động cuối cùng
                                                                            từ:</label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" class="form-control"
                                                                                id="start_action_date"
                                                                                name="start_action_date"
                                                                                placeholder="Ngày hoạt động cuối cùng từ:"
                                                                                value="{{ request('start_action_date') }}"
                                                                                max="{{ date('Y-m-d') }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="end_action_date">Ngày hoạt động cuối cùng
                                                                            đến:</label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" class="form-control"
                                                                                id="end_action_date" name="end_action_date"
                                                                                placeholder="Ngày hoạt động cuối cùng đến"
                                                                                value="{{ request('end_action_date') }}"
                                                                                max="{{ date('Y-m-d') }}">
                                                                        </div>
                                                                    </div>
                                                                    <!-- Họ -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right" for="roles">Vai trò của người dùng:</label>
                                                                        <div class="col-md-8">
                                                                            <select name="roles" id="roles" class="form-control">
                                                                                <option value="">-- Tất cả --</option>
                                                                                @foreach ($roles as $role)
                                                                                    <option value="{{ $role->id }}"
                                                                                        {{ request('roles') == $role->name ? 'selected' : '' }}>
                                                                                        {{ $role->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Số điện thoại -->
                                                                    <div class="form-group row">
                                                                        <label class="col-md-4 col-form-label text-right"
                                                                            for="phone">
                                                                            Số điện thoại:
                                                                        </label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control" id="phone"
                                                                                name="phone" type="text"
                                                                                value="{{ request('phone') }}" placeholder="Số điện thoại">
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
                                                                    <th class="text-center">Hình</th>
                                                                    <th class="text-center">Email
                                                                    </th>
                                                                    <th class="text-center">Tên</th>
                                                                    <th class="text-center" style="width:200px">Số điện thoại</th>
                                                                    <th class="text-center" style="width:150px">Chỉnh sửa</th>
                                                                    <th class="text-center" style="width:30px">ID</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($list as $row)
                                                                    @php
                                                                        $args = ['user_id' => $row->user_id];
                                                                    @endphp
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <img src="{{ asset('images/users/' . $row->image) }}"
                                                                                class="img-fluid"
                                                                                alt="{{ $row->last_name }}"
                                                                                style="max-width: 80px; max-height: 80px;">
                                                                        </td>
                                                                        <td>{{ $row->email }}</td>
                                                                        <td>{{ $row->last_name }}</td>
                                                                        <td>{{ $row->phone}}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{ route('admin.user.edit', $args) }}"
                                                                                class="btn btn-sm btn-primary">
                                                                                Chỉnh sửa
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">{{ $row->user_id }}</td>
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
                                                                    action="{{ route('admin.user.index') }}"
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
    </script>
@endsection
