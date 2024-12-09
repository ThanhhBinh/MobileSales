@extends('layouts.admin')
@section('title', 'Khuyến mãi')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật khuyến mãi</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-12 text-right">
                        <form action="{{ route('admin.promotion.destroy', $promotion->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger" name="delete" type="submit">
                                <i class="fas fa-trash"></i>
                                Xóa
                            </button>
                        </form>
                        <a class="btn btn-info ml-2" href="{{ route('admin.promotion.index') }}">
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
                <form action="{{ route('admin.promotion.update', ['id' => $promotion->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="name">Tên giảm giá</label>
                        <input type="text" value="{{ old('name', $promotion->name) }}" name="name" id="name"
                            class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="discount_type">Loại giảm giá</label>
                        <select class="form-control" id="discount_type" name="discount_type">
                            <option value="">Chọn loại giảm giá</option>
                            @foreach (\App\Models\Promotion::getDiscountTypes() as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('discount_type', $promotion->discount_type) == $key ? 'selected' : '' }}>
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
                        <input type="number" value="{{ old('discount_amount', $promotion->discount_amount) }}"
                            name="discount_amount" id="discount_amount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="requires_coupon">Mã giảm giá</label>
                        <input type="text" value="{{ old('requires_coupon', $promotion->requires_coupon) }}"
                            name="requires_coupon" id="	requires_coupon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="discount_limit">Giới hạn áp dụng giảm giá</label>
                        <select class="form-control" id="discount_limit" name="discount_limit"
                            onchange="toggleLimitInput(this.value)">
                            @foreach (\App\Models\Promotion::discount_limit() as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('discount_limit', $promotion->discount_limit) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('discount_limit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3" id="limit-input-container"
                        style="{{ old('discount_limit', $promotion->discount_limit) == '1' ? 'display:block;' : 'display:none;' }}">
                        <label for="discount_limit_value">Số lần áp dụng (N)</label>
                        <input type="number" id="discount_limit_value" name="discount_limit_value" class="form-control"
                            value="{{ old('discount_limit_value', $promotion->discount_limit_value) }}" min="1">
                        @error('discount_limit_value')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_date">Thời gian bắt đầu</label>
                        <input type="date" value="{{ old('start_date', $promotion->start_date) }}" name="start_date"
                            id="start_date" class="form-control">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_date">Thời gian kết thúc</label>
                        <input type="date" value="{{ old('end_date', $promotion->end_date) }}" name="end_date"
                            id="end_date" class="form-control">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="is_active">Trạng thái</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $promotion->is_active) == 1 ? 'selected' : '' }}>
                                Xuất bản</option>
                            <option value="2" {{ old('is_active', $promotion->is_active) == 2 ? 'selected' : '' }}>
                                Chưa xuất bản</option>
                        </select>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" name="create" class="btn btn-success">Cập nhật khuyến mãi</button>
                    </div>
                </form>
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
