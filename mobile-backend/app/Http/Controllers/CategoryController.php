<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //Trang chủ
    public function index(Request $request)
    {
        // Khởi tạo truy vấn với điều kiện trạng thái
        $query = Category::where('status', '!=', 0)->with('parent')
        ->orderBy('created_at','DESC');

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

        // Lấy số mục mỗi trang từ request, mặc định là 7
        $itemsPerPage = $request->input('items_per_page', 7);

        // Phân trang dữ liệu với các điều kiện lọc đã áp dụng
        $categories = $query->paginate($itemsPerPage);
        // Trả về view với dữ liệu đã phân trang
        return view('backend.category.index', compact('categories'));
    }
    
    //tạo danh mục
    public function create()
    {
        $query = Category::with('parent');

        $categories = Category::all();

        $htmlparentid = '';
        $htmlsortorder = '';

        foreach ($categories as $item) {
            $htmlparentid .= "<option value='" . $item->id . "'>" . $item->fullName() . '</option>';
            $htmlsortorder .= "<option value='" . ($item->sort_order + 1) . "'>Sau: " . $item->fullName() . '</option>';
        }
        return view('backend.category.create', compact('htmlparentid', 'htmlsortorder'));
    }
    //Thêm mới

    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = Str::of($request->name)->slug('-');
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        if ($request->image) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'gif', 'webp'])) {
                $filename = $category->slug . '.' . $exten;
                $request->image->move(public_path('images/categorys'), $filename);
                $category->image = $filename;
            }
        }
        $category->status = $request->status;
        $category->created_at = date('Y-m-d H:i:s');
        $category->created_by = Auth::id() ?? 1;
        $category->save();
        return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục mới thành công.');
    }

    //Cập nhật
    public function edit(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index');
        }
        $list = Category::where('status', '!=', 0)->select('id', 'name', 'sort_order')->orderBy('created_at', 'DESC')->get();

        $htmlparentid = '';
        $htmlsortorder = '';
        foreach ($list as $row) {
            if ($category->parent_id == $row->id) {
                $htmlparentid .= "<option selected value='" . $row->id . "'>" . $row->fullName() . '</option>';
            } else {
                $htmlparentid .= "<option value='" . $row->id . "'>" . $row->fullName() . '</option>';
            }
            if ($category->sort_order - 1 == $row->sort_order) {
                $htmlsortorder .= "<option selected value='" . ($row->sort_order + 1) . "'>Sau: " . $row->fullName() . '</option>';
            } else {
                $htmlsortorder .= "<option value='" . ($row->sort_order + 1) . "'>Sau: " . $row->fullName() . '</option>';
            }
        }
        return view('backend.category.edit', compact('list', 'htmlparentid', 'htmlsortorder', 'category'));
    }

    //Trạng thái
    public function status(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index');
        }
        $category->status = $category->status == 1 ? 2 : 1;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->save();
        return redirect()->route('admin.category.index')->with('success', 'Thay đổi trạng thái thành công.');
    }

    //thùng rác
    public function trash()
    {
        $list = Category::where('status', '=', 0)->select('id', 'name', 'image', 'slug', 'status', 'sort_order')->orderBy('created_at', 'DESC')->get();
        return view('backend.category.trash', compact('list'));
    }

    // xóa khỏi csdl
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index');
        }
        $productsCount = Product::where('category_id', $id)->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.category.index')->with('error', 'Danh mục này có sản phẩm liên quan, không thể xóa.');
        }
        
        $category->delete();
        return redirect()->route('admin.category.trash')->with('success','Xóa thành công');
    }

    //xóa khỏi index
    public function delete(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index')->with('error', 'Danh mục không tồn tại.');
        }

        // Kiểm tra nếu có sản phẩm liên quan đến category_id này
        $productsCount = Product::where('category_id', $id)->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.category.index')->with('error', 'Danh mục này có sản phẩm liên quan, không thể xóa.');
        }

        // Tiến hành xóa nếu không có sản phẩm liên quan
        $category->status = 0;
        $category->updated_at = now();
        $category->updated_by = Auth::id() ?? 1;
        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được xóa.');
    }

    //Hiển thị
    public function show(string $id)
    {
        $user = User::where('user_id', $id)->first();

        // Truy vấn thông tin category cùng với người tạo là user
        $query = Category::where('categories.status', '!=', '0')
        ->join('users', 'categories.created_by', '=', 'users.user_id')
        ->select('categories.id', 'categories.name', 'categories.slug', 'categories.image', 'categories.description', 'categories.parent_id', 'categories.sort_order', 'categories.status','categories.created_at as categorycreatedat', 'categories.created_by as categorycreated', 'users.name as username', 'users.user_id')->first();
        $category = Category::find($id);

        if ($category == null) {
            return redirect()->route('admin.category.index');
        }

        $list = Product::where('products.status', '!=', 0)
        ->where('products.category_id', $id)
        ->join('categories', 'products.category_id', 'categories.id')
        ->select('products.id as product_id', 'products.name as product_name', 'categories.name as categoryname', 'products.description', 'products.price as product_price', 'products.status as product_status')->get();

        return view('backend.category.show', compact('query', 'list'));
    }

    // Khôi phục
    public function restore(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index');
        }
        $category->status = 2;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = Auth::id() ?? 1;
        $category->save();
        return redirect()->route('admin.category.index')->with('success', 'Khôi phục thành công.');
    }

    //Cập nhật
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index');
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = Str::of($request->name)->slug('-');
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        if ($request->image) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'gif', 'webp'])) {
                $filename = $category->slug . '.' . $exten;
                $request->image->move(public_path('images/categorys'), $filename);
                $category->image = $filename;
            }
        }
        $category->status = $request->status;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = Auth::id() ?? 1;
        $category->save();
        return redirect()->route('admin.category.index')->with('success', 'Cập nhật thành công.');
    }

    //Xóa danh mục đã chọn
    public function delete_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.category.index')->with('error', 'Không có danh mục nào để xóa.');
        }

        $productsCount = Product::where('category_id', $ids)->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.category.index')->with('error', 'Danh mục này có sản phẩm liên quan, không thể xóa.');
        }

        // Cập nhật trạng thái
        $updated = Category::whereIn('id', $ids)->update([
            'status' => 0,
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.category.index')->with('success', 'Các danh mục đã được xóa.');
        } else {
            return redirect()->route('admin.category.index')->with('error', 'Không thể xóa các danh mục.');
        }
    }

    public function destroy_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.category.index')->with('error', 'Không có danh mục nào để xóa.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = Category::whereIn('id', $ids)->delete();

        if ($updated > 0) {
            return redirect()->route('admin.category.index')->with('success', 'Các danh mục đã được xóa.');
        } else {
            return redirect()->route('admin.category.index')->with('error', 'Không thể xóa các danh mục.');
        }
    }

    public function restore_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.category.index')->with('error', 'Không có danh mục nào để khôi phục.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = Category::whereIn('id', $ids)->update([
            'status' => 2, // Giả sử trạng thái 1 là "đã xuất bản"
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.category.index')->with('success', 'Các danh mục đã được khôi phục.');
        } else {
            return redirect()->route('admin.category.index')->with('error', 'Không thể khôi phục các danh mục.');
        }
    }
}
