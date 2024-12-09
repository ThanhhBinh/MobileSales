<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionRequest;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotion::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            if ($request->start_date > $request->end_date) {
                return back()->withErrors(['start_date' => 'Ngày bắt đầu không được lớn hơn ngày kết thúc.']);
            }
        }
        
        // Lọc theo ngày bắt đầu
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        // Lọc theo ngày kết thúc
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        // Lọc theo loại giảm giá
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        if ($request->filled('requires_coupon')) {
            $query->where('requires_coupon', $request->requires_coupon);
        }

        // Lọc theo tên giảm giá
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Lọc theo trạng thái hoạt động
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Lấy danh sách khuyến mãi
        $itemsPerPage = $request->input('items_per_page', 7); // Mặc định là 7
        $list = $query->paginate($itemsPerPage);

        return view('backend.promotion.index', compact('list'));
    }

    public function update(Request $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);

        $promotion->name = $request->name;
        $promotion->discount_type = $request->discount_type;
        $promotion->discount_amount = $request->discount_amount;
        $promotion->requires_coupon = $request->requires_coupon;
        $promotion->discount_limit = $request->discount_limit;

        if ($request->discount_limit == 1) {
            $promotion->discount_limit_value = 0;
        } else {
            $promotion->discount_limit_value = $request->discount_limit_value;
        }

        $promotion->start_date = $request->start_date;
        $promotion->end_date = $request->end_date;
        $promotion->created_at = Carbon::now();
        $promotion->save();

        return redirect()->route('admin.promotion.index')->with('success','Cập nhật thành công!');
    }

    public function store(Request $request)
    {
        $promotion = new Promotion();
        $promotion->name = $request->name;
        $promotion->discount_type = $request->discount_type;
        $promotion->discount_amount = $request->discount_amount;
        $promotion->requires_coupon = $request->requires_coupon;
        $promotion->discount_limit = $request->discount_limit;
        $promotion->discount_limit_value = $request->discount_limit_value;
        $promotion->start_date = $request->start_date;
        $promotion->end_date = $request->end_date;
        $promotion->created_at = Carbon::now();
        $promotion->save();

        return redirect()->route('admin.promotion.index')->with('success', 'Thêm khuyến mãi mới thành công');
    }


    public function destroy(string $id)
    {
        $promotion = Promotion::find($id);
        if ($promotion == null) {
            return redirect()->route('admin.promotion.index');
        }
        $promotion->delete(); // Xóa vĩnh viễn
        return redirect()->route('admin.promotion.index')->with('success','Xóa thành công');
    }

    public function create()
    {
        return view('backend.promotion.create');
    }

    public function edit(string $id)
    {
        $promotion = Promotion::find($id);
        if ($promotion == null) {
            return redirect()->route('admin.promotion.index');
        }
        return view('backend.promotion.edit', compact('promotion'));
    }
}
