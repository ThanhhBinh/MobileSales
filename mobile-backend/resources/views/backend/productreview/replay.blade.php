@extends('layouts.admin')
@section('title', 'Trả lời bình luận')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Trả lời bình luận</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn  btn-danger" href="brand_trash.html">
                        <i class="fas fa-trash"></i> Thùng rác
                    </a>
                    <a class="btn  btn-info" href="{{ route('admin.productreview.index') }}">
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
                    <form action="{{ route('admin.productreview.replayid', ['review_id' => $list->review_id]) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <span class="col-md-3 col-form-label text-right" for="product_id"
                                style="font-size: 18px; font-weight:700;">Sản phẩm : </span>
                            <span class="col-md-3 col-form-label text-left" for="product_id" value="product_id"
                                style="font-size: 18px;color:#007bff">{{ $list->productname }} </span>
                        </div>
                        <div class="form-group row">
                            <span class="col-md-3 col-form-label text-right" for="user_id"
                                style="font-size: 18px; font-weight:700;">Khách hàng : </span>
                            <span class="col-md-3 col-form-label text-left" for="user_id" value="user_id"
                                style="font-size: 18px;color:#007bff">{{ $list->username }} </span>
                        </div>
                        <div class="form-group row">
                            <label style="font-size: 18px; font-weight:700;" class="col-md-3 col-form-label text-right"
                                for="title">Tiêu đề:</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('title', $list->title) }}" name="title" id="title"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label style="font-size: 18px; font-weight:700;" class="col-md-3 col-form-label text-right"
                                for="name">Đánh giá sản phẩm:</label>
                            <div class="col-md-9">
                                <textarea name="review_text" value="{{ old('review_text', $list->review_text) }}" id="review_text" class="form-control">{{ old('review_text', $list->review_text) }}</textarea>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label style="font-size: 18px; font-weight:700;" class="col-md-3 col-form-label text-right"
                                for="replay">Trả lời đánh giá:</label>
                            <div class="col-md-9">
                                <textarea name="replay" value="{{ old('replay', $list->replay) }}" id="replay" class="form-control">{{ old('replay', $list->replay) }}</textarea>

                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-md-3 col-form-label text-right" for="rating"
                                style="font-size: 18px; font-weight:700;">Xếp hạng : </span>
                            <span class="col-md-3 col-form-label text-left" for="rating"
                                style="font-size: 18px">{{ $list->rating }} </span>
                        </div>

                        <div class="form-group row">
                            <label style="font-size: 18px; font-weight:700;" class="col-md-3 col-form-label text-right"
                                for="status">Tán thành:</label>
                            <div class="col-md-9">
                                <select name="status" id="status" class="form-control">
                                    <option value="2"
                                        {{ old('review_status', $list->review_status) == 2 ? 'selected' : '' }}>Không chấp
                                        thuận</option>
                                    <option value="1"
                                        {{ old('review_status', $list->review_status) == 1 ? 'selected' : '' }}>Chấp thuận
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label style="font-size: 18px; font-weight:700;" class="col-md-3 col-form-label text-right"
                                for="image">Hình ảnh đánh giá :</label>
                            <div class="col-md-9">
                                <img id="preview" src="{{ asset('images/productreviews/' . $list->image) }}"
                                    alt="{{ $list->productname }}" class="img-thumbnail mt-2" width="100">
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" name="create" class="btn btn-success">Trả lời bình
                                luận</button>
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
