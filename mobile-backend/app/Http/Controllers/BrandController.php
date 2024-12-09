<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

class BrandController extends Controller
{
    //Trang chủ
    public function index(Request $request)
    {
        // Khởi tạo truy vấn với điều kiện trạng thái
        $query = Brand::where('status', '!=', 0)->orderBy('created_at', 'DESC');

        // Lọc theo tên nếu có
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Lọc các danh mục có tên bắt đầu bằng chữ cái cụ thể nếu có
        if ($request->filled('starts_with')) {
            $query->where('name', 'like', $request->input('starts_with') . '%');
        }

        $itemsPerPage = $request->input('items_per_page', 7); // Mặc định là 7
        $list = $query->paginate($itemsPerPage); // Sử dụng $query thay vì Brand::paginate

        return view('backend.brand.index', compact('list'));
    }
    public function create()
    {
        $list = Brand::where('status', '!=', 0)->orderBy('created_at', 'DESC')->get();

        $htmlsortorder = '';

        foreach ($list as $item) {
            $htmlsortorder .= "<option value='" . ($item->sort_order + 1) . "'>Sau: " . $item->name . '</option>';
        }
        return view('backend.brand.create', compact('list', 'htmlsortorder'));
    }
    public function store(StoreBrandRequest $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slug = Str::of($request->name)->slug('-');
        $brand->sort_order = $request->sort_order;
        if ($request->image) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'gif', 'webp'])) {
                $filename = $brand->slug . '.' . $exten;
                $request->image->move(public_path('images/brands'), $filename);
                $brand->image = $filename;
            }
        }
        $brand->status = $request->status;
        $brand->created_at = date('Y-m-d H:i:s');
        $brand->created_by = Auth::id() ?? 1;
        $brand->save();
        return redirect()->route('admin.brand.index')->with('success', 'Thêm thương hiệu thành công');
    }
    
    public function show(string $id)
    {
        $user = User::where('user_id', $id)->first();

        $query = Brand::where('brands.status', '!=', '0')->join('users', 'brands.created_by', '=', 'users.user_id')->select('brands.id', 'brands.name', 'brands.slug', 'brands.description', 'brands.image', 'brands.sort_order', 'brands.created_by', 'brands.status', 'users.name as username', 'users.user_id')->first();

        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }

        $list = Product::where('products.status', '!=', 0)->where('products.brand_id', '=', $id)->join('brands', 'products.brand_id', 'brands.id')->select('products.id as product_id', 'products.name as product_name', 'products.price as product_price', 'products.status as product_status')->orderBy('products.created_at', 'DESC')->get();

        return view('backend.brand.show', compact('brand', 'list'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }

        $list = Brand::where('status', '!=', 0)->select('id', 'image', 'sort_order', 'name', 'slug', 'status')->orderBy('created_at', 'DESC')->get();
        $htmlsortorder = '';
        foreach ($list as $row) {
            if ($brand->sort_order - 1 == $row->sort_order) {
                $htmlsortorder .= "<option selected value='" . ($row->sort_order + 1) . "'>Sau: " . $row->name . '</option>';
            } else {
                $htmlsortorder .= "<option value='" . ($row->sort_order + 1) . "'>Sau: " . $row->name . '</option>';
            }
        }
        return view('backend.brand.edit', compact('list', 'brand','htmlsortorder'));
    }

    //Cập nhật
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }

        // Cập nhật dữ liệu của brand
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slug = Str::of($request->name)->slug('-');
        $brand->sort_order = $request->sort_order;

        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'gif', 'webp'])) {
                $filename = $brand->slug . '.' . $exten;
                $request->image->move(public_path('images/brands'), $filename);
                $brand->image = $filename;
            }
        }

        $brand->status = $request->status;
        $brand->updated_at = now();
        $brand->updated_by = Auth::id() ?? 1;
        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Thương hiệu đã được cập nhật.');
    }

    //Đưa vào thùng rác
    public function delete(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index')->with('error', 'Thương hiệu không tồn tại.');
        }

        // Kiểm tra nếu có sản phẩm liên quan đến brand_id này
        $productsCount = Product::where('brand_id', $id)->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.brand.index')->with('error', 'Thương hiệu này có sản phẩm liên quan, không thể xóa.');
        }

        // Tiến hành xóa nếu không có sản phẩm liên quan
        $brand->status = 0;
        $brand->updated_at = now();
        $brand->updated_by = Auth::id() ?? 1;
        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Thương hiệu đã được xóa.');
    }

    //Thùng rác
    public function trash()
    {
        $list = Brand::where('status', '=', 0)->select('id', 'image', 'sort_order', 'name', 'slug', 'status')->orderBy('created_at', 'DESC')->get();
        return view('backend.brand.trash', compact('list'));
    }

    //Xóa khỏi CSDL
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }
        $brand->delete();
        return redirect()->route('admin.brand.trash');
    }

    //Khôi phục
    public function restore(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }
        $brand->status = 2;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = Auth::id() ?? 1;
        $brand->save();
        return redirect()->route('admin.brand.index')->with('success', 'Khôi phục thành công');
    }

    //Trạng thái
    public function status(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }
        $brand->status = $brand->status == 1 ? 2 : 1;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->save();
        return redirect()->route('admin.brand.index')->with('success', 'Thay đổi trạng thái thành công');
    }

     //Xóa danh mục đã chọn
     public function delete_multiple(Request $request)
     {
         // Tách các ID từ input
         $ids = explode(',', $request->input('ids'));
 
         // Kiểm tra xem có ID nào không
         if (empty(array_filter($ids))) {
             return redirect()->route('admin.brand.index')->with('error', 'Không có danh mục nào để xóa.');
         }
 
         $productsCount = Product::where('brand_id', $ids)->count();
 
         if ($productsCount > 0) {
             return redirect()->route('admin.brand.index')->with('error', 'Danh mục này có sản phẩm liên quan, không thể xóa.');
         }
 
         // Cập nhật trạng thái
         $updated = brand::whereIn('id', $ids)->update([
             'status' => 0,
             'updated_by' => Auth::id() ?? 1,
         ]);
 
         if ($updated > 0) {
             return redirect()->route('admin.brand.index')->with('success', 'Các danh mục đã được xóa.');
         } else {
             return redirect()->route('admin.brand.index')->with('error', 'Không thể xóa các danh mục.');
         }
     }
 
     public function destroy_multiple(Request $request)
     {
         // Tách các ID từ input
         $ids = explode(',', $request->input('ids'));
 
         // Kiểm tra xem có ID nào không
         if (empty(array_filter($ids))) {
             return redirect()->route('admin.brand.index')->with('error', 'Không có danh mục nào để xóa.');
         }
 
         // Kiểm tra xem tất cả ID có hợp lệ không
         $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên
 
         // Cập nhật trạng thái
         $updated = brand::whereIn('id', $ids)->delete();
 
         if ($updated > 0) {
             return redirect()->route('admin.brand.index')->with('success', 'Các danh mục đã được xóa.');
         } else {
             return redirect()->route('admin.brand.index')->with('error', 'Không thể xóa các danh mục.');
         }
     }
 
     public function restore_multiple(Request $request)
     {
         // Tách các ID từ input
         $ids = explode(',', $request->input('ids'));
 
         // Kiểm tra xem có ID nào không
         if (empty(array_filter($ids))) {
             return redirect()->route('admin.brand.index')->with('error', 'Không có danh mục nào để khôi phục.');
         }
 
         // Kiểm tra xem tất cả ID có hợp lệ không
         $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên
 
         // Cập nhật trạng thái
         $updated = brand::whereIn('id', $ids)->update([
             'status' => 2, // Giả sử trạng thái 1 là "đã xuất bản"
             'updated_by' => Auth::id() ?? 1,
         ]);
 
         if ($updated > 0) {
             return redirect()->route('admin.brand.index')->with('success', 'Các danh mục đã được khôi phục.');
         } else {
             return redirect()->route('admin.brand.index')->with('error', 'Không thể khôi phục các danh mục.');
         }
     }
}
