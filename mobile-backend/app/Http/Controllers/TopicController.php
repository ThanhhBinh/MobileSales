<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Xử lý tìm kiếm
        $query = Topic::where('status', '!=', 0);

        if ($request->filled('name')) {
            $searchTerm = $request->input('name');
            $firstLetter = strtoupper($searchTerm[0]);
            $query->where('name', 'LIKE', $firstLetter . '%'); 
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $topic = $query->orderBy('created_at', 'DESC')->paginate(5);

        return view('backend.topic.index', compact('topic'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.topic.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request)
    {
        // Tạo chủ đề mới
        $topic = new Topic();
        $topic->name = $request->input('name');
        $topic->slug = Str::of($request->name)->slug('-');
        $topic->sort_order = $request->input('sort_order');
        $topic->description = $request->input('description');
        $topic->status = $request->input('status');
        // Lưu chủ đề
        $topic->save();

        return redirect()->route('admin.topic.index')->with('success', 'Chủ đề đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = Topic::where('id', $id)->first();
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }

        return view('backend.topic.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
        $list = Topic::where('status', '!=', 0)->orderBy('created_at', 'DESC')->get();

        return view('backend.topic.edit', compact('list', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Tìm chủ đề theo ID
        $topic = Topic::find($id);
        if ($topic === null) {
            return redirect()->route('admin.topic.index');
        }

        // Cập nhật thông tin chủ đề
        $topic->name = $request->input('name');
        $topic->slug = $request->input('slug');
        $topic->sort_order = $request->input('sort_order');
        $topic->description = $request->input('description');
        $topic->status = $request->input('status');

        // Lưu chủ đề
        $topic->save();

        return redirect()->route('admin.topic.index')->with('success', 'Chủ đề đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
        $topic->status = $topic->status == 1 ? 2 : 1;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->save();
        return redirect()->route('admin.topic.index')->with('success','Thay đổi trạng thái thành công');
    }

    public function delete(string $id)
    {
        $postsCount = Post::where('topic_id', $id)->count();
 
        if ($postsCount > 0) {
            return redirect()->route('admin.topic.index')->with('error', 'chủ đề này có sản phẩm liên quan, không thể xóa.');
        }

        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
        $topic->status = 0;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = Auth::id() ?? 1;
        $topic->save();
        return redirect()->route('admin.topic.index')->with('success','Xóa thành công');
    }

    public function trash()
    {
        $list = Topic::where('status', '=', 0)->orderBy('created_at', 'DESC')->get();
        return view('backend.topic.trash', compact('list'));
    }

    public function restore(string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
        $topic->status = 2;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = Auth::id() ?? 1;
        $topic->save();
        return redirect()->route('admin.topic.index')->with('success','Khôi phục thành công');
    }

    public function destroy(string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
        $topic->delete();
        return redirect()->route('admin.topic.trash')->with('success','Xóa khỏi cơ sở dữ liệu thành công');
    }

     //Xóa chủ đề đã chọn
     public function delete_multiple(Request $request)
     {
         // Tách các ID từ input
         $ids = explode(',', $request->input('ids'));
 
         // Kiểm tra xem có ID nào không
         if (empty(array_filter($ids))) {
             return redirect()->route('admin.topic.index')->with('error', 'Không có chủ đề nào để xóa.');
         }
 
         $postsCount = Post::where('topic_id', $ids)->count();
 
         if ($postsCount > 0) {
             return redirect()->route('admin.topic.index')->with('error', 'chủ đề này có sản phẩm liên quan, không thể xóa.');
         }
 
         // Cập nhật trạng thái
         $updated = topic::whereIn('id', $ids)->update([
             'status' => 0,
             'updated_by' => Auth::id() ?? 1,
         ]);
 
         if ($updated > 0) {
             return redirect()->route('admin.topic.index')->with('success', 'Các chủ đề đã được xóa.');
         } else {
             return redirect()->route('admin.topic.index')->with('error', 'Không thể xóa các chủ đề.');
         }
     }
 
     public function destroy_multiple(Request $request)
     {
         // Tách các ID từ input
         $ids = explode(',', $request->input('ids'));
 
         // Kiểm tra xem có ID nào không
         if (empty(array_filter($ids))) {
             return redirect()->route('admin.topic.index')->with('error', 'Không có chủ đề nào để xóa.');
         }
 
         // Kiểm tra xem tất cả ID có hợp lệ không
         $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên
 
         // Cập nhật trạng thái
         $updated = topic::whereIn('id', $ids)->delete();
 
         if ($updated > 0) {
             return redirect()->route('admin.topic.index')->with('success', 'Các chủ đề đã được xóa.');
         } else {
             return redirect()->route('admin.topic.index')->with('error', 'Không thể xóa các chủ đề.');
         }
     }
 
     public function restore_multiple(Request $request)
     {
         // Tách các ID từ input
         $ids = explode(',', $request->input('ids'));
 
         // Kiểm tra xem có ID nào không
         if (empty(array_filter($ids))) {
             return redirect()->route('admin.topic.index')->with('error', 'Không có chủ đề nào để khôi phục.');
         }
 
         // Kiểm tra xem tất cả ID có hợp lệ không
         $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên
 
         // Cập nhật trạng thái
         $updated = topic::whereIn('id', $ids)->update([
             'status' => 2, // Giả sử trạng thái 1 là "đã xuất bản"
             'updated_by' => Auth::id() ?? 1,
         ]);
 
         if ($updated > 0) {
             return redirect()->route('admin.topic.index')->with('success', 'Các chủ đề đã được khôi phục.');
         } else {
             return redirect()->route('admin.topic.index')->with('error', 'Không thể khôi phục các chủ đề.');
         }
     }
}
