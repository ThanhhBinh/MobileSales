<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function banners()
    {
        $banner = Banner::where('status', '!=', 0)->get();
        return response()->json($banner);
    }

    public function index(Request $request)
    {
        // Lấy danh sách các vị trí duy nhất
        $positions = Banner::where('status', '!=', 0)->select('position')->distinct()->pluck('position');

        // Khởi tạo truy vấn chính
        $query = Banner::where('status', '!=', 0)->orderBy('created_at', 'DESC');

        // Lọc theo tên nếu có
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Lọc theo vị trí nếu có
        if ($request->filled('position')) {
            $query->where('position', $request->input('position'));
        }

        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Lọc các banner có tên bắt đầu bằng chữ cái cụ thể nếu có
        if ($request->filled('starts_with')) {
            $query->where('name', 'like', $request->input('starts_with') . '%');
        }

        // Phân trang
        $itemsPerPage = $request->input('items_per_page', 7); // Mặc định là 7
        $banner = $query->paginate($itemsPerPage);

        return view('backend.banner.index', compact('banner', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $banner = new Banner();
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->link = $request->link;
        $banner->position = $request->position;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $exten = $file->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                // Đảm bảo slug từ id
                $filename = Str::of($request->id)->slug('-') . '-' . time() . '.' . $exten;
                // Di chuyển file vào thư mục đúng
                $file->move(public_path('images/banners'), $filename);
                $banner->image = $filename;
            }
        }
        $banner->status = $request->status;
        $banner->created_at = date('Y-m-d H:i:s');
        $banner->created_by = Auth::id() ?? 1;
        $banner->save();
        return redirect()->route('admin.banner.index')->with("success",'Thêm banner thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banner.index');
        }
        return view('backend.banner.show', compact('banner'));
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banner.index');
        }
        $list = Banner::where('status', '!=', 0)->orderBy('created_at', 'DESC')->get();

        return view('backend.banner.edit', compact('list', 'banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Lấy đối tượng Banner hiện tại từ cơ sở dữ liệu
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banner.index');
        }

        // Cập nhật thông tin banner
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->link = $request->link;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $exten = $file->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                // Đảm bảo slug từ id
                $filename = Str::of($request->id)->slug('-') . '-' . time() . '.' . $exten;
                // Di chuyển file vào thư mục đúng
                $file->move(public_path('images/banners'), $filename);
                $banner->image = $filename;
            }
        }
        $banner->status = $request->status;
        $banner->updated_at = date('Y-m-d H:i:s');
        $banner->updated_by = Auth::id() ?? 1;
        $banner->save();

        return redirect()->route('admin.banner.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banner.index');
        }
        $banner->status = 0;
        $banner->updated_at = date('Y-m-d H:i:s');
        $banner->updated_by = Auth::id() ?? 1;
        $banner->save();
        return redirect()->route('admin.banner.index');
    }

    public function trash()
    {
        $list = Banner::where('status', '=', 0)->select('id', 'position', 'link', 'image', 'name', 'status')->orderBy('created_at', 'DESC')->get();

        return view('backend.banner.trash', compact('list'));
    }

    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banner.index');
        }
        $banner->delete();
        return redirect()->route('admin.banner.trash');
    }

    public function restore(string $id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banner.index');
        }
        $banner->status = 2;
        $banner->updated_at = date('Y-m-d H:i:s');
        $banner->updated_by = Auth::id() ?? 0;
        $banner->save();
        return redirect()->route('admin.banner.index');
    }

    //status
    public function status(string $id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('admin.banner.index');
        }
        $banner->status = $banner->status == 1 ? 2 : 1;
        $banner->updated_at = date('Y-m-d H:i:s');
        $banner->save();
        return redirect()->route('admin.banner.index')->with('success', 'Thay đổi trạng thái thành công.');
    }

    public function destroy_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.banner.index')->with('error', 'Không có banner nào để xóa.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = banner::whereIn('id', $ids)->delete();

        if ($updated > 0) {
            return redirect()->route('admin.banner.trash')->with('success', 'Các banner đã được xóa.');
        } else {
            return redirect()->route('admin.banner.trash')->with('error', 'Không thể xóa các banner.');
        }
    }

    //Xóa banner đã chọn
    public function delete_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Cập nhật trạng thái
        $updated = banner::whereIn('id', $ids)->update([
            'status' => 0,
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.banner.index')->with('success', 'Các banner đã được xóa.');
        } else {
            return redirect()->route('admin.banner.index')->with('error', 'Không thể xóa các banner.');
        }
    }

    public function restore_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.banner.index')->with('error', 'Không có banner nào để khôi phục.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = banner::whereIn('id', $ids)->update([
            'status' => 2, // Giả sử trạng thái 1 là "đã xuất bản"
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.banner.index')->with('success', 'Các banner đã được khôi phục.');
        } else {
            return redirect()->route('admin.banner.index')->with('error', 'Không thể khôi phục các banner.');
        }
    }
}
