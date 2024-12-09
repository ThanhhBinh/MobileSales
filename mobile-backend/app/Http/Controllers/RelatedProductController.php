<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\RelatedProduct;
use Illuminate\Http\Request;

class RelatedProductController extends Controller
{
    public function create_related_product(Request $request, $id)
    {
        $query = Product::where('products.status', '!=', 0)->where('products.id', '!=', $id)->join('categories', 'products.category_id', '=', 'categories.id')->join('brands', 'products.brand_id', '=', 'brands.id')->select('products.id as product_id', 'products.stock as product_stock', 'products.name as product_name', 'products.description', 'products.price', 'products.discount', 'products.slug', 'products.rating', 'products.status', 'categories.name as categoryname', 'brands.name as brandname');

        $categories = Category::all();
        $brands = Brand::all();
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
        $itemsPerPage = $request->input('items_per_page', 7);
        // Phân trang dữ liệu với các điều kiện lọc đã áp dụng
        $list = $query->paginate($itemsPerPage);

        return view('backend.product.createRelatedProduct', compact('list', 'categories', 'brands', 'id'));
    }

    public function store_related_product(Request $request)
    {
        $relatedIds = explode(',', $request->input('ids'));
        $mainProductId = $request->input('main_product_id');

        // Kiểm tra nếu không có sản phẩm liên quan nào được chọn
        if (empty($relatedIds) || !$mainProductId) {
            return redirect()->back()->with('error', 'Vui lòng chọn sản phẩm chính và ít nhất một sản phẩm liên quan.');
        }

        // Lưu từng sản phẩm liên quan
        foreach ($relatedIds as $relatedId) {
            // Kiểm tra nếu cặp sản phẩm liên quan đã tồn tại
            if (!RelatedProduct::where('product_id', $mainProductId)->where('related_id', $relatedId)->exists()) {
                RelatedProduct::create([
                    'product_id' => $mainProductId,
                    'related_id' => $relatedId,
                ]);
            }
        }

        return redirect()
            ->route('admin.product.edit', ['id' => $mainProductId])
            ->with('success', 'Sản phẩm liên quan đã được thêm thành công.');
    }

    public function delete_related_product(string $id)
    {
        $relatedproduct = RelatedProduct::find($id);
        if ($relatedproduct == null) {
            return redirect()->route('admin.product.edit',['id'=>$relatedproduct->product_id]);
        }
        $relatedproduct->delete();
        return redirect()->route('admin.product.edit',['id'=>$relatedproduct->product_id]);
    }

}
