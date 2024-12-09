<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //index
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();

        // Khởi tạo query với các điều kiện lọc
        $query = Product::where('products.status', '!=', 0)->leftJoin('categories', 'products.category_id', '=', 'categories.id')->leftJoin('brands', 'products.brand_id', '=', 'brands.id')->select('products.id as product_id', 'products.stock as product_stock', 'products.name as product_name', 'products.description', 'products.price', 'products.discount', 'products.slug', 'products.rating', 'products.status', 'categories.name as categoryname', 'brands.name as brandname');

        // Áp dụng các bộ lọc
        if ($request->filled('name')) {
            $query->where('products.name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('category_id') && $request->input('category_id') != 0) {
            $query->where('products.category_id', $request->input('category_id'));
        }

        if ($request->filled('brand_id') && $request->input('brand_id') != 0) {
            $query->where('products.brand_id', $request->input('brand_id'));
        }

        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('products.status', $request->input('status'));
        }

        // Lấy số mục mỗi trang từ request, mặc định là 7
        $itemsPerPage = $request->input('items_per_page', 7);

        // Phân trang dữ liệu với các điều kiện lọc đã áp dụng
        $list = $query->paginate($itemsPerPage);

        // Gắn thêm hình ảnh cho từng sản phẩm
        $list->getCollection()->transform(function ($product) {
            $media = Media::where([['product_id', '=', $product->product_id], ['media_type', '=', 'image']])->first();

            $product->media_url = $media ? $media->media_url : null; // Thêm URL hình ảnh hoặc null
            return $product;
        });

        return view('backend.product.index', compact('list', 'categories', 'brands'));
    }

    //create
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        $htmlcategoryid = '';
        $htmlbrandid = '';

        foreach ($categories as $category) {
            $htmlcategoryid .= "<option value='" . $category->id . "'>" . $category->name . '</option>';
        }

        foreach ($brands as $brand) {
            $htmlbrandid .= "<option value='" . $brand->id . "'>" . $brand->name . '</option>';
        }

        return view('backend.product.create', compact('htmlcategoryid', 'htmlbrandid'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product = new Product();
        // Cập nhật thông tin sản phẩm
        $product->name = $request->name;
        $product->slug = Str::of($request->name)->slug('-');
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->status = $request->status;
        $product->updated_at = now();
        $product->updated_by = Auth::id() ?? 1;
        $product->save();

        $shipping = new Shipping();
        $shipping->product_id = $product->id;
        $shipping->weight = $request->weight;
        $shipping->length = $request->length;
        $shipping->width = $request->width;
        $shipping->height = $request->height;
        $shipping->free_shipping = $request->free_shipping;
        $shipping->ship_separately = $request->ship_separately;
        $shipping->additional_shipping_charge = $request->additional_shipping_charge;
        $shipping->delivery_date = $request->delivery_date;
        $shipping->save();

        if ($request->has('saveAndEdit')) {
            // Redirect đến trang chỉnh sửa sản phẩm vừa lưu
            return redirect()
                ->route('admin.product.edit', $product->id)
                ->with('success', 'Sản phẩm đã được lưu. Tiếp tục chỉnh sửa.');
        }

        // Chuyển hướng về trang danh sách sản phẩm
        return redirect()->route('admin.product.index')->with('success', 'Thêm sản phẩm thành công');
    }

    //Cập nhật
    public function edit(Request $request, string $id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('admin.product.index');
        }

        // Fetch categories, brands, and media for dropdowns and other UI elements
        $categories = Category::all();
        $brands = Brand::all();
        $media = Media::all();

        // Fetch shipping information for the product
        $shipping = Shipping::where('product_id', $id)->first();

        // Fetch related products for the given product
        $relateproduct = RelatedProduct::where('product_id', $id)
        ->join('products', 'related_products.related_id', '=', 'products.id')
        ->select('products.name as productname', 'products.price as productprice', 'related_products.sort_order', 'related_products.product_id', 'related_products.related_id', 'related_products.id')
        ->paginate(7);

        // Fetch media items related to the product
        $mediaItems = DB::table('media')->join('products', 'media.product_id', '=', 'products.id')
        ->select('media.*', 'products.name as product_name')->get();

        // Define number of items per page for pagination
        $itemsPerPage = $request->input('items_per_page', 7);

        // Paginate related products (if needed) or any other collection you want to paginate
        // Example for pagination on a list of products (if required)
        $list = Product::paginate($itemsPerPage);

        // Return the view with the data
        return view('backend.product.edit', compact('product', 'categories', 'brands', 'media', 'mediaItems', 'shipping', 'list', 'relateproduct'));
    }

    //Cập nhật
    public function update(Request $request, string $id)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Tìm sản phẩm theo ID
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.product.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        // Cập nhật thông tin sản phẩm
        $product->name = $request->name;
        $product->slug = Str::of($request->name)->slug('-');
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->status = $request->status;
        $product->updated_at = now();
        $product->updated_by = Auth::id() ?? 1;
        $product->save();

        // Kiểm tra và cập nhật hoặc tạo mới thông tin vận chuyển
        $shipping = Shipping::firstOrNew(['product_id' => $product->id]);
        $shipping->weight = $request->weight;
        $shipping->length = $request->length;
        $shipping->width = $request->width;
        $shipping->height = $request->height;
        $shipping->free_shipping = $request->free_shipping;
        $shipping->ship_separately = $request->ship_separately;
        $shipping->additional_shipping_charge = $request->additional_shipping_charge;
        $shipping->delivery_date = $request->delivery_date;
        $shipping->save();

        // Kiểm tra nút bấm và chuyển hướng
        if ($request->has('saveAndEdit')) {
            return redirect()
                ->route('admin.product.edit', $product->id)
                ->with('success', 'Sản phẩm đã được lưu. Tiếp tục chỉnh sửa.');
        }

        return redirect()->route('admin.product.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    //Trạng thái
    public function status(string $id)
    {
        $product = product::find($id);
        if ($product == null) {
            return redirect()->route('admin.product.index');
        }
        $product->status = $product->status == 1 ? 2 : 1;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->save();
        return redirect()->route('admin.product.index')->with('success', 'Thay đổi trạng thái thành công.');
    }

    //thùng rác
    public function trash()
    {
        // Lấy danh sách sản phẩm có trạng thái `0` (trong thùng rác)
        $list = Product::where('status', '=', 0)->orderBy('created_at', 'DESC')->get();

        // Duyệt qua từng sản phẩm để thêm thông tin media
        $list->transform(function ($product) {
            $media = Media::where([
                ['product_id', '=', $product->id], // Dùng `id` thay vì `product_id` vì đây là sản phẩm
                ['media_type', '=', 'image'],
            ])->first();

            // Thêm thuộc tính media_url cho sản phẩm
            $product->media_url = $media ? $media->media_url : null;

            return $product;
        });

        // Trả về view với danh sách sản phẩm
        return view('backend.product.trash', compact('list'));
    }

    // xóa khỏi csdl
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product == null) {
            return redirect()->route('admin.product.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        try {
            DB::beginTransaction();

            // Lấy các hình ảnh liên quan đến sản phẩm
            $mediaItems = Media::where('product_id', $product->id)->get();

            // Xóa các file hình ảnh khỏi hệ thống lưu trữ
            foreach ($mediaItems as $media) {
                if (!empty($media->path) && Storage::exists($media->path)) {
                    Storage::delete($media->path);
                }
            }

            // Xóa các bản ghi trong bảng `Media`
            Media::where('product_id', $product->id)->delete();

            // Xóa sản phẩm
            $product->delete();

            DB::commit();

            return redirect()->route('admin.product.trash')->with('success', 'Xóa sản phẩm và các hình ảnh liên quan thành công.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    //xóa khỏi index
    public function delete(string $id)
    {
        $product = product::find($id);
        if ($product == null) {
            return redirect()->route('admin.product.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        // Tiến hành xóa nếu không có sản phẩm liên quan
        $product->status = 0;
        $product->updated_at = now();
        $product->updated_by = Auth::id() ?? 1;
        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được xóa vào thùng rác.');
    }

    // Khôi phục
    public function restore(string $id)
    {
        $product = product::find($id);
        if ($product == null) {
            return redirect()->route('admin.product.index');
        }
        $product->status = 2;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = Auth::id() ?? 1;
        $product->save();
        return redirect()->route('admin.product.index')->with('success', 'Khôi phục sản phẩm thành công.');
    }

    //Xóa Sản phẩm đã chọn
    public function delete_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.product.index')->with('error', 'Không có sản phẩm nào để xóa.');
        }

        // Cập nhật trạng thái
        $updated = Product::whereIn('id', $ids)->update([
            'status' => 0,
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.product.index')->with('success', 'Các sản phẩm đã được xóa.');
        } else {
            return redirect()->route('admin.product.index')->with('error', 'Không thể xóa các sản phẩm.');
        }
    }

    public function destroy_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.product.index')->with('error', 'Không có Sản phẩm nào để xóa.');
        }

        // Chuyển đổi tất cả ID thành số nguyên
        $ids = array_map('intval', $ids);

        try {
            DB::beginTransaction();

            // Lấy tất cả các hình ảnh liên quan đến sản phẩm
            $mediaItems = Media::whereIn('product_id', $ids)->get();

            // Xóa các file hình ảnh từ hệ thống lưu trữ
            foreach ($mediaItems as $media) {
                if (!empty($media->path) && Storage::exists($media->path)) {
                    Storage::delete($media->path);
                }
            }

            // Xóa các bản ghi trong bảng `Media`
            Media::whereIn('product_id', $ids)->delete();

            // Xóa các sản phẩm
            Product::whereIn('id', $ids)->delete();

            DB::commit();

            return redirect()->route('admin.product.index')->with('success', 'Các sản phẩm và hình ảnh liên quan đã được xóa.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    public function restore_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.product.index')->with('error', 'Không có Sản phẩm nào để khôi phục.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = product::whereIn('id', $ids)->update([
            'status' => 2, // Giả sử trạng thái 1 là "đã xuất bản"
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.product.index')->with('success', 'Các Sản phẩm đã được khôi phục.');
        } else {
            return redirect()->route('admin.product.index')->with('error', 'Không thể khôi phục các Sản phẩm.');
        }
    }
}
