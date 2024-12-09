@extends('layouts.admin')
@section('title', 'Cập nhập đơn hàng')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa đơn hàng - {{ $order->order_id }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- Nút quay về danh sách đơn hàng -->
                    <a href="{{ route('admin.export.pdf',['id'=>$order->order_id]) }}" class="btn btn-primary">
                        <i class="fas fa-download"></i> Xuất Hóa Đơn PDF
                    </a>

                    <a href="{{ route('admin.order.index') }}" class="btn btn-info ml-2">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="content" style="padding: 15px">
        <div class="card card-body">
            <form action="{{ route('admin.order.update', ['order_id' => $order->order_id]) }}" method="post"
                enctype="multipart/form-data" class="d-inline-block" id="orderForm">
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
                    {{-- Thông tin đơn hàng --}}
                    <div class="row">
                        <div class="col-12 border-bottom pb-2 mb-3">
                            <i style="p-size: 20px" class="fas fa-info"></i>
                            <span style="p-size: 24px; margin-left:5px">Thông tin đơn hàng</span>
                        </div>
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="order-id" class="col-md-3 col-form-label text-right">Đặt hàng #</label>
                                    <div class="col-md-9">
                                        <p id="order-id" class="form-control-plaintext">{{ $order->order_id }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="created_at" class="col-md-3 col-form-label text-right">Được tạo ra
                                        vào</label>
                                    <div class="col-md-9">
                                        <p id="created_at" class="form-control-plaintext">{{ $order->created_at }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="created_at" class="col-md-3 col-form-label text-right">Được tạo ra
                                        vào</label>
                                    <div class="col-md-9">
                                        <p id="created_at" class="form-control-plaintext">{{ $order->created_at }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="user_id" class="col-md-3 col-form-label text-right">Khách hàng
                                    </label>
                                    <div class="col-md-9">
                                        <a href="{{ route('admin.user.edit', ['user_id' => $user->user_id]) }}">
                                            <p id="user_id" class="form-control-plaintext text-info">{{ $user->email }}
                                            </p>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-md-3 col-form-label text-right">Trạng thái đơn
                                        hàng</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="status" name="status" style="width:250px">
                                            <option value="">Chọn trạng thái giao hàng</option>
                                            @foreach (\App\Models\Order::status() as $key => $status)
                                                <option value="{{ $key }}"
                                                    {{ (string) old('status', $order->status) === (string) $key ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card card-default">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="created_at" class="col-md-3 col-form-label text-right">Mã giảm giá
                                    </label>
                                    <div class="col-md-9">
                                        <p id="created_at" class="form-control-plaintext">
                                            {{ $promotion->requires_coupon == 0 ? "Không có khuyến mãi" : $promotion->requires_coupon}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="created_at" class="col-md-3 col-form-label text-right">Tên giảm giá
                                    </label>
                                    <div class="col-md-9">
                                        <p id="created_at" class="form-control-plaintext">
                                            {{ $promotion->name }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="created_at" class="col-md-3 col-form-label text-right">Số tiền được giảm
                                    </label>
                                    <div class="col-md-9">
                                        <p id="created_at" class="form-control-plaintext">
                                            {{ $promotion->discount_amount }}₫</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="created_at" class="col-md-3 col-form-label text-right">Tổng đơn hàng
                                    </label>
                                    <div class="col-md-9">
                                        <p id="created_at" class="form-control-plaintext">
                                            {{ number_format($order->total_order, 0, ',', '.') }}₫</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payment_method_id" class="col-md-3 col-form-label text-right">Phương thức thanh toán</label>
                                    <div class="col-md-3">
                                        <select id="payment_method_id" name="payment_method_id" class="form-control">
                                            @foreach ($paymentMethods as $method)
                                                <option value="{{ $method->payment_method_id }}"
                                                    {{ $payment->payment_method_id === $method->payment_method_id ? 'selected' : '' }}>
                                                    {{ $method->method_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Cập nhật phương thức thanh toán</button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payment_status" class="col-md-3 col-form-label text-right">Tình trạng
                                        thanh
                                        toán</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="payment_status" name="payment_status"
                                            style="width:250px">
                                            <option value="">Chọn trạng thái giao hàng</option>
                                            @foreach (\App\Models\Order::payment_status() as $key => $shipping_status_id)
                                                <option value="{{ $key }}"
                                                    {{ (string) old('shipping_status_id', $order->shipping_status_id) === (string) $key ? 'selected' : '' }}>
                                                    {{ $shipping_status_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Tình trạng thanh toán</button>
                                    </div>
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
                                    <i class="fas fa-truck mr-2"></i>
                                    Thanh toán & vận chuyển
                                </div>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa toggle-icon fa-minus"></i> </button>
                                </div>
                            </div>
                            <div class="card card-default m-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-default">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <th colspan="2" class="text-center">Địa chỉ thanh toán
                                                            </th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Họ tên đầy đủ</td>
                                                                <td>{!! $address->first_name . ' ' . $address->last_name !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phương thức thanh toán</td>
                                                                <td>{!! $payment->method_name !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Địa chỉ</td>
                                                                <td>{!! $address->address !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Thành phố</td>
                                                                <td>{!! $address->city !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Quận/khu vực</td>
                                                                <td>{!! $address->last_name !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tiểu bang / tỉnh</td>
                                                                <td>{!! $address->state !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mã bưu chính</td>
                                                                <td>{!! $address->postal_code !!}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-default">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <th colspan="2" class="text-center">Địa chỉ giao hàng
                                                            </th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Họ tên đầy đủ</td>
                                                                <td>{!! $address->first_name . ' ' . $address->last_name !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>E-mail</td>
                                                                <td>{!! $address->email !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Địa chỉ</td>
                                                                <td>{!! $address->address !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Thành phố</td>
                                                                <td>{!! $address->city !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Quận/khu vực</td>
                                                                <td>{!! $address->last_name !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tiểu bang / tỉnh</td>
                                                                <td>{!! $address->state !!}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mã bưu chính</td>
                                                                <td>{!! $address->postal_code !!}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="col-12 mt-3">
                                                        <a href="{{ route('admin.user.edit_address', $address->id) }}"
                                                            class="btn btn-info">Chỉnh sửa</a>
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


                {{-- Vận chuyển --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                            <div class="card-header with-border clearfix">
                                <div class="card-title">
                                    <i class="fas fa-th-list mr-2"></i>
                                    Các sản phẩm
                                </div>
                                <div class="card-tools float-right">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa toggle-icon fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="search-body mt-3">
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Giảm giá</th>
                                                    <th class="text-center" style="width:150px">Tổng cộng</th>
                                                    <th class="text-center" style="width:200px">Xem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orderDetailsWithProducts as $orderDetail)
                                                    <tr>
                                                        <td>{!! $orderDetail->product->name !!}</td>
                                                        <td>{{ number_format($orderDetail->product->price, 0, ',', '.') }}₫
                                                        </td>
                                                        <td>{{ $orderDetail->quantity }}</td>
                                                        <td>
                                                            @if ($orderDetail->discount)
                                                                {{ number_format($orderDetail->discount, 0, ',', '.') }}₫
                                                            @else
                                                                Không có
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{ number_format($orderDetail->price, 0, ',', '.') }}₫
                                                        </td>
                                                        <td class="text-center">
                                                            <!-- Add link or button to view details if necessary -->
                                                            <a href="{{ route('admin.product.edit', $orderDetail->product->id) }}"
                                                                class="btn btn-info">Xem</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </section>
    <!-- Include TinyMCE library -->
    <script src="https://cdn.tiny.cloud/1/fyqw5r3tchqm35wywjd85ij01v092q71nea4psfi1ar9sai4/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
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
@endsection
