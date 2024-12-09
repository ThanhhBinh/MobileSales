@extends('layouts.admin')
@section('title', 'Danh mục')
@section('content')

    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Thùng rác danh mục</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn  btn-info" href="{{ route('admin.category.index') }}">
                                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                                        Quay về trang
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
                                            @if (session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="mb-3 col-12 d-flex justify-content-start">
                                                    <form style=" margin-right: 10px;" id="delete-form"
                                                        action="{{ route('admin.category.destroy_multiple') }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-danger" type="submit" id="delete-selected">
                                                            <i class="fas fa-trash"></i> Xóa đã chọn</button>
                                                    </form>

                                                    <form style="width: 200px;" id="restore-form"
                                                        action="{{ route('admin.category.restore_multiple') }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-primary" type="submit"
                                                            id="restore-selected">
                                                            <i class="fas fa-undo"></i> Khôi phục đã chọn</button>
                                                    </form>
                                                </div>
                                                <table class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width:30px">
                                                                <input type="checkbox" id="select-all">
                                                            </th>
                                                            <th class="text-center" style="width:150px">Hình ảnh</th>
                                                            <th>Tên danh mục</th>
                                                            <th>Mô tả</th>
                                                            <th class="text-center" style="width:200px">Chức năng</th>
                                                            <th class="text-center" style="width:30px">ID</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($list as $row)
                                                            <tr>
                                                                @php
                                                                    $args = ['id' => $row->id];
                                                                @endphp
                                                                <td class="text-center">
                                                                    <input type="checkbox" class="product-checkbox"
                                                                        value="{{ $row->id }}" name="checkId[]">
                                                                </td>
                                                                <td class="text-center">
                                                                    <img src="{{ asset('images/categorys/' . $row->image) }}"
                                                                        class="img-fluid" alt="{{ $row->image }}">
                                                                </td>
                                                                <td>{{ $row->name }}</td>
                                                                <td>{{ $row->slug }}</td>
                                                                <td class="text-center">
                                                                    <a href="{{ route('admin.category.show', $args) }}"
                                                                        class="btn btn-sm btn-info">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.category.restore', $args) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-undo"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('admin.category.destroy', $args) }}"
                                                                        method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-sm btn-danger" name="delete"
                                                                            type="submit">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                                <td class="text-center">{{ $row->id }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
            input.name = 'ids'; // Đảm bảo tên là 'ids'
            input.value = ids.join(','); // Chuyển đổi mảng thành chuỗi
            form.appendChild(input);

            form.submit(); // Gửi form
        });

        document.getElementById('restore-selected').addEventListener('click', function(event) {
            event.preventDefault();

            var checkboxes = document.querySelectorAll('.product-checkbox:checked');
            var ids = [];

            checkboxes.forEach(function(checkbox) {
                ids.push(checkbox.value);
            });

            if (ids.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để khôi phục.');
                return;
            }

            var form = document.getElementById('restore-form');
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids'; // Đảm bảo tên là 'ids'
            input.value = ids.join(','); // Chuyển đổi mảng thành chuỗi
            form.appendChild(input);

            form.submit(); // Gửi form
        });
    </script>
@endsection
