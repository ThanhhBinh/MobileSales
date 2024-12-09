<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function exportPdf(string $id)
    {
        $order = Order::leftJoin('users', 'orders.user_id', '=', 'users.user_id')
            ->select('orders.*', 'users.first_name', 'users.last_name')
            ->where('orders.order_id', $id)
            ->first(); 
    
        // Nếu không tìm thấy đơn hàng
        if (!$order) {
            return redirect()->back()->withErrors(['message' => 'Không tìm thấy đơn hàng']);
        }
    
        // Lấy chi tiết đơn hàng
        $orderDetails = OrderDetail::where('order_id', $order->order_id)->get();
    
        // Tạo mảng dữ liệu cho hóa đơn
        $data = [
            'order_id' => $order->order_id,
            'customer_name' => $order->first_name . ' ' . $order->last_name, // Tên khách hàng từ bảng users
            'order_date' => $order->created_at->format('d/m/Y'), // Định dạng ngày
            'total' => $order->total_order, // Tổng tiền
            'items' => $orderDetails->map(function ($item) {
                return [
                    'name' => $item->product->name, 
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            }),
        ];
    
        // Sử dụng Facade Pdf để tạo file PDF từ view
        $pdf = Pdf::loadView('backend.pdf.invoice', $data);
    
        // Xuất file PDF và tải xuống
        return $pdf->download('invoice_' . $order->order_id . '.pdf');
    }
}
