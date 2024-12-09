<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Truy vấn số lượng đơn hàng theo tháng
        $orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->orderBy('month')->get();

        // Truy vấn số lượng khách hàng mới theo tháng
        $customers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->orderBy('month')->get();

        // Thống kê tổng đơn hàng, khách hàng và sản phẩm tồn kho thấp
        $ordersCount = Order::count();
        $customersCount = User::where('role_id', '=', '2')->count(); // Khách hàng có role_id = 2
        $lowStockCount = Product::where('stock', '<', 20)->count();

        $statuses = Order::status();

        // Lấy tổng số tiền cho từng trạng thái và từng khoảng thời gian
        $orderData = [];
        foreach ($statuses as $key => $status) {
            $orderData[$status] = [
                'today' => Order::getTotalByStatusAndTime($key, 'today'),
                'week' => Order::getTotalByStatusAndTime($key, 'week'),
                'month' => Order::getTotalByStatusAndTime($key, 'month'),
                'year' => Order::getTotalByStatusAndTime($key, 'year'),
                'all_time' => Order::getTotalByStatusAndTime($key, 'all_time'),
            ];
        }

        $pendingOrdersTotal = Order::where('payment_status', 1)->sum('total_order');
        $pendingOrdersCount = Order::where('payment_status', 1)->count();

        // Tổng số đơn hàng chưa được giao (trạng thái giao hàng chưa được thực hiện)
        $notShippedOrdersTotal = Order::where('shipping_status_id', 4)->sum('total_order');
        $notShippedOrdersCount = Order::where('shipping_status_id', 4)->count();

        // Tổng số đơn hàng chưa hoàn thành (trạng thái đang chờ xử lý)
        $processingOrdersTotal = Order::where('status', 2)->sum('total_order');
        $processingOrdersCount = Order::where('status', 2)->count();

        $latestOrders = Order::orderBy('created_at', 'desc')->paginate(5);

        // Trả dữ liệu cho view
        return view('backend.dashboard.index', compact('ordersCount', 'customersCount', 'lowStockCount', 'orders', 'customers', 'orderData', 'pendingOrdersTotal', 'pendingOrdersCount', 'notShippedOrdersTotal', 'notShippedOrdersCount', 'processingOrdersTotal', 'processingOrdersCount', 'latestOrders'));
    }
}
