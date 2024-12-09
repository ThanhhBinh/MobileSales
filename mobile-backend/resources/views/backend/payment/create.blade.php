@extends('layouts.admin')
@section('title', 'Tạo mới thanh toán')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tạo mới thanh toán</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-info" href="{{ route('admin.payment.index') }}">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card card-body">
            <div class="row">
                <div class="col-12 border-bottom pb-2 mb-3">
                    <i style="font-size: 20px" class="fas fa-info"></i>
                    <span style="font-size: 24px; margin-left:5px">Thông tin thanh toán</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.payment.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="method_name">Tên thanh toán</label>
                            <input type="text" value="{{ old('method_name') }}" name="method_name" id="method_name"
                                class="form-control">
                            @error('method_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status">Trạng thái hệ thống</label>
                            <select name="status" id="status" class="form-control">
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Xuất bản</option>
                            </select>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success">Tạo mới thanh toán</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Include TinyMCE library -->
    <script src="https://cdn.tiny.cloud/1/fyqw5r3tchqm35wywjd85ij01v092q71nea4psfi1ar9sai4/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- Initialize TinyMCE on the textarea -->
    <script>
        tinymce.init({
            selector: '#description',
            menubar: false,
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            plugins: 'lists',
            height: 300
        });
    </script>
@endsection
