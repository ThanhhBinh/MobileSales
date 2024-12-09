<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $itemsPerPage = $request->input('items_per_page', 7);

        // Thực hiện truy vấn và phân trang
        $roles = Roles::paginate($itemsPerPage);

        return view('backend.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.roles.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',        
            'description' => 'required|string|max:255',     
        ]);

        // Nếu tất cả hợp lệ, lưu vai trò
        $roles = new Roles();
        $roles->name = $request->name;
        $roles->description = $request->description;
        $roles->created_at = now();
        $roles->save();
    
        return redirect()->route('admin.roles.index')->with('success', 'Thêm vai trò thành công.');
    }

    public function edit(string $id)
    {
        $roles = Roles::find($id);

        return view('backend.roles.edit', compact('roles'));
    }

    public function update(Request $request, string $id)
    {
        $roles = Roles::find($id);

        // Kiểm tra nếu vai trò không tồn tại
        if ($roles == null) {
            return redirect()->route('admin.roles.index')->with('error', 'Vai trò không tồn tại.');
        }

        // Kiểm tra nếu vai trò là vai trò hệ thống
        if ($roles->is_system == 1) {
            return redirect()
                ->route('admin.roles.edit', ['id' => $roles->id])
                ->with('error', 'Vai trò hệ thống không thể chỉnh sửa.');
        }

        // Cập nhật thông tin vai trò
        $roles->name = $request->name;
        $roles->description = $request->description;
        $roles->updated_at = now();
        $roles->save();

        return redirect()->route('admin.roles.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy(string $id)
    {
        $roles = Roles::find($id);
        if ($roles == null) {
            return redirect()->route('admin.roles.index');
        }

        // Kiểm tra nếu vai trò là vai trò hệ thống
        if ($roles->is_system == 1) {
            return redirect()
                ->route('admin.roles.edit', ['id' => $roles->id])
                ->with('error', 'Vai trò hệ thống không thể xóa.');
        }

        $roles->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Xóa thành công');
    }
}
