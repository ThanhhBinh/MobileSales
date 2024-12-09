<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query với bảng Order và sử dụng leftJoin với bảng Payment và Users
        $query = Order::leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.payment_method_id')->leftJoin('users', 'orders.user_id', '=', 'users.user_id')->select('orders.*', 'payment_methods.method_name', 'users.last_name');

        // Kiểm tra và áp dụng bộ lọc theo ngày bắt đầu
        if ($request->filled('start_date')) {
            $query->whereDate('orders.created_at', '>=', $request->input('start_date'));
        }

        // Kiểm tra và áp dụng bộ lọc theo ngày kết thúc
        if ($request->filled('end_date')) {
            $query->whereDate('orders.created_at', '<=', $request->input('end_date'));
        }

        // Kiểm tra và áp dụng bộ lọc theo trạng thái đơn hàng
        if ($request->filled('status')) {
            $query->where('orders.status', 'like', '%' . $request->input('status') . '%');
        }

        // Kiểm tra và áp dụng bộ lọc theo trạng thái thanh toán
        if ($request->filled('payment_status')) {
            $query->where('orders.payment_status', 'like', '%' . $request->input('payment_status') . '%');
        }

        // Kiểm tra và áp dụng bộ lọc theo trạng thái vận chuyển
        if ($request->filled('shipping_method_id')) {
            $query->where('orders.shipping_method_id', 'like', '%' . $request->input('shipping_method_id') . '%');
        }

        // Kiểm tra và áp dụng bộ lọc theo số điện thoại thanh toán
        if ($request->filled('phone')) {
            $query->where('users.phone', 'like', '%' . $request->input('phone_number') . '%');
        }

        // Kiểm tra và áp dụng bộ lọc theo địa chỉ email thanh toán
        if ($request->filled('email')) {
            $query->where('users.email', 'like', '%' . $request->input('email') . '%');
        }

        // Kiểm tra và áp dụng bộ lọc theo phương thức thanh toán
        if ($request->filled('payment_method')) {
            $query->where('payment_methods.payment_method_id', 'like', '%' . $request->input('payment_method') . '%');
        }

        $payment = Payment::all();

        // Lấy số lượng item trên mỗi trang từ request (mặc định là 7)
        $itemsPerPage = $request->input('items_per_page', 7);

        // Phân trang kết quả với số lượng item per page
        $list = $query->paginate($itemsPerPage);

        // Trả về view với dữ liệu đã phân trang
        return view('backend.order.index', compact('list', 'payment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::find($id);

        // Kiểm tra nếu đơn hàng không tồn tại
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        $user = User::where('user_id', '=', $order->user_id)->first();
        $payment = Payment::where('payment_method_id', '=', $order->payment_method_id)->first();
        $paymentMethods = Payment::all();
        $shipping = ShippingMethod::where('shipping_method_id', '=', $order->shipping_method_id)->first();
        $address = Address::where('id', '=', $order->address_id)->first();
        $promotion = Promotion::where([['id', '=', $order->promotion_id], ['is_active', '=', 1]])->first();

        // Lấy chi tiết đơn hàng
        $orderDetails = OrderDetail::where('order_id', $order->order_id)->get();

        // Lấy danh sách product_id từ OrderDetail
        $productIds = $orderDetails->pluck('product_id');

        // Lấy thông tin các sản phẩm dựa trên product_id
        $products = Product::whereIn('id', $productIds)->get();

        // Kết hợp thông tin sản phẩm và số lượng từ OrderDetail
        $orderDetailsWithProducts = $orderDetails->map(function ($orderDetail) use ($products) {
            $product = $products->firstWhere('id', $orderDetail->product_id);
            $orderDetail->product = $product; // Thêm thông tin sản phẩm vào orderDetail
            $orderDetail->quantity = $orderDetail->quantity; // Số lượng đã có sẵn từ OrderDetail
            return $orderDetail;
        });

        return view('backend.order.edit', compact('order', 'user', 'payment', 'shipping', 'address', 'products', 'orderDetailsWithProducts', 'promotion','paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->payment_method_id = $request->payment_method_id;

        // Lưu lại thay đổi
        $order->save();
        return redirect()
            ->route('admin.order.edit',['order_id'=>$order->order_id])
            ->with('success', 'Trạng thái đơn hàng đã được cập nhật');
    }
}
