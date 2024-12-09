@extends('layouts.admin')
@section('title', 'Cập nhập sản phẩm')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật sản phẩm - {{ $product->name }}</h1>
                </div>
                <div class="col-sm-6 text-right">

                    <button type="submit" name="create" class="btn btn-primary" id="saveButton">
                        <i class="far fa-save"></i>
                        Lưu
                    </button>

                    <button type="button" name="saveAndEdit" value="1" class="btn btn-primary ml-2" id="saveAndEdit">
                        <i class="far fa-save"></i> Lưu và tiếp tục chỉnh sửa
                    </button>

                    <!-- Nút quay về danh sách sản phẩm -->
                    <a href="{{ route('admin.product.index') }}" class="btn btn-info ml-2">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="content" style="padding: 15px">
        <form action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="post"
            enctype="multipart/form-data" class="d-inline-block" id="productForm">
            @csrf
            @method('PUT')
            <div class="card card-body">

                {{-- Thông báo thành công --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Thông báo thất bại --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- Thông tin sản phẩm --}}
                <div class="row">
                    <div class="col-12 border-bottom pb-2 mb-3">
                        <i style="p-size: 20px" class="fas fa-info"></i>
                        <span style="p-size: 24px; margin-left:5px">Thông tin sản phẩm</span>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tên sản phẩm :</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('name', $product->name) }}" name="name"
                                    id="name" class="form-control">
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tồn kho :</label>
                            <div class="col-md-9">
                                <input type="number" value="{{ old('stock', $product->stock) }}" name="stock"
                                    id="stock" class="form-control">
                            </div>
                            @error('stock')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Xếp hạng :</label>
                            <div class="col-md-9">
                                <input type="number" value="{{ old('rating', $product->rating) }}" name="rating"
                                    id="rating" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Mô tả :</label>
                            <div class="col-md-9">
                                <textarea name="description" value="{{ old('description', $product->description) }}" id="description"
                                    class="form-control">{{ old('description', $product->description) }}</textarea>
                            </div>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Danh mục :</label>
                            <div class="col-md-9">
                                <select name="category_id" class="form-control" id="category">
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Thương hiệu :</label>
                            <div class="col-md-9">
                                <select name="brand_id" class="form-control" id="brand">
                                    <option value="">Chọn thương hiệu</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('brand_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-3 col-form-label text-right">Trạng thái:</label>
                            <div class="col-md-9">
                                <select name="status" id="status" class="form-control">
                                    <option value="2" {{ old('status', $product->status) == 2 ? 'selected' : '' }}>
                                        Chưa
                                        xuất
                                        bản</option>
                                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                        Xuất
                                        bản
                                    </option>
                                </select>
                            </div>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- Giá cả --}}
            <div class="row ">
                <div class="col-md-12">
                    <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                        <div class="card-header with-border clearfix">

                            <div class="card-title">
                                <i class="fas fa-dollar-sign mr-2"></i>
                                Giá cả
                            </div>
                            <div class="card-tools float-right">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa toggle-icon fa-minus"></i> </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="card-body">
                                    <div class="form-group row" id="product-price-area">
                                        <label class="col-md-3 col-form-label text-right" for="price">Giá</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="price" name="price"
                                                value="{{ $product->price }}" data-val="true"
                                                data-val-number="Trường Giá phải là một số."
                                                data-val-required="Trường giá là bắt buộc." step="0.01"
                                                min="0" placeholder="giá">
                                        </div>
                                    </div>

                                    <div class="form-group row advanced-setting">
                                        <label class="col-md-3 col-form-label text-right" for="discount">Giảm
                                            giá</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="discount"
                                                name="discount"
                                                value="{{ number_format($product->discount, 0, ',', '.') }}"
                                                data-val="true" data-val-number="Trường Giảm giá phải là một số."
                                                data-val-required="Trường giảm giá là bắt buộc." step="0.01"
                                                min="0">
                                            <span class="field-validation-valid" data-valmsg-for="discount"
                                                data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vận chuyển --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                        <div class="card-header with-border clearfix">
                            <div class="card-title">
                                <i class="fas fa-truck mr-2"></i>
                                Vận chuyển
                            </div>
                            <div class="card-tools float-right">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa toggle-icon fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="search-body mt-3">
                            <div class="row">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Cân nặng :</label>
                                    <div class="col-md-9">
                                        <div style="display: flex; align-items: center;">
                                            <input type="text" value="{{ old('weight', $shipping->weight ?? '') }}"
                                                name="weight" id="weight" class="form-control" style="width:200px">
                                            <span style="margin-left: 8px;">gam</span> <!-- Chữ nằm bên phải -->
                                        </div>
                                    </div>
                                    @error('weight')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Chiều dài :</label>
                                    <div class="col-md-9">
                                        <div style="display: flex; align-items: center;">
                                            <input type="text" value="{{ old('length', $shipping->length ?? '') }}"
                                                name="length" id="length" class="form-control" style="width:200px">
                                            <span style="margin-left: 8px;">cm</span> <!-- Chữ nằm bên phải -->
                                        </div>
                                    </div>
                                    @error('length')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Chiều rộng :</label>
                                    <div class="col-md-9">
                                        <div style="display: flex; align-items: center;">
                                            <input type="text" value="{{ old('width', $shipping->width ?? '') }}"
                                                name="width" id="width" class="form-control" style="width:200px">
                                            <span style="margin-left: 8px;">cm</span> <!-- Chữ nằm bên phải -->
                                        </div>
                                    </div>
                                    @error('width')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Chiều cao :</label>
                                    <div class="col-md-9">
                                        <div style="display: flex; align-items: center;">
                                            <input type="text" value="{{ old('height', $shipping->height ?? '') }}"
                                                name="height" id="height" class="form-control" style="width:200px">
                                            <span style="margin-left: 8px;">cm</span> <!-- Chữ nằm bên phải -->
                                        </div>
                                    </div>
                                    @error('height')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Miễn phí vận chuyển :</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        <input type="checkbox" name="free_shipping" id="free_shipping" value="1"
                                            {{ old('free_shipping', $shipping->free_shipping ?? 0) ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Vận chuyển riêng biệt :</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        <input type="checkbox" name="free_shipping" id="free_shipping" value="1"
                                            {{ old('free_shipping', $shipping->ship_separately ?? 0) ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Phí vận chuyển bổ sung :</label>
                                    <div class="col-md-9">
                                        <input type="text"
                                            value="{{ old('additional_shipping_charge', $shipping->additional_shipping_charge ?? '') }}"
                                            name="additional_shipping_charge" id="additional_shipping_charge"
                                            class="form-control" style="width:200px">
                                    </div>
                                    @error('additional_shipping_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Ngày giao hàng :</label>
                                    <div class="col-md-9">
                                        <select name="delivery_date" id="delivery_date" class="form-control"
                                            style="width:200px">
                                            <option value=""
                                                {{ old('delivery_date', $shipping->delivery_date ?? '') == '' ? 'selected' : '' }}>
                                                None</option>
                                            <option value="1-3"
                                                {{ old('delivery_date', $shipping->delivery_date ?? '') == '1-3' ? 'selected' : '' }}>
                                                Từ 1 đến 3 ngày</option>
                                            <option value="3-5"
                                                {{ old('delivery_date', $shipping->delivery_date ?? '') == '3-5' ? 'selected' : '' }}>
                                                Từ 3 đến 5 ngày</option>
                                            <option value="1-week"
                                                {{ old('delivery_date', $shipping->delivery_date ?? '') == '1-week' ? 'selected' : '' }}>
                                                1 tuần</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- Đa phương tiện --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                    <div class="card-header with-border clearfix">
                        <div class="card-title">
                            <i class="fas fa-photo-video mr-2"></i>
                            Đa phương tiện
                        </div>
                        <div class="card-tools float-right">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa toggle-icon fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="productmultimedia-edit"
                            class="card card-primary card-outline card-outline-tabs nav-tabs-custom">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                    <li class="nav-item"><a aria-selected="true" class="nav-link active"
                                            data-tab-name="tab-pictures" data-toggle="pill" href="#tab-pictures"
                                            role="tab">Hình ảnh</a></li>
                                    <li class="nav-item"><a aria-selected="false" class="nav-link"
                                            data-tab-name="tab-videos" data-toggle="pill" href="#tab-videos"
                                            role="tab">Videos</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade{0} active" id="tab-pictures" role="tabpanel">
                                        <div class="card-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="dataTables_wrapper dt-bootstrap4 no-footer"
                                                id="productpictures-grid_wrapper">
                                                <div class="dataTables_scroll">
                                                    <div class="dataTables_scrollBody">
                                                        <table
                                                            class="table table-bordered table-hover table-striped dataTable"
                                                            id="productpictures-grid">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:150px">Hình ảnh</th>
                                                                    <th class="text-center">Thứ tự hiển thị</th>
                                                                    <th>Alt</th>
                                                                    <th>Tiêu đề</th>
                                                                    <th style="width:150px">Chỉnh sửa</th>
                                                                    <th style="width:100px">Xóa</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($mediaItems as $item): ?>
                                                                <?php if ($item->media_type === 'image' && $item->product_id === $product->id): ?>
                                                                <tr id="media-<?= $item->id ?>">
                                                                    <td>
                                                                        <img src="{{ asset('storage/' . $item->media_url) }}"
                                                                            width="150"
                                                                            alt="Image {{ $item->id }}">

                                                                    </td>
                                                                    <td id="display-order-<?= $item->id ?>"
                                                                        data-original="<?= $item->display_order ?>">
                                                                        <?= $item->display_order ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $item->product_name ?>
                                                                    </td>
                                                                    <td id="media-type-<?= $item->id ?>"
                                                                        data-original="<?= $item->media_type ?>">
                                                                        <?= $item->media_type ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="#" class="btn btn-default edit-btn"
                                                                            onclick="editMedia(<?= $item->id ?>); return false;">
                                                                            <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-default update-btn"
                                                                            style="display: none;"
                                                                            onclick="updateMedia(<?= $item->id ?>); return false;">
                                                                            <i class="fas fa-save"></i> Cập nhật
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-default cancel-btn mt-2"
                                                                            style="display: none;"
                                                                            onclick="cancelEdit(<?= $item->id ?>); return false;">
                                                                            <i class="fas fa-times"></i> Hủy bỏ
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="btn btn-default"
                                                                            onclick="deleteMedia(<?= $item->id ?>); return false;">
                                                                            <i class="far fa-trash-alt"></i> Xóa
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php endif; ?>
                                                                <!-- Kết thúc điều kiện kiểm tra media_type -->
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-default mt-3">
                                                <div class="card-header">Thêm hình ảnh mới</div>
                                                <div class="card-body">
                                                    <form id="addImageForm" action="{{ route('admin.media.store') }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label" for="pictureUpload">
                                                                Hình ảnh
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="hidden" id="pictureUpload"
                                                                    name="AddPictureModel.PictureId" value="0"
                                                                    required>
                                                                <div class="upload-picture-block">
                                                                    <div class="qq-uploader">
                                                                        <div class="qq-upload-drop-area"
                                                                            style="display: none;">
                                                                            <span>Thả tập tin vào đây để tải lên</span>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="qq-upload-button btn bg-gradient-green">Tải
                                                                            ảnh lên</button>
                                                                        <input type="file" multiple id="imageFiles"
                                                                            name="media_url[]"
                                                                            style="opacity: 0; position: absolute;"
                                                                            required>
                                                                        <span class="qq-drop-processing qq-hide">Đang
                                                                            xử lý
                                                                            các tập tin đã tải lên...</span>
                                                                        <ul class="qq-upload-list"></ul>
                                                                    </div>
                                                                </div>
                                                                <span class="field-validation-valid"
                                                                    data-valmsg-for="AddPictureModel.PictureId"></span>
                                                            </div>
                                                        </div>

                                                        <!-- Hidden input for product ID -->
                                                        <input type="hidden" id="productId" name="product_id"
                                                            value="{{ $product->id }}" required>

                                                        <!-- Submit button -->
                                                        <div class="form-group row">
                                                            <div class="col-md-9 offset-md-3">
                                                                <button type="submit" class="btn btn-primary">Thêm
                                                                    hình
                                                                    ảnh</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade{0}" id="tab-videos" role="tabpanel">
                                        <div class="card-body">
                                            <div id="productvideos-grid_wrapper"
                                                class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="dataTables_scroll">
                                                            <div class="dataTables_scrollBody"
                                                                style="overflow: auto; width: 100%;">
                                                                <table
                                                                    class="table table-bordered table-hover table-striped dataTable"
                                                                    width="100%" id="productvideos-grid">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Xem trước</th>
                                                                            <th>Nhúng URL video</th>
                                                                            <th class="text-center">Thứ tự hiển thị
                                                                            </th>
                                                                            <th>Chỉnh sửa</th>
                                                                            <th>Xóa</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="video-list">
                                                                        <?php foreach ($mediaItems as $item): ?>
                                                                        <?php if ($item->media_type === 'video' && $item->product_id === $product->id): ?>
                                                                        <tr id="media-<?= $item->id ?>">
                                                                            <td>
                                                                                <video width="150" height="100"
                                                                                    controls>
                                                                                    <source
                                                                                        src="<?= asset($item->media_url) ?>"
                                                                                        type="video/mp4">
                                                                                    Trình duyệt của bạn không hỗ trợ
                                                                                    video.
                                                                                </video>
                                                                            </td>
                                                                            <td id="media-url-<?= $item->id ?>"
                                                                                data-original="<?= $item->media_url ?>">
                                                                                <?= $item->media_url ?></td>
                                                                            <td class="text-center"
                                                                                id="display-order-<?= $item->id ?>"
                                                                                data-original="<?= $item->display_order ?>">
                                                                                <?= $item->display_order ?></td>
                                                                            <td>
                                                                                <button class="btn btn-default edit-btn"
                                                                                    onclick="editVideo(<?= $item->id ?>); return false;">
                                                                                    <i class="fas fa-pencil-alt"></i>
                                                                                    Chỉnh
                                                                                    sửa
                                                                                </button>
                                                                                <button class="btn btn-default update-btn"
                                                                                    style="display:none;"
                                                                                    onclick="updateVideo(<?= $item->id ?>); return false;">
                                                                                    <i class="fas fa-save"></i> Cập
                                                                                    nhật
                                                                                </button>
                                                                                <button class="btn btn-default cancel-btn"
                                                                                    style="display:none;"
                                                                                    onclick="cancelEditVideo(<?= $item->id ?>); return false;">
                                                                                    <i class="fas fa-times"></i> Hủy
                                                                                </button>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-default"
                                                                                    onclick="deleteVideo(<?= $item->id ?>); return false;">
                                                                                    <i class="far fa-trash-alt"></i>
                                                                                    Xóa
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-default">
                                                <div class="card-header">Thêm một video mới</div>
                                                <div class="card-body">
                                                    <form id="addVideoForm" enctype="multipart/form-data">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label"
                                                                for="AddVideoModel_VideoUrl">Nhúng URL video</label>
                                                            <div class="col-md-9">
                                                                <input class="form-control" id="AddVideoModel_VideoUrl"
                                                                    name="AddVideoModel.VideoUrl" type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label"
                                                                for="AddVideoModel_DisplayOrder">Thứ tự hiển
                                                                thị</label>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control"
                                                                    id="AddVideoModel_DisplayOrder"
                                                                    name="AddVideoModel.DisplayOrder" value="0"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-9 offset-md-3">
                                                                <button type="submit" id="addProductVideo"
                                                                    class="btn btn-primary">Thêm video sản
                                                                    phẩm</button>
                                                            </div>
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
            </div>
        </div>

        {{-- Sản phẩm liên quan --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                    <div class="card-header with-border clearfix">
                        <div class="card-title">
                            <i class="fas fa-object-group mr-2"></i>
                            Sản phẩm liên quan
                        </div>
                        <div class="card-tools float-right">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa toggle-icon fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($relateproduct->isEmpty())
                                    <div class="alert alert-info">
                                        Không có sản phẩm nào để hiển thị.
                                    </div>
                                @else
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Sản phẩm</th>
                                                <th class="text-center" style="width:150px">Giá</th>
                                                <th class="text-center" style="width:150px">Xem</th>
                                                <th class="text-center" style="width:150px">Chỉnh sửa</th>
                                                <th class="text-center" style="width:150px">Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($relateproduct as $row)
                                                <tr>
                                                    <td>{!! $row->productname !!}</td>
                                                    <td class="text-center">
                                                        {{ number_format($row->productprice, 0, ',', '.') }}₫</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.product.edit', ['id' => $row->related_id]) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Xem
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.product.edit', ['id' => $row->product_id]) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Chỉnh sửa
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.product.delete_related_product', ['id' => $row->id]) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm liên quan này?');">
                                                            <i class="fas fa-trash"></i> Xóa
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- Phân trang --}}
                                    <div class="row margin-t-5 justify-content-center">
                                        <div class="col-lg-5 col-xs-12">
                                            <div class="float-lg-left">
                                                <div class="dataTables_paginate paging_simple_numbers"
                                                    id="list-grid_paginate">
                                                    <ul class="pagination">
                                                        {{-- Previous Button --}}
                                                        <li class="paginate_button page-item {{ $relateproduct->onFirstPage() ? 'disabled' : '' }}"
                                                            id="list-grid_previous">
                                                            <a href="{{ $relateproduct->previousPageUrl() }}"
                                                                aria-controls="list-grid" class="page-link">Trước</a>
                                                        </li>

                                                        {{-- Pagination Links --}}
                                                        @for ($i = 1; $i <= $relateproduct->lastPage(); $i++)
                                                            <li
                                                                class="paginate_button page-item {{ $i == $relateproduct->currentPage() ? 'active' : '' }}">
                                                                <a href="{{ $relateproduct->url($i) }}"
                                                                    class="page-link">{{ $i }}</a>
                                                            </li>
                                                        @endfor

                                                        {{-- Next Button --}}
                                                        <li class="paginate_button page-item {{ $relateproduct->hasMorePages() ? '' : 'disabled' }}"
                                                            id="list-grid_next">
                                                            <a href="{{ $relateproduct->nextPageUrl() }}"
                                                                aria-controls="list-grid" class="page-link">Kế
                                                                tiếp</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Số lượng sản phẩm --}}
                                        <div class="col-lg-3 col-xs-12 mt-3">
                                            <form method="GET" action="{{ route('admin.product.index') }}"
                                                class="form-horizontal">
                                                <div class="text-center d-flex align-items-center">
                                                    <div class="dataTables_length" id="list-grid_length">
                                                        <label>Số lượng
                                                            <select style="width:62px" name="items_per_page"
                                                                onchange="this.form.submit()"
                                                                class="custom-select custom-select-sm form-control form-control-sm">
                                                                <option value="7"
                                                                    {{ $relateproduct->perPage() == 7 ? 'selected' : '' }}>
                                                                    7</option>
                                                                <option value="15"
                                                                    {{ $relateproduct->perPage() == 15 ? 'selected' : '' }}>
                                                                    15</option>
                                                                <option value="20"
                                                                    {{ $relateproduct->perPage() == 20 ? 'selected' : '' }}>
                                                                    20</option>
                                                                <option value="50"
                                                                    {{ $relateproduct->perPage() == 50 ? 'selected' : '' }}>
                                                                    50</option>
                                                                <option value="100"
                                                                    {{ $relateproduct->perPage() == 100 ? 'selected' : '' }}>
                                                                    100</option>
                                                            </select> Sản phẩm
                                                        </label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- Thông tin phân trang --}}
                                        <div class="col-lg-3 col-xs-12 mt-3">
                                            <div class="float-lg-right text-center">
                                                <div class="dataTables_info" id="list-grid_info" role="status"
                                                    aria-live="polite">
                                                    {{ $relateproduct->firstItem() }} đến
                                                    {{ $relateproduct->lastItem() }}
                                                    của {{ $relateproduct->total() }} sản phẩm
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Nút làm mới --}}
                                        <div class="col-lg-1 col-xs-12 mt-2">
                                            <div class="float-lg-right text-center data-tables-refresh">
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary" onclick="window.location.reload()"
                                                        type="button">
                                                        <span><i class="fas fa-sync-alt"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary"
                            href="{{ route('admin.product.create_related_product', ['id' => $product->id]) }}">
                            <i class="fas fa-plus-square"></i> Thêm sản phẩm liên quan mới
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Include TinyMCE library -->
    <script src="https://cdn.tiny.cloud/1/fyqw5r3tchqm35wywjd85ij01v092q71nea4psfi1ar9sai4/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        document.getElementById('saveButton').addEventListener('click', function() {
            document.getElementById('productForm').submit();
        });
        document.getElementById('saveAndEdit').addEventListener('click', function() {
            // Thêm một input ẩn vào form để biết đây là "Lưu và tiếp tục chỉnh sửa"
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'saveAndEdit'; // Tham số này sẽ giúp server phân biệt hành động
            input.value = '1'; // Dấu hiệu là "Lưu và tiếp tục chỉnh sửa"
            document.getElementById('productForm').appendChild(input);
            document.getElementById('productForm').submit();
        });
    </script>
    <script>
        //edit hình ảnh
        function editMedia(id) {
            const displayOrderCell = document.getElementById(`display-order-${id}`);
            const mediaTypeCell = document.getElementById(`media-type-${id}`);
            const editButton = document.querySelector(`#media-${id} .edit-btn`);
            const updateButton = document.querySelector(`#media-${id} .update-btn`);
            const cancelButton = document.querySelector(`#media-${id} .cancel-btn`);

            displayOrderCell.innerHTML =
                `<input type="number" value="${displayOrderCell.innerText}" class="form-control" />`;
            mediaTypeCell.innerHTML = `<input type="text" value="${mediaTypeCell.innerText}" class="form-control" />`;

            editButton.style.display = 'none';
            updateButton.style.display = 'inline-block';
            cancelButton.style.display = 'inline-block';
        }

        //Cập nhật ảnh
        function updateMedia(id) {
            const displayOrder = document.querySelector(`#media-${id} input[type='number']`).value;
            const mediaType = document.querySelector(`#media-${id} input[type='text']`).value;

            fetch(`/admin/media/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        display_order: displayOrder,
                        media_type: mediaType,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        alert("Cập nhật thành công");
                        document.getElementById(`display-order-${id}`).innerText = displayOrder;
                        document.getElementById(`media-type-${id}`).innerText = mediaType;

                        document.querySelector(`#media-${id} .edit-btn`).style.display = 'inline-block';
                        document.querySelector(`#media-${id} .update-btn`).style.display = 'none';
                        document.querySelector(`#media-${id} .cancel-btn`).style.display = 'none';
                    } else {
                        alert('Cập nhật thất bại!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi khi cập nhật.');
                });
        }

        //Xóa hình ảnh
        function deleteMedia(mediaId) {
            if (confirm('Bạn có chắc chắn muốn xóa media này không?')) {
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (!csrfTokenMeta) {
                    console.error('CSRF token meta tag not found.');
                    return;
                }

                fetch(`/admin/media/destroy/${mediaId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content'),
                            'Content-Type': 'application/json', // Thêm header nếu cần thiết
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const mediaRow = document.getElementById(`media-${mediaId}`);
                            if (mediaRow) {
                                alert('Xóa ảnh thành công')
                                mediaRow.remove();
                            } else {
                                console.error(`Media row with ID media-${mediaId} not found.`);
                            }
                        } else {
                            alert('Có lỗi xảy ra khi xóa!');
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            }
        }

        //Hủy bỏ chỉnh sửa
        function cancelEdit(id) {
            const displayOrderCell = document.getElementById(`display-order-${id}`);
            const mediaTypeCell = document.getElementById(`media-type-${id}`);

            displayOrderCell.innerText = displayOrderCell.getAttribute('data-original');
            mediaTypeCell.innerText = mediaTypeCell.getAttribute('data-original');

            document.querySelector(`#media-${id} .edit-btn`).style.display = 'inline-block';
            document.querySelector(`#media-${id} .update-btn`).style.display = 'none';
            document.querySelector(`#media-${id} .cancel-btn`).style.display = 'none';
        }

        //thêm video
        document.getElementById('addVideoForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form
            addVideo(); // Gọi hàm addVideo()
        });

        function addVideo() {
            const videoUrl = document.getElementById('AddVideoModel_VideoUrl').value;
            const displayOrder = document.getElementById('AddVideoModel_DisplayOrder').value;
            const productId = <?= json_encode($product->id) ?>;
            axios.post('/admin/media/addVideo', {
                    video_url: videoUrl,
                    display_order: displayOrder,
                    product_id: productId,
                })
                .then(response => {
                    // Thông báo thành công
                    alert('Video đã được thêm thành công!');

                    // Xóa dữ liệu trong các ô input sau khi thêm thành công
                    document.getElementById('AddVideoModel_VideoUrl').value = '';
                    document.getElementById('AddVideoModel_DisplayOrder').value = 0;
                    location.reload();
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                    alert('Có lỗi xảy ra khi thêm video. Vui lòng thử lại.');
                });
        }

        //sửa video
        function editVideo(id) {
            const displayOrderCell = document.getElementById(`display-order-${id}`);
            const mediaUrlCell = document.getElementById(`media-url-${id}`);
            const editButton = document.querySelector(`#media-${id} .edit-btn`);
            const updateButton = document.querySelector(`#media-${id} .update-btn`);
            const cancelButton = document.querySelector(`#media-${id} .cancel-btn`);

            displayOrderCell.innerHTML =
                `<input type="number" value="${displayOrderCell.innerText}" class="form-control" />`;
            mediaUrlCell.innerHTML = `<input type="text" value="${mediaUrlCell.innerText}" class="form-control" />`;

            editButton.style.display = 'none';
            updateButton.style.display = 'inline-block';
            cancelButton.style.display = 'inline-block';
        }

        //update video
        function updateVideo(id) {
            const displayOrder = document.querySelector(`#media-${id} input[type='number']`).value;
            const mediaUrl = document.querySelector(`#media-${id} input[type='text']`).value;

            fetch(`/admin/media/updatevideo/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        display_order: displayOrder,
                        media_url: mediaUrl,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert("Cập nhật thành công");
                        document.getElementById(`display-order-${id}`).innerText = displayOrder;
                        document.getElementById(`media-url-${id}`).innerText = mediaUrl;

                        document.querySelector(`#media-${id} .edit-btn`).style.display = 'inline-block';
                        document.querySelector(`#media-${id} .update-btn`).style.display = 'none';
                        document.querySelector(`#media-${id} .cancel-btn`).style.display = 'none';
                    } else {
                        alert('Cập nhật thất bại!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    fetch(error.response.url) // Lấy nội dung phản hồi
                        .then(res => res.text())
                        .then(text => console.error('Response body:', text));
                    alert('Đã xảy ra lỗi khi cập nhật.');
                });
        }

        //Xóa video
        function deleteVideo(mediaId) {
            if (confirm('Bạn có chắc chắn muốn xóa video này không?')) {
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

                fetch(`/admin/media/destroy/${mediaId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const mediaRow = document.getElementById(`media-${mediaId}`);
                            if (mediaRow) {
                                alert('Xóa video thành công');
                                mediaRow.remove();
                            } else {
                                console.error(`Media row with ID media-${mediaId} not found.`);
                            }
                        } else {
                            alert('Có lỗi xảy ra khi xóa!');
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            }
        }

        function cancelEditVideo(id) {
            const displayOrderCell = document.getElementById(`display-order-${id}`);
            const mediaUrlCell = document.getElementById(`media-url-${id}`);

            displayOrderCell.innerText = displayOrderCell.getAttribute('data-original');
            mediaUrlCell.innerText = mediaUrlCell.getAttribute('data-original');

            document.querySelector(`#media-${id} .edit-btn`).style.display = 'inline-block';
            document.querySelector(`#media-${id} .update-btn`).style.display = 'none';
            document.querySelector(`#media-${id} .cancel-btn`).style.display = 'none';
        }

        tinymce.init({
            selector: '#description',
            menubar: false,
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            plugins: 'lists',
            height: 300
        });

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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previousButton = document.getElementById('tierprices-grid_previous');
            const nextButton = document.getElementById('tierprices-grid_next');
            const lengthSelect = document.querySelector('select[name="tierprices-grid_length"]');
            const infoDisplay = document.getElementById('tierprices-grid_info');

            // Xử lý sự kiện cho nút "Trước"
            previousButton.addEventListener('click', function(event) {
                event.preventDefault();
                // Logic để điều hướng đến trang trước (nếu có)
                console.log('Đi đến trang trước');
            });

            // Xử lý sự kiện cho nút "Kế tiếp"
            nextButton.addEventListener('click', function(event) {
                event.preventDefault();
                // Logic để điều hướng đến trang tiếp theo (nếu có)
                console.log('Đi đến trang tiếp theo');
            });

            // Xử lý sự kiện cho chọn số lượng mặt hàng
            lengthSelect.addEventListener('change', function() {
                const itemsPerPage = this.value;
                // Logic để cập nhật số lượng mục hiển thị
                console.log('Số lượng mặt hàng hiển thị:', itemsPerPage);
                // Cập nhật thông tin hiển thị
                infoDisplay.innerHTML = `1-${itemsPerPage} trong ${itemsPerPage} mục`;
            });

            // Xử lý sự kiện cho nút làm mới
            document.querySelector('.btn-secondary').addEventListener('click', function() {
                // Logic để làm mới dữ liệu (có thể gọi API ở đây)
                location.reload(); // Tải lại trang
            });
        });

        document.querySelector('.qq-upload-button').addEventListener('click', function() {
            document.getElementById('imageFiles').click();
        });

        document.getElementById('imageFiles').addEventListener('change', function() {
            const files = this.files;
            const uploadList = document.querySelector('.qq-upload-list');
            uploadList.innerHTML = ''; // Xóa danh sách tải lên cũ

            for (let i = 0; i < files.length; i++) {
                const li = document.createElement('li');
                li.textContent = files[i].name; // Hiển thị tên file
                uploadList.appendChild(li);
            }
        });
    </script>
@endsection
