@extends('layouts.admin')
@section('title', 'Cập nhập thanh toán')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật thanh toán - {{ $payment->method_name }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <form action="{{ route('admin.payment.destroy', $payment->payment_method_id) }}" method="post"
                        class="d-inline">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" name="delete" type="submit">
                            <i class="fas fa-trash"></i> Xóa bỏ
                        </button>
                    </form>
                    <a class="btn  btn-info" href="{{ route('admin.payment.index') }}">
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
                    <span style="font-size: 20px; margin-left:5px">Thông tin sản phẩm</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.payment.update', ['id' => $payment->payment_method_id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="method_name">Tên thanh toán</label>
                            <input type="text" value="{{ old('method_name', $payment->method_name) }}" name="method_name"
                                id="method_name" class="form-control">
                            @error('method_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description">Mô tả</label>
                            <textarea name="description" value="{{ old('description', $payment->description) }}" id="description"
                                class="form-control">{{ old('description', $payment->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status">Trạng thái hệ thống</label>
                            <select name="status" id="status" class="form-control">
                                <option value="2" {{ old('status', $payment->status) == 2 ? 'selected' : '' }}>Chưa
                                    xuất
                                    bản</option>
                                <option value="1" {{ old('status', $payment->status) == 1 ? 'selected' : '' }}>Xuất
                                    bản
                                </option>
                            </select>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" name="replayid" class="btn btn-success">Cập nhập thanh toán</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-12 border-bottom pb-2 mb-3">
                    <i style="font-size: 20px" class="fas fa-info"></i>
                    <span style="font-size: 20px; margin-left:5px">Tổng số tiền trong phương thức thanh toán</span>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p><strong>Tổng số tiền:</strong> ${{ number_format($totalAmount, 2) }}</p>
                    <p><strong>Số đơn hàng:</strong> {{ $totalOrders }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:150px">Mã đơn hàng</th>
                                <th class="text-center">Ngày tạo</th>
                                <th class="text-center">Tổng số tiền</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center" style="width:100px">Xem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->order_id }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td class="text-center">
                                        <a class="btn 
                                            @if ($order->status == 3) btn-success 
                                            @elseif ($order->status == 2) btn-primary 
                                            @elseif ($order->status == 1) btn-warning 
                                            @else btn-danger @endif">
                                            {{ App\Models\Order::status()[$order->status] }}
                                        </a>
                                    </td>
                                    <td class="text-center">

                                        <a href="{{ route('admin.order.edit', $order->order_id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-eye"></i>
                                            Xem
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
