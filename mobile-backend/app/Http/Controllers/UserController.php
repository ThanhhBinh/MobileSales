<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách các vai trò
        $roles = Roles::all();

        // Khởi tạo truy vấn cho User
        $query = User::where('status', '!=', 0);

        // Lọc theo khoảng thời gian
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Kiểm tra ngày bắt đầu và ngày kết thúc cho created_at
        if ($request->filled('start_date') && $request->filled('end_date')) {
            if ($startDate <= $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            } else {
                return back()->withErrors(['date' => 'Ngày bắt đầu không thể lớn hơn ngày kết thúc.']);
            }
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', $startDate);
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', $endDate . ' 23:59:59');
        }

        // Lọc theo khoảng thời gian cho updated_at
        $start_actionDate = $request->input('start_action_date');
        $end_actionDate = $request->input('end_action_date');

        // Kiểm tra ngày bắt đầu và ngày kết thúc cho updated_at
        if ($request->filled('start_action_date') && $request->filled('end_action_date')) {
            if ($start_actionDate <= $end_actionDate) {
                $query->whereBetween('updated_at', [$start_actionDate, $end_actionDate . ' 23:59:59']);
            } else {
                return back()->withErrors(['date' => 'Ngày bắt đầu không thể lớn hơn ngày kết thúc.']);
            }
        } elseif ($request->filled('start_action_date')) {
            $query->where('updated_at', '>=', $start_actionDate);
        } elseif ($request->filled('end_action_date')) {
            $query->where('updated_at', '<=', $end_actionDate . ' 23:59:59');
        }

        // Lọc theo vai trò (role)
        if ($request->filled('roles')) {
            $query->where('role_id', '=', $request->roles);
        }

        // Lọc theo email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Lọc theo phone
        if ($request->filled('phone')) {
            $query->where('phone', $request->phone);
        }

        // Lọc theo tên
        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }

        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }

        // Paginate kết quả
        $list = $query->orderBy('created_at', 'DESC')->paginate(7);

        // Trả về view với dữ liệu
        return view('backend.user.index', compact('list', 'roles'));
    }

    public function create()
    {
        return view('backend.user.create');
    }

    public function store(Request $request)
    {
        // Mã hóa mật khẩu
        $hashedPassword = bcrypt($request->password);

        // Tạo đối tượng người dùng mới
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = $hashedPassword;
        $user->status = $request->status;

        // Xử lý hình ảnh nếu có
        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::slug($request->input('name'), '-') . '.' . $exten;
                $request->file('image')->move(public_path('images/users'), $filename);
                $user->image = $filename;
            } else {
                return back()->with('error', 'Định dạng hình ảnh không hợp lệ!');
            }
        }

        $user->save();

        // Chuyển hướng và thông báo thành công
        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    public function edit(string $id)
    {
        // Lấy thông tin người dùng
        $user = User::join('roles', 'users.role_id', '=', 'roles.id')->where('users.user_id', $id)->select('users.*', 'roles.name as role_name')->first();

        // Kiểm tra nếu người dùng không tồn tại
        if (!$user) {
            return redirect()->route('admin.user.index')->with('error', 'Người dùng không tồn tại.');
        }

        $roles = Roles::all();

        // Lấy địa chỉ của người dùng
        $addresses = Address::where('user_id', $id)->get();

        // Lấy các đơn hàng của người dùng
        $orders = Order::where('user_id', $id)->get();

        // Trả về view với các dữ liệu cần thiết
        return view('backend.user.edit', compact('user', 'addresses', 'orders', 'roles'));
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('admin.user.index');
        }

        // Validate the gender field
        $request->validate([
            'gender' => 'required|in:male,female',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($user->role_id == 1) {
            return redirect()
                ->route('admin.user.edit', ['user_id' => $user_id])
                ->with('error', 'Không thể cập nhật vai trò hệ thống.');
        }

        $user->role_id = $request->role_id;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được cập nhật thành công.');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('admin.user.index');
        }

        $productsCount = Order::where('user_id', $id)->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.user.index')->with('error', 'Có đơn hàng liên quan đến người dùng này, không thể xóa.');
        }

        if ($user->role_id == 1) {
            return redirect()
                ->route('admin.user.edit', ['user_id' =>$id])
                ->with('error', 'Không thể xóa vai trò hệ thống.');
        }
        
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được xóa vĩnh viễn.');
    }
}
