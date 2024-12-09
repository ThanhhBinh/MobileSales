@extends('layouts.admin')
@section('title','Chi tiết đơn hàng')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết đơn hàng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="orderdetail_edit.html" class="btn btn-sm btn-primary">
                        <i class="far fa-edit"></i> Sửa
                    </a>
                    <a href="#" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.orderdetail.index')}}">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width:30%;">
                            <strong>Tên trường</strong>
                        </th>
                        <th class="text-center" style="width:70%;">Giá trị</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Id</td>
                        <td>{{ $orderdetail->id }}</td>
                    </tr>
                    <tr>
                        <td>Số lượng</td>
                        <td>{{ $orderdetail->quantity }}</td>
                    </tr>
                    <tr>
                        <td>Số lượng</td>
                        <td>{{ $orderdetail->amount }}</td>
                    </tr>
                    <tr>
                        <td>Giá</td>
                        <td>{{ $orderdetail->price }}</td>
                    </tr>
                    <tr>
                        <td>Ngày đặt hàng</td>
                        <td>{{ $order->order_date }}</td>
                    </tr>
                    <tr>
                        <td>Tổng đơn hàng </td>
                        <td>{{ $order->totalorder }}</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td>Phương pháp vận chuyển</td>
                        <td>{{ $order->shipping_method }}</td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td>{{ $order->payment_method }}</td>
                    </tr>
                    <tr>
                        <td>Ngày tạo</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Người tạo</td>
                        <td>{{ $order->created_by }}</td>
                    </tr>
                    <tr>
                        <td>Ngày cập nhật</td>
                        <td>{{ $order->updated_at }}</td>
                    </tr>
                    <tr>
                        <td>Người cập nhật</td>
                        <td>{{ $order->updated_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection