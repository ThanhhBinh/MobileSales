@extends('layouts.admin')
@section('title','Thêm chủ đề mới')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm chủ đề mới</h1>
            </div>
            <div class="col-12 text-right">
                <a class="btn btn-info" href="{{ route('admin.topic.index')}}">
                    <i class="fa fa-arrow-left"></i> Về danh sách
                </a>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.topic.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name">Tên chủ đề</label>
                    <input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="sort_order">Thứ tự hiển thị</label>
                    <input type="number" value="{{ old('sort_order') }}" name="sort_order" id="sort_order" class="form-control">
                    @error('sort_order')
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
                <div class="mb-3">
                    <label for="status">Trạng thái</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Xuất bản</option>
                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Tạo chủ đề</button>
                </div>
            </form>
        </div>
    </div>
</section>
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
