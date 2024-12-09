@extends('layouts.admin')
@section('title', 'Tóm tắt bán hàng')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Tóm tắt bán hàng</h1>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Doanh thu -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tổng doanh thu</h3>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ number_format($totalRevenue, 0, ',', '.') }} VND</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Số lượng đơn hàng -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tổng số đơn hàng</h3>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $totalOrders }} đơn</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sản phẩm bán chạy -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Sản phẩm bán chạy</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Số lượng bán</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($topSellingProducts as $product)
                                                    <tr>
                                                        <td>{{ $product->product->name }}</td>
                                                        <td>{{ $product->total_sold }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Đơn hàng theo phương thức thanh toán -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Đơn hàng theo phương thức thanh toán</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Phương thức thanh toán</th>
                                                    <th>Số lượng đơn hàng</th>
                                                    <th>Tổng doanh thu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($paymentMethods as $payment)
                                                    <tr>
                                                        <td>{{ $payment->method_name }}</td>
                                                        <td>{{ $payment->orders->count() }}</td>
                                                        <td>{{ number_format($payment->orders->sum('total_order'), 0, ',', '.') }}
                                                            VND</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
@endsection
