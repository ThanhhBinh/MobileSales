<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductReviewRequest;
use App\Http\Requests\UpdateProductReviewRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo truy vấn với điều kiện trạng thái
        $query = ProductReview::where('reviews.status', '!=', 0)
        ->join('products', 'reviews.product_id', '=', 'products.id')
        ->leftjoin('users', 'reviews.user_id', '=', 'users.user_id')
        ->select('reviews.review_id', 'reviews.title', 'reviews.review_text', 'reviews.replay', 'reviews.rating', 'reviews.status as review_status', 'reviews.created_at', 'products.id as product_id', 'products.name as productname', 'users.user_id', 'users.first_name as username', 'reviews.image')
        ->orderBy('reviews.created_at', 'DESC');

        //Lọc theo khoảng thời gian
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Kiểm tra ngày nhập vào
        if ($startDate && $endDate) {
            if ($startDate <= $endDate) {
                $query->whereBetween('reviews.created_at', [$startDate, $endDate . ' 23:59:59']);
            } else {
                return back()->withErrors(['date' => 'Ngày bắt đầu không thể lớn hơn ngày kết thúc.']);
            }
        } elseif ($startDate) {
            $query->where('reviews.created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('reviews.created_at', '<=', $endDate . ' 23:59:59');
        }

        // Lọc theo tên sản phẩm nếu có
        if ($request->filled('name')) {
            $query->where('products.name', 'like', '%' . $request->input('name') . '%');
        }

        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('reviews.status', $request->input('status'));
        }

        // Lọc các sản phẩm có tên bắt đầu bằng chữ cái cụ thể nếu có
        if ($request->filled('starts_with')) {
            $query->where('products.name', 'like', $request->input('starts_with') . '%');
        }

        // Lấy số mục mỗi trang từ request, mặc định là 7
        $itemsPerPage = $request->input('items_per_page', 7);

        // Phân trang dữ liệu với các điều kiện lọc đã áp dụng
        $reviews = $query->paginate($itemsPerPage);
        // Trả về view với dữ liệu đã phân trang
        $reviews->getCollection()->transform(function ($product) {
            $media = Media::where([['product_id', '=', $product->product_id], ['media_type', '=', 'image']])->first();

            $product->media_url = $media ? $media->media_url : null; // Thêm URL hình ảnh hoặc null
            return $product;
        });
        return view('backend.productreview.index', compact('reviews'));
    }

    public function replay(string $id)
    {
        // Tìm đúng đánh giá dựa trên ID
        $list = ProductReview::where('reviews.review_id', $id)->where('reviews.status', '!=', 0)->join('products', 'reviews.product_id', '=', 'products.id')->leftJoin('users', 'reviews.user_id', '=', 'users.user_id')->select('reviews.review_id', 'reviews.title', 'reviews.review_text', 'reviews.replay', 'reviews.rating', 'reviews.status as review_status', 'reviews.created_at', 'products.id as product_id', 'products.name as productname', 'users.user_id', 'users.first_name as username', 'reviews.image')->first();

        // Kiểm tra nếu không tìm thấy đánh giá
        if ($list == null) {
            return redirect()->route('admin.productreview.index')->with('error', 'Không tìm thấy đánh giá.');
        }

        // Trả về view với dữ liệu đánh giá cụ thể
        return view('backend.productreview.replay', compact('list'));
    }

    public function replayid(Request $request, string $id)
    {
        $productreview = productreview::find($id);
        if ($productreview == null) {
            return redirect()->route('admin.productreview.index');
        }

        $productreview->title = $request->title;
        $productreview->replay = $request->replay;
        $productreview->review_text = $request->review_text;
        $productreview->status = $request->status;
        $productreview->updated_at = date('Y-m-d H:i:s');
        $productreview->updated_by = Auth::id() ?? 1;

        // Lưu các thay đổi
        $productreview->save();

        return redirect()->route('admin.productreview.index')->with('success', 'Trả lời đánh giá thành công.');
    }

    //Xóa khỏi csdl
    public function destroy(string $id)
    {
        $productreview = productreview::find($id);
        if ($productreview == null) {
            return redirect()->route('admin.productreview.index');
        }
        $productreview->delete();
        return redirect()->route('admin.productreview.trash')->with('success', 'Xóa thành công');
    }

    //Khôi phục
    public function restore(string $id)
    {
        $productreview = productreview::find($id);
        if ($productreview == null) {
            return redirect()->route('admin.productreview.index');
        }
        $productreview->status = 2;
        $productreview->updated_at = date('Y-m-d H:i:s');
        $productreview->updated_by = Auth::id() ?? 1;
        $productreview->save();
        return redirect()->route('admin.productreview.index')->with('success', 'Khôi phục thành công.');
    }

    //Thùng rác
    public function trash()
    {
        $list = productreview::where('reviews.status', '=', 0)->join('products', 'reviews.product_id', '=', 'products.id')->leftJoin('users', 'reviews.user_id', '=', 'users.user_id')->select('reviews.review_id', 'reviews.title', 'reviews.review_text', 'reviews.replay', 'reviews.rating', 'reviews.status as review_status', 'reviews.created_at', 'products.id as product_id', 'products.name as productname', 'users.user_id', 'users.first_name as username', 'reviews.image')->get();
        return view('backend.productreview.trash', compact('list'));
    }

    //Xóa đánh giá đã chọn
    public function delete_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.productreview.index')->with('error', 'Không có đánh giá nào để xóa.');
        }

        // Cập nhật trạng thái
        $updated = productreview::whereIn('review_id', $ids)->update([
            'status' => 0,
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.productreview.index')->with('success', 'Các đánh giá đã được xóa.');
        } else {
            return redirect()->route('admin.productreview.index')->with('error', 'Không thể xóa các đánh giá.');
        }
    }

    //Phê duyệt nhiều đánh giá
    public function publish_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.productreview.index')->with('error', 'Không có đánh giá nào để phê duyệt.');
        }

        $updated = productreview::whereIn('review_id', $ids)->update([
            'status' => 1,
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.productreview.index')->with('success', 'Các đánh giá đã được phê duyệt.');
        } else {
            return redirect()->route('admin.productreview.index')->with('error', 'Không thể phê duyệt các đánh giá.');
        }
    }

    public function unpublish_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.productreview.index')->with('error', 'Không có đánh giá nào để không chấp nhận.');
        }

        // Cập nhật trạng thái
        $updated = productreview::whereIn('review_id', $ids)->update([
            'status' => 2,
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.productreview.index')->with('success', 'Các đánh giá đã được không chấp nhận.');
        } else {
            return redirect()->route('admin.productreview.index')->with('error', 'Không thể không chấp nhận các đánh giá.');
        }
    }
    //Xóa nhiều đánh giá ra khỏi csdl
    public function destroy_multiple(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.productreview.index')->with('error', 'Không có đánh giá nào để xóa.');
        }

        $ids = array_map('intval', $ids);

        // Cập nhật trạng thái
        $updated = ProductReview::whereIn('review_id', $ids)->delete();

        if ($updated > 0) {
            return redirect()->route('admin.productreview.index')->with('success', 'Các đánh giá đã được xóa.');
        } else {
            return redirect()->route('admin.productreview.index')->with('error', 'Không thể xóa các đánh giá.');
        }
    }

    //Khôi phục
    public function restore_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.productreview.index')->with('error', 'Không có đánh giá nào để khôi phục.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = ProductReview::whereIn('review_id', $ids)->update([
            'status' => 2, // Giả sử trạng thái 1 là "đã xuất bản"
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.productreview.index')->with('success', 'Các đánh giá đã được khôi phục.');
        } else {
            return redirect()->route('admin.productreview.index')->with('error', 'Không thể khôi phục các đánh giá.');
        }
    }
}
