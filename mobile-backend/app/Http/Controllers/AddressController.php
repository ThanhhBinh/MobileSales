<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function create_address($user_id)
    {
        return view('backend.user.create_address', compact('user_id'));
    }

    public function store_address(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);
        // dd($request->all());
        // Nếu tất cả hợp lệ, lưu địa chỉ
        $address = new Address();
        $address->user_id = $request->user_id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->phone = $request->phone;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;

        // Lưu địa chỉ vào cơ sở dữ liệu
        $address->save();

        // Chuyển hướng về trang chỉnh sửa người dùng và thông báo thành công
        return redirect()
            ->route('admin.user.edit', ['user_id' => $address->user_id])
            ->with('success', 'Thêm địa chỉ thành công.');
    }

    public function edit_address(string $id)
    {
        $address = address::find($id);

        return view('backend.user.edit_address', compact('address'));
    }

    public function update_address(Request $request, string $id)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);
        
        // Tìm địa chỉ cần cập nhật theo ID
        $address = Address::find($id);

        // Cập nhật thông tin địa chỉ
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->phone = $request->phone;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->user_id = $request->user_id;
        $address->postal_code = $request->postal_code;
        $address->updated_at = now();
        // Lưu lại thay đổi
        $address->save();

        // Chuyển hướng về trang chỉnh sửa người dùng và thông báo thành công
        return redirect()->route('admin.user.edit', $address->user_id)->with('success', 'Cập nhật địa chỉ thành công.');
    }

    public function destroy_address($id)
    {
        $address = Address::findOrFail($id);
        if ($address == null) {
            return redirect()->route('admin.user.edit',['user_id'=>$address->user_id]);
        }
        $address->delete();
        return redirect()->route('admin.user.edit',['user_id'=>$address->user_id])->with('success','Xóa thành công');
    }
}
