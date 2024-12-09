<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
{
    // Lấy danh sách tất cả topics để hiển thị trên giao diện lọc
    $topics = Topic::all();

    // Khởi tạo truy vấn với các điều kiện mặc định
    $query = Post::where('posts.status', '!=', 0)
        ->join('topics', 'posts.topic_id', '=', 'topics.id')
        ->select(
            'posts.id as postid',
            'posts.title',
            'posts.sort_order',
            'posts.type',
            'topics.id as topicid',
            'topics.name as topicname',
            'posts.status as poststatus',
            'posts.image'
        );

    // Xử lý tìm kiếm theo tiêu đề
    if ($request->filled('title')) {
        $searchTerm = $request->input('title');
        $firstLetter = strtoupper(substr($searchTerm, 0, 1)); // Lấy ký tự đầu tiên
        $query->where('posts.title', 'LIKE', $firstLetter . '%');
    }

    // Lọc theo trạng thái
    if ($request->filled('status')) {
        $query->where('posts.status', $request->input('status'));
    }

    if ($request->filled('type')) {
        $query->where('posts.type', $request->input('type'));
    }

    // Lọc theo topic ID nếu có
    if ($request->filled('topic_id') && $request->input('topic_id') != 0) {
        $query->where('posts.topic_id', $request->input('topic_id'));
    }

    // Sắp xếp theo ngày tạo và phân trang
    $post = $query->orderBy('posts.created_at', 'DESC')->paginate(5);

    // Trả về view với dữ liệu đã xử lý
    return view("backend.post.index", compact('post', 'topics'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list = Post::where('status', '!=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        $topics = Topic::all(); // Lấy tất cả các chủ đề

        $htmlparentid = '';
        $htmlsortorder = '';
        foreach ($list as $row) {
            $htmlparentid .= "<option value='" . $row->id . "'>" . $row->title . "</option>";
            $htmlsortorder .= "<option value='" . ($row->sort_order + 1) . "'>Sau: " . $row->title . "</option>";
        }

        return view('backend.post.create', compact('list', 'htmlparentid', 'htmlsortorder', 'topics'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Tạo mới bài viết
        $post = new Post();
        $post->title = $request->title;
        $post->detail = $request->detail;
        $post->description = $request->description;
        $post->topic_id = $request->topic_id;
        $post->type = $request->type;

        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::of($request->post_name)->slug('-') . '.' . $exten;
                $request->image->move(public_path('images/posts'), $filename);
                $post->image = $filename;
            }
        }

        $post->status = $request->status;
        $post->updated_at = now();
        $post->updated_by = Auth::id() ?? 1;
        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Bài viết đã được lưu thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::where('id', $id)->first();
        if ($post ==  null) {
            return redirect()->route('admin.post.index');
        }

        return view("backend.post.show", compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::where('id', $id)->first();
        if ($post === null) {
            return redirect()->route('admin.post.index');
        }

        $list = Post::where('status', '!=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        $topics = Topic::all(); // Lấy tất cả các chủ đề


        return view("backend.post.edit", compact('list', 'post', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::where('id', $id)->first();
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        
        $post->title = $request->title;
        $post->detail = $request->detail;
        $post->description = $request->description;
        $post->topic_id = $request->topic_id;
        $post->type = $request->type;
        
        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::of($request->post_name)->slug('-') . '-' . uniqid() . '.' . $exten;
                $request->image->move(public_path('images/posts'), $filename);
                $post->image = $filename;
            }
        }
        
        $post->status = $request->status;
        $post->updated_at = now();
        $post->updated_by = Auth::id() ?? 1;
        $post->save();
        
        return redirect()->route('admin.post.index')->with('success','Cập nhật thành công');
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->status = ($post->status == 1) ? 2 : 1;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->save();
        return redirect()->route('admin.post.index')->with('success','Thay đổi trạng thái thành công');
    }
    public function delete(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->status = 0;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::id() ?? 1;
        $post->save();
        return redirect()->route('admin.post.index')->with('success','Xóa thành công');
    }
    public function trash()
    {
        $list = Post::where('status', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view("backend.post.trash", compact('list'));
    }
    public function restore(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->status = 2;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::id() ?? 1;
        $post->save();
        return redirect()->route('admin.post.trash')->with('success','Khôi phục thành công');
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->delete();
        return redirect()->route('admin.post.trash')->with('success','Xóa khỏi cơ sở dữ liệu thành công');
    }

    public function destroy_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.post.index')->with('error', 'Không có post nào để xóa.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = post::whereIn('id', $ids)->delete();

        if ($updated > 0) {
            return redirect()->route('admin.post.trash')->with('success', 'Các post đã được xóa.');
        } else {
            return redirect()->route('admin.post.trash')->with('error', 'Không thể xóa các post.');
        }
    }

    //Xóa post đã chọn
    public function delete_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Cập nhật trạng thái
        $updated = post::whereIn('id', $ids)->update([
            'status' => 0,
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.post.index')->with('success', 'Các post đã được xóa.');
        } else {
            return redirect()->route('admin.post.index')->with('error', 'Không thể xóa các post.');
        }
    }

    public function restore_multiple(Request $request)
    {
        // Tách các ID từ input
        $ids = explode(',', $request->input('ids'));

        // Kiểm tra xem có ID nào không
        if (empty(array_filter($ids))) {
            return redirect()->route('admin.post.index')->with('error', 'Không có post nào để khôi phục.');
        }

        // Kiểm tra xem tất cả ID có hợp lệ không
        $ids = array_map('intval', $ids); // Chuyển đổi tất cả ID thành số nguyên

        // Cập nhật trạng thái
        $updated = post::whereIn('id', $ids)->update([
            'status' => 2, // Giả sử trạng thái 1 là "đã xuất bản"
            'updated_by' => Auth::id() ?? 1,
        ]);

        if ($updated > 0) {
            return redirect()->route('admin.post.index')->with('success', 'Các post đã được khôi phục.');
        } else {
            return redirect()->route('admin.post.index')->with('error', 'Không thể khôi phục các post.');
        }
    }
}
