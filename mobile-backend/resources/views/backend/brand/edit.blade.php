@extends('layouts.admin')
@section('title', 'Cập nhật thương hiệu')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cập nhật thương hiệu</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn  btn-danger" href="brand_trash.html">
                    <i class="fas fa-trash"></i> Thùng rác
                </a>
                <a class="btn  btn-info" href="{{ route('admin.brand.index') }}">
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
                <span style="font-size: 24px; margin-left:5px">Thông tin sản phẩm</span>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.brand.update', ['id' => $brand->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name">Tên thương hiệu</label>
                        <input type="text" value="{{ old('name', $brand->name) }}" name="name" id="name"
                            class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea name="description" value="{{ old('description', $brand->description) }}" id="description"
                            class="form-control">{{ old('description', $brand->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sort_order">Sắp xếp</label>
                        <select name="sort_order" id="sort_order" class="form-control">
                            <option selected value="0">None</option>
                            {!! $htmlsortorder !!}
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image">Hình ảnh</label>
                        <input onchange="previewImage(event)" type="file" name="image" id="image"
                            class="form-control">
                        @if ($brand->image)
                            <div class="row">
                                <div class="col-2">

                                    <img id="preview" src="{{ asset('images/brands/' . $brand->image) }}"
                                        alt="{{ $brand->brand_name }}" class="img-thumbnail mt-2" width="100">
                                </div>
                                <div class="col-10 d-flex align-items-center ">
                                    <button type="button" onclick="removeImage()" id="remove-btn"
                                        class="btn btn-danger mt-5">
                                        Xóa hình
                                    </button>
                                </div>
                        @endif
                        @if ($brand->image == null)
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-2">
                                    <img id="preview" src="#" alt="Xem trước ảnh"
                                        style="width: 150px; display: none;" />
                                </div>
                                <div class="col-10 d-flex align-items-center ">
                                    <button type="button" onclick="removeImage()" style="display: none;"
                                        id="remove-btn" class="btn btn-danger mt-5">
                                        Xóa hình
                                    </button>
                                </div>

                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                            <option value="2" {{ old('status', $brand->status) == 2 ? 'selected' : '' }}>Chưa
                                xuất
                                bản</option>
                            <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Xuất
                                bản
                            </option>
                        </select>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" name="create" class="btn btn-success">Cập nhập thương hiệu</button>
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

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Hiện hình ảnh xem trước
                document.getElementById('remove-btn').style.display = 'block'; // Hiện nút xóa
            }
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
