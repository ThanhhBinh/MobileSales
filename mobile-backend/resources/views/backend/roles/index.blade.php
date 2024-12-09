@extends('layouts.admin')
@section('title', 'Vai trò của người dùng')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Vai trò của người dùng</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn btn-success" href="{{ route('admin.roles.create') }}">
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
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width:150px">Vai trò</th>
                                                                <th>Mô tả</th>
                                                                <th class="text-center" style="width:200px">Là vai trò của
                                                                    hệ thống</th>
                                                                <th class="text-center" style="width:200px">Chức năng
                                                                </th>
                                                                <th class="text-center" style="width:30px">ID</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($roles as $row)
                                                                <tr>
                                                                    @php
                                                                        $args = ['id' => $row->id];
                                                                    @endphp
                                                                    <td>{{ $row->name }}</td>
                                                                    <td>{!! $row->description !!}</td>
                                                                    <td class="text-center" >{!! $row->is_system == '1'
                                                                        ? '<i class="fas fa-check true-icon" style="color: rgb(88, 155, 222); font-size: 28px" ></i>'
                                                                        : '<i class="fas fa-times false-icon" style="color: rgb(224, 57, 57); font-size: 28px"></i>' !!}</td>

                                                                    <td class="text-center">
                                                                        <a href="{{ route('admin.roles.edit', $args) }}"
                                                                            class="btn btn-sm btn-primary">
                                                                            Chỉnh sửa
                                                                            <i class="fas fa-edit"></i>
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
                                                                    id="roles-grid_paginate">
                                                                    <ul class="pagination">
                                                                        {{-- Previous Button --}}
                                                                        <li class="paginate_button page-item {{ $roles->onFirstPage() ? 'disabled' : '' }}"
                                                                            id="roles-grid_previous">
                                                                            <a href="{{ $roles->previousPageUrl() }}"
                                                                                aria-controls="roles-grid"
                                                                                class="page-link">Trước</a>
                                                                        </li>

                                                                        {{-- Pagination Links --}}
                                                                        @for ($i = 1; $i <= $roles->lastPage(); $i++)
                                                                            <li
                                                                                class="paginate_button page-item {{ $i == $roles->currentPage() ? 'active' : '' }}">
                                                                                <a href="{{ $roles->url($i) }}"
                                                                                    class="page-link">{{ $i }}</a>
                                                                            </li>
                                                                        @endfor

                                                                        {{-- Next Button --}}
                                                                        <li class="paginate_button page-item {{ $roles->hasMorePages() ? '' : 'disabled' }}"
                                                                            id="roles-grid_next">
                                                                            <a href="{{ $roles->nextPageUrl() }}"
                                                                                aria-controls="roles-grid"
                                                                                class="page-link">Kế tiếp</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-xs-12 mt-3">
                                                            <form method="GET" action="{{ route('admin.roles.index') }}"
                                                                class="form-horizontal">

                                                                <div class="text-center d-flex align-items-center">
                                                                    <div class="dataTables_length" id="roles-grid_length">
                                                                        <label>Số lượng
                                                                            <select style="width:62px" name="items_per_page"
                                                                                onchange="this.form.submit()"
                                                                                class="custom-select custom-select-sm form-control form-control-sm">
                                                                                <option value="7"
                                                                                    {{ $roles->perPage() == 7 ? 'selected' : '' }}>
                                                                                    7</option>
                                                                                <option value="15"
                                                                                    {{ $roles->perPage() == 15 ? 'selected' : '' }}>
                                                                                    15</option>
                                                                                <option value="20"
                                                                                    {{ $roles->perPage() == 20 ? 'selected' : '' }}>
                                                                                    20</option>
                                                                                <option value="50"
                                                                                    {{ $roles->perPage() == 50 ? 'selected' : '' }}>
                                                                                    50</option>
                                                                                <option value="100"
                                                                                    {{ $roles->perPage() == 100 ? 'selected' : '' }}>
                                                                                    100</option>
                                                                            </select> Sản phẩm
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div class="col-lg-3 col-xs-12 mt-3">
                                                            <div class="float-lg-right text-center">
                                                                <div class="dataTables_info" id="roles-grid_info"
                                                                    role="status" aria-live="polite">
                                                                    {{ $roles->firstItem() }} đến
                                                                    {{ $roles->lastItem() }} của
                                                                    {{ $roles->total() }} sản phẩm
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-1 col-xs-12 mt-2">
                                                            <div class="float-lg-right text-center data-tables-refresh">
                                                                <div class="btn-group ">
                                                                    <button class="btn btn-secondary"
                                                                        onclick="window.location.reload()" type="button">
                                                                        <span><i class="fas fa-sync-alt"></i></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
