@extends('layouts.admin')
@section('title', 'Thêm thương hiệu')
@section('content')
        
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Thêm thương hiệu mới</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn  btn-info" href="{{ route('admin.brand.index') }}">
                                        <i class="fa fa-arrow-left"></i> Về danh sách
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
                                                        <i class="fas fa-info"></i>
                                                        Thông tin thương hiệu
                                                    </div>
                                                    <div class="card-tools float-right">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse">
                                                            <i class="fa toggle-icon fa-minus"></i> </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="display: block;">
                                                    <div class="row">
                                                        <form action="{{ route('admin.brand.store') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="name">Tên thương hiệu</label>
                                                                <input type="text" value="{{ old('name') }}"
                                                                    name="name" id="name" class="form-control">
                                                                @error('name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description">Mô tả</label>
                                                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="sort_order">Sắp xếp</label>
                                                                <select name="sort_order" id="sort_order"
                                                                    class="form-control">
                                                                    <option selected value="0">None</option>
                                                                    {!! $htmlsortorder !!}
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="image">Hình ảnh</label>
                                                                <input type="file" name="image" id="image"
                                                                    class="form-control" onchange="previewImage(event)">
                                                                <div class="row" style="margin-top: 10px;">
                                                                    <div class="col-2">
                                                                        <img id="preview" src="#" alt="Xem trước ảnh"
                                                                        style="width: 150px; display: none;" />
                                                                    </div>
                                                                    <div class="col-10 d-flex align-items-center ">
                                                                        <button type="button" onclick="removeImage()"
                                                                        style="display: none;" id="remove-btn"
                                                                        class="btn btn-danger mt-5">
                                                                        Xóa hình
                                                                    </button>
                                                                    </div>
                                                                    
                                                                </div>
                                                                @error('image')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status">Trạng thái</label>
                                                                <select name="status" id="status" class="form-control">
                                                                    <option selected value="2">Chưa xuất bản</option>
                                                                    <option  value="1">Xuất bản</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 text-center">
                                                                <button type="submit" name="create"
                                                                    class="btn btn-success">Thêm thương hiệu</button>
                                                            </div>
                                                        </form>
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
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const removeBtn = document.getElementById('remove-btn');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    removeBtn.style.display = 'inline-block'; // Hiển thị nút "Xóa hình"
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('preview');
            const removeBtn = document.getElementById('remove-btn');

            input.value = ''; // Xóa giá trị của input
            preview.src = '#'; // Đặt lại src của ảnh xem trước
            preview.style.display = 'none'; // Ẩn ảnh xem trước
            removeBtn.style.display = 'none'; // Ẩn nút "Xóa hình"
        }
    </script>
@endsection
