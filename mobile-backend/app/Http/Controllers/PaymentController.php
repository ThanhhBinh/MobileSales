<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Lọc theo điều kiện và sắp xếp trước khi phân trang
        $query = Payment::where('status', '!=', 0)->orderBy('created_at', 'DESC');

        // Lấy số lượng mục mỗi trang từ request (mặc định là 7)
        $itemsPerPage = $request->input('items_per_page', 7);

        // Áp dụng phân trang sau khi lọc dữ liệu
        $list = $query->paginate($itemsPerPage);

        return view('backend.payment.index', compact('list'));
    }

    public function store(Request $request)
    {
        $payment = new Payment();
        $payment->method_name = $request->method_name;
        $payment->description = $request->description;
        $payment->status = $request->status;
        $payment->created_at = now();
        $payment->created_by = Auth::id() ?? 1;
        $payment->save();
        return redirect()->route('admin.payment.index')->with('success', 'Phương thức thanh toán đã được thêm.');
    }

    public function show(string $id)
    {
        $payment = Payment::find($id);
        if ($payment == null) {
            return redirect()->route('admin.payment.index');
        }

        return view('backend.payment.show', compact('payment'));
    }

    public function create()
    {
        return view('backend.payment.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::find($id);
        if ($payment == null) {
            return redirect()->route('admin.payment.index');
        }
    
        $list = Payment::where('status', '!=', 0)->orderBy('created_at', 'DESC')->get();
    
        // Lấy tất cả đơn hàng sử dụng phương thức thanh toán nà
        $orders = Order::where('payment_method_id', $id)->get();
        
        // Tính tổng số tiền và số lượng đơn hàng
        $totalAmount = $orders->sum('total_order'); // Tổng số tiền của tất cả đơn hàng
        $totalOrders = $orders->count(); // Số lượng đơn hàng
    
        // Trả về view với tất cả các dữ liệu cần thiết
        return view('backend.payment.edit', compact('list', 'payment', 'orders', 'totalAmount', 'totalOrders'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Tìm thanh toán theo ID
        $payment = Payment::find($id);

        if ($payment == null) {
            return redirect()->route('admin.payment.index');
        }

        // Cập nhật các trường của thanh toán
        $payment->method_name = $request->method_name;
        $payment->description = $request->description;
        $payment->status = $request->status;
        $payment->updated_by = Auth::id() ?? 1;

        // Lưu cập nhật
        $payment->save();

        return redirect()->route('admin.payment.index')->with('success', 'Cập nhật thanh toán thành công');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $payment = Payment::find($id);
        if ($payment == null) {
            return redirect()->route('admin.payment.index');
        }
        $payment->delete();
        return redirect()->route('admin.payment.index')->with('success', 'Xóa bỏ thành công');
    }
}
