<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index(Request $request)
    {
        $query = ShippingMethod::query();

        // Lọc theo ngày bắt đầu và ngày kết thúc
        if ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->input('end_date') . ' 23:59:59');
        }

        // Lọc theo trạng thái giao hàng
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Số lượng mục trên mỗi trang
        $itemsPerPage = $request->input('items_per_page', 7);

        // Lấy danh sách sau khi áp dụng các điều kiện lọc
        $list = $query->orderBy('created_at', 'DESC')->paginate($itemsPerPage);

        return view('backend.shipping.index', compact('list'));
    }

    public function edit(string $id)
    {
        // Tìm thông tin giao hàng dựa trên ID
        $shipping = ShippingMethod::find($id);

        // Kiểm tra nếu không tìm thấy thông tin giao hàng
        if (!$shipping) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'Không tìm thấy thông tin giao hàng!']);
        }

        // Lấy danh sách chi tiết đơn hàng dựa trên order_id từ shipping
        $orderDetails = OrderDetail::where('order_id', $shipping->order_id)->get();

        // Lấy danh sách ID của các sản phẩm liên quan từ orderDetails
        $productIds = $orderDetails->pluck('product_id');

        // Lấy thông tin sản phẩm và phương thức vận chuyển (join giữa products và shipping)
        $products = Product::leftJoin('shipping', 'products.id', '=', 'shipping.product_id')
            ->whereIn('products.id', $productIds)
            ->select('products.name', 'shipping.*') // Lấy thông tin sản phẩm và phương thức vận chuyển
            ->get();

        // Trả về view với dữ liệu cần thiết
        return view('backend.shipping.edit', compact('shipping', 'orderDetails', 'products'));
    }

    public function destroy(string $id)
    {
        $shipping = ShippingMethod::find($id);
        if ($shipping == null) {
            return redirect()->route('admin.shipping.index');
        }
        
        $shipping->delete();
        return redirect()->route('admin.shipping.index')->with('success', 'Xóa thành công');
    }
}
