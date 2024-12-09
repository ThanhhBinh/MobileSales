@extends('layouts.admin')
@section('title', 'Cập nhập sản phẩm')
@section('content')
    <form id="productForm" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm mới sản phẩm</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="button" name="store" class="btn btn-primary" id="saveButton">
                            <i class="far fa-save"></i>
                            Lưu
                        </button>

                        <button type="button" name="saveAndEdit" value="1" class="btn btn-primary ml-2"
                            id="saveAndEdit">
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
        <section class="content" style="padding: 15px;">
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
                                <input type="text" value="{{ old('name') }}" name="name" id="name"
                                    placeholder="Tên sản phẩm" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tồn kho :</label>
                            <div class="col-md-9">
                                <input type="number" value="{{ old('stock') }}" name="stock"
                                    placeholder="Số lượng tồn kho" id="stock" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Xếp hạng :</label>
                            <div class="col-md-9">
                                <input type="number" value="{{ old('rating') }}" name="rating" id="rating"
                                    class="form-control" disabled
                                    placeholder="Xếp hạng chỉ có người được đánh giá và mặc định là 5">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Mô tả :</label>
                            <div class="col-md-9">
                                <textarea name="description" value="{{ old('description') }}" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Danh mục :</label>
                            <div class="col-md-9">
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="0"> -- None --</option>
                                    {!! $htmlcategoryid !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Thương hiệu :</label>
                            <div class="col-md-9">
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option value="0"> -- None --</option>
                                    {!! $htmlbrandid !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-3 col-form-label text-right">Trạng thái:</label>
                            <div class="col-md-9">
                                <select name="status" id="status" class="form-control">
                                    <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Chưa xuất bản
                                    </option>
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Xuất bản</option>
                                </select>
                            </div>
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
                                <!-- Body của form tìm kiếm -->
                                <div class="card-body">
                                    <div class="form-group row" id="product-price-area">
                                        <label class="col-md-3 col-form-label text-right" for="price">Giá</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="price" name="price"
                                                value="{{ old('price') }}" data-val="true"
                                                data-val-number="Trường Giá phải là một số."
                                                data-val-required="Trường giá là bắt buộc." step="0.01" min="0"
                                                placeholder="Giá sản phẩm">
                                            <span class="field-validation-valid" data-valmsg-for="price"
                                                data-valmsg-replace="true"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row advanced-setting">
                                        <label class="col-md-3 col-form-label text-right" for="discount">Giảm
                                            giá</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="discount" name="discount"
                                                value="{{ old('discount') }}" data-val="true"
                                                data-val-number="Trường Giảm giá phải là một số."
                                                data-val-required="Trường giảm giá là bắt buộc." step="0.01"
                                                min="0" placeholder="Giá giảm">
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
                                            <input type="text" value="{{ old('weight') }}" name="weight"
                                                id="weight" class="form-control" style="width:200px"
                                                placeholder="Cân nặng">
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
                                            <input type="text" value="{{ old('length') }}" name="length"
                                                id="length" class="form-control" style="width:200px"
                                                placeholder="Chiều dài">
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
                                            <input type="text" value="{{ old('width') }}" name="width"
                                                id="width" class="form-control" style="width:200px"
                                                placeholder="Chiều rộng">
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
                                            <input type="text" value="{{ old('height') }}" name="height"
                                                id="height" class="form-control" style="width:200px"
                                                placeholder="Chiều cao">
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
                                            {{ old('free_shipping') ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Vận chuyển riêng biệt :</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        <input type="checkbox" name="free_shipping" id="free_shipping" value="1"
                                            {{ old('free_shipping') ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Phí vận chuyển bổ sung :</label>
                                    <div class="col-md-9">
                                        <input type="text" value="{{ old('additional_shipping_charge') }}"
                                            name="additional_shipping_charge" id="additional_shipping_charge"
                                            class="form-control" style="width:200px"
                                            placeholder="Phí vận chuyển bổ sung">
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
                                            <option value="" {{ old('delivery_date') == '' ? 'selected' : '' }}>
                                                None</option>
                                            <option value="1-3" {{ old('delivery_date') == '1-3' ? 'selected' : '' }}>
                                                Từ 1 đến 3 ngày</option>
                                            <option value="3-5" {{ old('delivery_date') == '3-5' ? 'selected' : '' }}>
                                                Từ 3 đến 5 ngày</option>
                                            <option value="1-week"
                                                {{ old('delivery_date') == '1-week' ? 'selected' : '' }}>
                                                1 tuần</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                <p style="line-height: 40px; margin-top: 20px; margin-left: 20px;">Bạn cần lưu sản phẩm
                                    trước khi có thể tải hình ảnh hoặc video lên trang sản phẩm này.</p>
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
                        <div class="card-body">
                            <div id="productmultimedia-edit"
                                class="card card-primary card-outline card-outline-tabs nav-tabs-custom">
                                <p style="line-height: 40px; margin-top: 20px; margin-left: 20px;">Bạn cần lưu sản phẩm
                                    trước khi có thể tải sản phẩm liên quan lên trang sản phẩm này.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </form>
    <!-- Include TinyMCE library -->
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
    <!-- Initialize TinyMCE on the textarea -->

@endsection
