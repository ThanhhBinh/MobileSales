@extends('layouts.admin')
@section('title', 'Banner')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật banner</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col text-right">
                        <a class="btn btn-danger" href="{{ route('admin.banner.trash') }}">
                            <i class="fas fa-trash"></i> Thùng rác
                        </a>
                        <a class="btn btn-info" href="{{ route('admin.banner.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.banner.update', ['id' => $banner->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name">Tên banner</label>
                        <input type="text" value="{{ old('name', $banner->name) }}" name="name" id="name"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="link">Liên kết</label>
                        <input type="text" value="{{ old('link', $banner->link) }}" name="link" id="link"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="position">Vị trí</label>
                        <input type="text" value="{{ old('position', $banner->position) }}" name="position" id="position"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description', $banner->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image">Hình</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if ($banner->image)
                            <img src="{{ asset('images/banners/' . $banner->image) }}" alt="{{ $banner->name }}"
                                class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                            <option value="2" {{ old('status', $banner->status) == 2 ? 'selected' : '' }}>Chưa xuất bản
                            </option>
                            <option value="1" {{ old('status', $banner->status) == 1 ? 'selected' : '' }}>Xuất bản
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Cập nhật banner</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
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
@endsection
