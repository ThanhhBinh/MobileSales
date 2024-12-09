@extends('layouts.admin')
@section('title', 'Chỉnh sửa chủ đề')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa Chủ đề</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-12 text-right">
                        <a class="btn btn-danger" href="{{ route('admin.topic.trash') }}">
                            <i class="fas fa-trash"></i> Thùng rác
                        </a>
                        <a class="btn btn-info" href="{{ route('admin.topic.index') }}">
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
                <form action="{{ route('admin.topic.update', $topic->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name">Tên chủ đề</label>
                        <input type="text" value="{{ old('name', $topic->name) }}" name="name" id="name"
                            class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" value="{{ old('slug', $topic->slug) }}" name="slug" id="slug"
                            class="form-control">
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sort_order">Thứ tự hiển thị</label>
                        <input type="text" value="{{ old('sort_order', $topic->sort_order) }}" name="sort_order" id="sort_order"
                            class="form-control">
                        @error('sort_order')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description', $topic->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status', $topic->status) == 1 ? 'selected' : '' }}>Xuất bản
                            </option>
                            <option value="2" {{ old('status', $topic->status) == 2 ? 'selected' : '' }}>Chưa xuất bản
                            </option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Cập nhật chủ đề</button>
                    </div>
                </form>
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
@endsection
