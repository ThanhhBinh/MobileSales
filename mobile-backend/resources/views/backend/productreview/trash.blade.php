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
                                <h1 class="m-0">Thùng rác đánh giá</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn  btn-info" href="{{ route('admin.productreview.index') }}">
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
                                                        action="{{ route('admin.productreview.destroy_multiple') }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-danger" type="submit" id="delete-selected">
                                                            <i class="fas fa-trash"></i> Xóa đã chọn</button>
                                                    </form>

                                                    <form style="width: 200px;" id="restore-form"
                                                        action="{{ route('admin.productreview.restore_multiple') }}"
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
                                                            <th class="text-center" style="width:150px">Hình</th>
                                                            <th class="text-center">Tên sản phẩm</th>
                                                            <th class="text-center">Khách hàng</th>
                                                            <th class="text-center">Tiêu đề</th>
                                                            <th class="text-center">Đánh giá</th>
                                                            <th class="text-center">Trả lời</th>
                                                            <th class="text-center">Xếp hạng</th>
                                                            <th class="text-center">Ngày tạo</th>
                                                            <th class="text-center" style="width:150px">Chức năng
                                                            </th>
                                                            <th class="text-center" style="width:30px">ID</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($list as $row)
                                                            <tr>
                                                                @php
                                                                    $args = ['review_id' => $row->review_id];
                                                                @endphp
                                                                <td class="text-center">
                                                                    <input type="checkbox" class="product-checkbox"
                                                                        value="{{ $row->review_id }}" name="checkId[]">
                                                                </td>
                                                                <td class="text-center">
                                                                    @if ($row->image)
                                                                        <img src="{{ asset('images/productreviews/' . $row->image) }}"
                                                                            class="img-fluid" alt="{{ $row->productname }}">
                                                                    @else
                                                                        <img src="{{ asset('images/default.png') }}"
                                                                            class="img-fluid" alt="default image">
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
                                                                <td class="text-center">{!! $row->created_at !!}
                                                                </td>

                                                                <td class="text-center">

                                                                    <a href="{{ route('admin.productreview.restore', $args) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-undo"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('admin.productreview.destroy', $args) }}"
                                                                        method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-sm btn-danger" name="delete"
                                                                            type="submit">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                                <td class="text-center">{{ $row->review_id }}</td>
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
