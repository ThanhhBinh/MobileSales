@extends('layouts.admin')
@section('title','Tạo Bài Viết Mới')
@section('content')
<form action="{{ route('admin.post.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tạo Bài Viết Mới</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Lưu
                        </button>
                        <a class="btn btn-info" href="{{ route('admin.post.index')}}">
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
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="title">Tiêu đề</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="detail">Chi tiết</label>
                            <textarea name="detail" id="detail" rows="8" class="form-control">{{ old('detail') }}</textarea>
                            @error('detail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="topic_id">Chủ đề</label>
                            <select name="topic_id" id="topic_id" class="form-control">
                                <option value="">Chọn chủ đề</option>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type">Kiểu</label>
                            <select name="type" id="type" class="form-control">
                                <option value="post" {{ old('type') == 'post' ? 'selected' : '' }}>Bài viết</option>
                                <option value="page" {{ old('type') == 'page' ? 'selected' : '' }}>Trang đơn</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image">Hình</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Xuất bản</option>
                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Chưa xuất bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<script src="https://cdn.tiny.cloud/1/fyqw5r3tchqm35wywjd85ij01v092q71nea4psfi1ar9sai4/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'advlist autolink lists link image charmap preview anchor textcolor',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: 'https://www.tiny.cloud/css/codepen.min.css'
    });
</script>
@endsection
