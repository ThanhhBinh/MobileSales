@extends('layouts.admin')
@section('title', 'Bảng điều khiển')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Bảng điều khiển</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Bảng điều khiển</li>
                                </ol>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary card-outline"
                                            id="nopcommerce-common-statistics-card">
                                            <div class="card-header with-border clearfix">
                                                <div class="card-title">
                                                    <i class="far fa-chart-bar"></i>
                                                    Thống kê chung
                                                </div>
                                                <div class="card-tools float-right">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i> </button>
                                                </div>
                                            </div>
                                            <div class="card-body" style="display:block">
                                                <div class="row">
                                                    <div class="col-lg-4 col-6">
                                                        <div class="small-box bg-info">
                                                            <div class="inner">
                                                                <h3>{{ $ordersCount }}</h3>
                                                                <p>Đơn hàng</p>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="ion ion-bag"></i>
                                                            </div>
                                                            <a class="small-box-footer"
                                                                href="{{ route('admin.order.index') }}">
                                                                Thông tin thêm
                                                                <i class="fas fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6">
                                                        <div class="small-box bg-green">
                                                            <div class="inner">
                                                                <h3>{{ $customersCount }}</h3>
                                                                <p>Khách hàng đã đăng ký</p>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="ion ion-person-add"></i>
                                                            </div>
                                                            <a class="small-box-footer"
                                                                href="{{ route('admin.user.index') }}">
                                                                Thông tin thêm
                                                                <i class="fas fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-6">
                                                        <div class="small-box bg-red">
                                                            <div class="inner">
                                                                <h3>{{ $lowStockCount }}</h3>
                                                                <p>Sản phẩm còn ít</p>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="ion ion-pie-graph"></i>
                                                            </div>
                                                            <a class="small-box-footer"
                                                                href="{{ route('admin.report.LowStock') }}">
                                                                Thông tin thêm
                                                                <i class="fas fa-arrow-circle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Đơn hàng -->
                                    <div class="col-md-6">
                                        <div class="card card-primary card-outline collapsed-card"
                                            id="order-statistics-card">
                                            <div class="card-header with-border">
                                                <h3 class="card-title">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    Đơn hàng
                                                </h3>
                                                <div class="card-tools float-right">
                                                    <button type="button" class="btn btn-tool margin-l-10"
                                                        data-card-widget="collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart" style="height: 300px;">
                                                    <canvas id="order-statistics-chart" height="150"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Khách hàng mới -->
                                    <div class="col-md-6">
                                        <div class="card card-primary card-outline collapsed-card"
                                            id="customer-statistics-card">
                                            <div class="card-header with-border">
                                                <h3 class="card-title">
                                                    <i class="far fa-user"></i>
                                                    Khách hàng mới
                                                </h3>
                                                <div class="card-tools float-right">
                                                    <button type="button" class="btn btn-tool margin-l-10"
                                                        data-card-widget="collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart" style="height: 300px;">
                                                    <canvas id="customer-statistics-chart" height="150"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Biểu đồ thống kê đơn hàng
                                    const ordersData = @json($orders);
                                    const orderLabels = ordersData.map(order => 'Tháng ' + order.month);
                                    const orderCounts = ordersData.map(order => order.total);

                                    const ctxOrders = document.getElementById('order-statistics-chart').getContext('2d');
                                    new Chart(ctxOrders, {
                                        type: 'line',
                                        data: {
                                            labels: orderLabels,
                                            datasets: [{
                                                label: 'Đơn hàng',
                                                data: orderCounts,
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1,
                                                fill: true,
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });

                                    // Biểu đồ thống kê khách hàng mới
                                    const customersData = @json($customers);
                                    const customerLabels = customersData.map(customer => 'Tháng ' + customer.month);
                                    const customerCounts = customersData.map(customer => customer.total);

                                    const ctxCustomers = document.getElementById('customer-statistics-chart').getContext('2d');
                                    new Chart(ctxCustomers, {
                                        type: 'line',
                                        data: {
                                            labels: customerLabels,
                                            datasets: [{
                                                label: 'Khách hàng mới',
                                                data: customerCounts,
                                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                                borderColor: 'rgba(153, 102, 255, 1)',
                                                borderWidth: 1,
                                                fill: true,
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                </script>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card card-primary card-outline collapsed-card"
                                            id="order-average-report-card">
                                            <div class="card-header with-border">
                                                <h3 class="card-title">
                                                    <i class="far fa-money-bill-alt"></i>
                                                    Tổng số đơn hàng
                                                </h3>
                                                <div class="card-tools float-right">
                                                    <button class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body" style="padding-bottom: 22px;">
                                                <div id="orderAverageReport">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Trạng thái đơn hàng</th>
                                                                <th>Hôm nay</th>
                                                                <th>Tuần này</th>
                                                                <th>Tháng này</th>
                                                                <th>Năm nay</th>
                                                                <th>Mọi thời gian</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orderData as $status => $data)
                                                                <tr>
                                                                    <td>{{ $status }}</td>
                                                                    <td>{{ number_format($data['today'], 2) }} đ</td>
                                                                    <td>{{ number_format($data['week'], 2) }} đ</td>
                                                                    <td>{{ number_format($data['month'], 2) }} đ</td>
                                                                    <td>{{ number_format($data['year'], 2) }} đ</td>
                                                                    <td>{{ number_format($data['all_time'], 2) }} đ</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card card-primary card-outline collapsed-card"
                                            id="order-incomplete-report-card">
                                            <div class="card-header with-border">
                                                <h3 class="card-title">
                                                    <i class="fas fa-hourglass-start"></i>
                                                    Đơn hàng chưa hoàn thành
                                                </h3>
                                                <div class="card-tools float-right">
                                                    <button class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="orderIncompleteReport">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Mục</th>
                                                                <th>Tổng cộng</th>
                                                                <th>Đếm</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Tổng số đơn hàng chưa thanh toán -->
                                                            <tr>
                                                                <td>Tổng số đơn hàng chưa thanh toán (trạng thái đang chờ
                                                                    thanh toán)</td>
                                                                <td>{{ number_format($pendingOrdersTotal, 2) }} đ</td>
                                                                <td><a href="{{ route('admin.order.index') }}"
                                                                        class="btn btn-xs btn-info">{{ $pendingOrdersCount }}
                                                                        - Xem tất cả</a></td>
                                                            </tr>
                                                            <!-- Tổng số đơn hàng chưa được giao -->
                                                            <tr>
                                                                <td>Tổng số đơn hàng chưa được giao</td>
                                                                <td>{{ number_format($notShippedOrdersTotal, 2) }} đ</td>
                                                                <td><a href="{{ route('admin.order.index') }}"
                                                                        class="btn btn-xs btn-info">{{ $notShippedOrdersCount }}
                                                                        - Xem tất cả</a></td>
                                                            </tr>
                                                            <!-- Tổng số đơn hàng chưa hoàn thành -->
                                                            <tr>
                                                                <td>Tổng số đơn hàng chưa hoàn thành (trạng thái đơn hàng
                                                                    đang chờ xử lý)</td>
                                                                <td>{{ number_format($processingOrdersTotal, 2) }} đ</td>
                                                                <td><a href="{{ route('admin.order.index') }}"
                                                                        class="btn btn-xs btn-info">{{ $processingOrdersCount }}
                                                                        - Xem tất cả</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary card-outline collapsed-card" id="latest-orders-card">
                                            <div class="card-header with-border">
                                                <h3 class="card-title">
                                                    <i class="fas fa-cart-plus"></i>
                                                    Đơn hàng mới nhất
                                                    <a class="btn btn-xs btn-info btn-flat margin-l-10" href="{{ route('admin.order.index') }}">Xem tất cả đơn hàng</a>
                                                </h3>
                                                <div class="card-tools float-right">
                                                    <button class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="latestOrdersReport">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Đặt hàng #</th>
                                                                <th>Trạng thái đơn hàng</th>
                                                                <th>Khách hàng</th>
                                                                <th>Được tạo ra vào</th>
                                                                <th>Xem</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($latestOrders as $order)
                                                                <tr>
                                                                    <td>{{ $order->order_id }}</td>
                                                                    <td>
                                                                        <a class="btn 
                                                                            @if ($order->status == 3) btn-success 
                                                                            @elseif ($order->status == 2) btn-primary 
                                                                            @elseif ($order->status == 1) btn-warning 
                                                                            @else btn-danger @endif">
                                                                            {{ App\Models\Order::status()[$order->status] }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $order->user->first_name }} ({{ $order->user->email }})</td>
                                                                    <td>{{ $order->created_at->format('m/d/Y h:i:s A') }}</td>
                                                                    <td><a href="{{ route('admin.order.edit', ['order_id' => $order->order_id]) }}" class="btn btn-xs btn-info">Xem</a></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                    
                                                    {{-- Phân trang --}}
                                                    <div class="pagination">
                                                        {{ $latestOrders->links() }}
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
    </section>
    <!-- /.content -->
    </section>
    <style>
        .configuration-step-link {
            display: block;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ed3737;
            background-color: #ffffff;
            text-decoration: none;
            transition: background-color 0.2s ease-in-out;
        }

        .configuration-step-link:hover {
            background-color: #a3eff2;
        }

        .configuration-step-icon {
            font-size: 24px;
            color: #495057;
            margin-bottom: 10px;
        }

        .configuration-step-link h5 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #343a40;
        }

        .configuration-step-link small {
            font-size: 14px;
            color: #6c757d;
        }

        #orderAverageReport table {
            width: 100%;
            border-collapse: collapse;
        }

        #orderAverageReport th,
        #orderAverageReport td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        #orderAverageReport th {
            background-color: #f4f4f4;
        }

        #orderIncompleteReport table {
            width: 100%;
            border-collapse: collapse;
        }

        #orderIncompleteReport th,
        #orderIncompleteReport td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #orderIncompleteReport th {
            background-color: #f8f9fa;
        }

        #orderIncompleteReport tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #latestOrdersReport table {
            width: 100%;
            border-collapse: collapse;
        }

        #latestOrdersReport th,
        #latestOrdersReport td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #latestOrdersReport th {
            background-color: #f8f9fa;
        }

        #latestOrdersReport tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pagination {
            margin-top: 15px;
            text-align: center;
        }

        .pagination .page-link {
            padding: 8px 12px;
            margin: 0 2px;
        }

        #bestsellersBriefReportByQuantity table {
            width: 100%;
            border-collapse: collapse;
        }

        #bestsellersBriefReportByQuantity th,
        #bestsellersBriefReportByQuantity td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #bestsellersBriefReportByQuantity th {
            background-color: #f8f9fa;
        }

        #bestsellersBriefReportByQuantity tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pagination {
            margin-top: 15px;
            text-align: center;
        }

        .pagination .page-link {
            padding: 8px 12px;
            margin: 0 2px;
        }

        
    </style>
@endsection
