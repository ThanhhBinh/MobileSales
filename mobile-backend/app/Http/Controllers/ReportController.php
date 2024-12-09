<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salesSummary()
    {
        // Lấy tổng doanh thu
        $totalRevenue = Order::where('status', 3)->sum('total_order');

        // Lấy số lượng đơn hàng hoàn thành
        $totalOrders = Order::where('status', 3)->count();

        // Lấy sản phẩm bán chạy
        $topSellingProducts = OrderDetail::selectRaw('product_id, SUM(quantity) as total_sold')
        ->groupBy('product_id')->orderByDesc('total_sold')
        ->limit(5)->get();

        // Lấy số lượng đơn hàng theo từng phương thức thanh toán
        $paymentMethods = Payment::all();

        return view('backend.report.salessummary', compact('totalRevenue', 'totalOrders', 'topSellingProducts', 'paymentMethods'));
    }

    public function LowStock(Request $request)
    {
        // Lấy số lượng sản phẩm trên mỗi trang từ request hoặc mặc định là 7
        $itemsPerPage = $request->input('items_per_page', 7);
    
        // Lấy các sản phẩm còn ít hàng với điều kiện stock < 5
        $product = Product::where('stock', '<', 20)->paginate($itemsPerPage);
    
        // Trả về view cùng với dữ liệu sản phẩm
        return view('backend.report.lowstock', compact('product'));
    }
}
