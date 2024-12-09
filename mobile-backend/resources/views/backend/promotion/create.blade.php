@extends('layouts.admin')
@section('title', 'Thêm giảm giá')
@section('content')

    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Thêm giảm giá mới</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a class="btn btn-info" href="{{ route('admin.promotion.index') }}">
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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                                                <div class="card-header with-border clearfix">

                                                    <div class="card-title">
                                                        <i class="fas fa-info"></i>
                                                        Thông tin giảm giá
                                                    </div>
                                                    <div class="card-tools float-right">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse">
                                                            <i class="fa toggle-icon fa-minus"></i> </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="display: block;">
                                                    <div class="row">
                                                        <form action="{{ route('admin.promotion.store') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="name">Tên giảm giá</label>
                                                                <input type="text" value="{{ old('name') }}"
                                                                    name="name" id="name" class="form-control">
                                                                @error('name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="discount_type">Loại giảm giá</label>
                                                                <select class="form-control" id="discount_type" name="discount_type">
                                                                    <option value="">Chọn loại giảm giá</option>
                                                                    @foreach (\App\Models\Promotion::getDiscountTypes() as $key => $value)
                                                                        <option value="{{ $key }}" {{ old('discount_type') == $key ? 'selected' : '' }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('discount_type')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="discount_amount">Giá trị giảm giá</label>
                                                                <input type="number" value="{{ old('discount_amount') }}"
                                                                    name="discount_amount" id="discount_amount"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="requires_coupon">Mã giảm giá</label>
                                                                <input type="text" value="{{ old('requires_coupon') }}"
                                                                    name="requires_coupon" id="requires_coupon"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="discount_limit">Giới hạn áp dụng giảm
                                                                    giá</label>
                                                                <select class="form-control" id="discount_limit"
                                                                    name="discount_limit"
                                                                    onchange="toggleLimitInput(this.value)">
                                                                    @foreach (\App\Models\Promotion::discount_limit() as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ old('discount_limit') == $key ? 'selected' : '' }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('discount_limit')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-3" id="limit-input-container"
                                                                style="display: none;">
                                                                <label for="discount_limit_value">Số lần áp dụng (N)</label>
                                                                <input type="number" id="discount_limit_value"
                                                                    name="discount_limit_value" class="form-control"
                                                                    value="{{ old('discount_limit_value') }}"
                                                                    min="1">
                                                                @error('discount_limit_value')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="start_date">Thời gian bắt đầu</label>
                                                                <input type="date" value="{{ old('start_date') }}"
                                                                    name="start_date" id="start_date"
                                                                    class="form-control" />
                                                                @error('start_date')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="end_date">Thời gian kết thúc</label>
                                                                <input type="date" value="{{ old('end_date') }}"
                                                                    name="end_date" id="end_date"
                                                                    class="form-control" />
                                                                @error('end_date')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="is_active">Trạng thái</label>
                                                                <select name="is_active" id="is_active"
                                                                    class="form-control">
                                                                    <option selected value="2">Chưa xuất bản</option>
                                                                    <option value="1">Xuất bản</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 text-center">
                                                                <button type="submit" name="create"
                                                                    class="btn btn-success">Thêm giảm giá</button>
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
    <script>
        function toggleLimitInput(selectedValue) {
            const limitInputContainer = document.getElementById('limit-input-container');
            // Kiểm tra giá trị được chọn và hiển thị/ẩn ô nhập
            if (selectedValue === '1' || selectedValue === '2') {
                limitInputContainer.style.display = 'block'; // Hiển thị ô nhập
            } else {
                limitInputContainer.style.display = 'none'; // Ẩn ô nhập
                document.getElementById('discount_limit_value').value = ''; // Xóa giá trị N khi không cần thiết
            }
        }

        // Tự động kiểm tra giá trị khi trang load (trong trường hợp có giá trị cũ từ old())
        document.addEventListener('DOMContentLoaded', function() {
            const selectedValue = document.getElementById('discount_limit').value;
            toggleLimitInput(selectedValue);
        });
    </script>
@endsection
