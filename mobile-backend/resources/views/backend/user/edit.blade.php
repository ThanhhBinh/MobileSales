@extends('layouts.admin')
@section('title', 'Cập nhập người dùng')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa thông tin người dùng - {{ $user->last_name }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <form action="{{ route('admin.user.destroy', $user->user_id) }}" method="post"
                        class="d-inline">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" name="delete" type="submit">
                            <i class="fas fa-trash"></i> Xóa bỏ
                        </button>
                    </form>
                    <!-- Nút quay về danh sách người dùng -->
                    <a href="{{ route('admin.user.index') }}" class="btn btn-info ml-2">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card card-body">

            {{-- Thông báo thành công --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Thông báo thất bại --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Thông tin người dùng --}}
            <div class="row">
                <div class="col-12 border-bottom pb-2 mb-3">
                    <i style="font-size: 20px" class="fas fa-info"></i>
                    <span style="font-size: 20px; margin-left:5px">Thông tin người dùng</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.user.update', $user->user_id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Email -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Email :</label>
                            <div class="col-md-9">
                                <input type="email" value="{{ old('email', $user->email) }}" name="email" id="email"
                                    class="form-control">
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Username :</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('username', $user->username) }}" name="username"
                                    id="username" class="form-control">
                            </div>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Mật khẩu :</label>
                            <div class="col-md-9">
                                <input type="password" value="{{ old('password', $user->password) }}" name="password"
                                    id="password" class="form-control">
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- First Name -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tên đầu tiên:</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('last_name', $user->last_name) }}" name="last_name"
                                    id="last_name" class="form-control">
                            </div>
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Họ :</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('first_name', $user->first_name) }}" name="first_name"
                                    id="first_name" class="form-control">
                            </div>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Số điện thoại :</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('phone', $user->phone) }}" name="phone"
                                    id="phone" class="form-control">
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Giới tính :</label>
                            <div class="col-md-9">
                                <!-- Nam giới -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_male"
                                        value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="gender_male">Nam giới</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_female"
                                        value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="gender_female">Nữ giới</label>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Hình ảnh :</label>
                            <div class="col-md-9">
                                <input onchange="previewImage(event)" type="file" name="image" id="image"
                                    class="form-control">
                                @if ($user->image)
                                    <div class="row">
                                        <div class="col-2">
                                            <img id="preview" src="{{ asset('images/users/' . $user->image) }}"
                                                alt="{{ $user->first_name }}" class="img-thumbnail mt-2" width="100">
                                        </div>
                                        <div class="col-10 d-flex align-items-center">
                                            <button type="button" onclick="removeImage()" id="remove-btn"
                                                class="btn btn-danger mt-5">
                                                Xóa hình
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-2">
                                            <img id="preview" src="#" alt="Xem trước ảnh"
                                                style="width: 150px; display: none;" />
                                        </div>
                                        <div class="col-10 d-flex align-items-center">
                                            <button type="button" onclick="removeImage()" style="display: none;"
                                                id="remove-btn" class="btn btn-danger mt-5">
                                                Xóa hình
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Vai trò của người dùng:</label>
                            <div class="col-md-9">
                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">Chọn vai trò</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Trạng thái:</label>
                            <div class="col-md-9">
                                <select name="status" id="status" class="form-control">
                                    <option value="2" {{ old('status', $user->status) == 2 ? 'selected' : '' }}>Chưa
                                        xuất bản
                                    </option>
                                    <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Xuất
                                        bản
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Created At (disabled) -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Được tạo ra vào :</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('created_at', $user->created_at) }}"
                                    name="created_at" id="created_at" class="form-control" disabled>
                            </div>
                        </div>

                        <!-- Updated At (disabled) -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Hoạt động cuối cùng :</label>
                            <div class="col-md-9">
                                <input type="text" value="{{ old('updated_at', $user->updated_at) }}"
                                    name="updated_at" id="updated_at" class="form-control" disabled>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Đơn hàng --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                    <div class="card-header with-border clearfix">
                        <div class="card-title">
                            <i class="fas fa-cart-plus mr-2"></i>
                            Đơn hàng
                        </div>
                        <div class="card-tools float-right">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa toggle-icon fa-minus"></i> </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <form method="GET" action="{{ route('admin.user.index') }}" class="form-horizontal">
                                <div class="search-body">
                                    <div class="row">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width:150px">Đặt hàng #</th>
                                                    <th class="text-center" style="width:200px">Tổng đơn hàng</th>
                                                    <th class="text-center">Trạng thái đơn hàng</th>
                                                    <th class="text-center" style="width:200px">Trạng thái thanh toán</th>
                                                    <th class="text-center">Tình trạng vận chuyển</th>
                                                    <th class="text-center" style="width:150px">Được tạo ra vào</th>
                                                    <th class="text-center" style="width:100px">Xem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($orders as $order)
                                                    <tr>
                                                        <td class="text-center">{{ $order->order_id }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($order->total_order, 0, ',', '.') }} VND</td>
                                                        <td class="text-center">{{ $order->status }}</td>
                                                        <td class="text-center">{{ $order->payment_method_id }}</td>
                                                        <td class="text-center">{{ $order->shipping_status_id }}</td>
                                                        <td class="text-center">
                                                            {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.order.edit', $order->order_id) }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="fas fa-eye"></i> Xem
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <div class="alert alert-info">
                                                                Không có đơn hàng nào
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Địa chỉ --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                    <div class="card-header with-border clearfix">
                        <div class="card-title">
                            <i class="far fa-address-book mr-2"></i>
                            Địa chỉ
                        </div>
                        <div class="card-tools float-right">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa toggle-icon fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <form method="GET" action="{{ route('admin.user.index') }}" class="form-horizontal">
                                <div class="search-body">
                                    <div class="row">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width:150px">Tên đầu tiên</th>
                                                    <th class="text-center" style="width:200px">Họ</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center" style="width:200px">Số điện thoại</th>
                                                    <th class="text-center">Địa chỉ</th>
                                                    <th class="text-center" style="width:150px">Chỉnh sửa</th>
                                                    <th class="text-center" style="width:100px">Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($addresses->isNotEmpty())
                                                    @foreach ($addresses as $address)
                                                        <tr>
                                                            <td>{{ $user->first_name }}</td>
                                                            <td>{{ $user->last_name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->phone }}</td>
                                                            <td>{{ $address->address }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('admin.user.edit_address', $address->id) }}"
                                                                    class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <form method="POST"
                                                                    action="{{ route('admin.user.destroy_address', $address->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        <i class="fas fa-trash-alt"></i> Xóa
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <div class="alert alert-info">
                                                                Không có địa chỉ nào cho người dùng này.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="col text-center">
                                            <a class="btn btn-success"
                                                href="{{ route('admin.user.create_address', ['user_id' => $user->user_id]) }}">
                                                <i class="fas fa-plus"></i> Thêm địa chỉ mới
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Hiện hình ảnh xem trước
                    document.getElementById('remove-btn').style.display = 'block'; // Hiện nút xóa
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('preview');
            const removeBtn = document.getElementById('remove-btn');

            input.value = ''; // Xóa giá trị của input
            preview.src = '#'; // Đặt lại src của ảnh xem trước
            preview.style.display = 'none'; // Ẩn ảnh xem trước
            removeBtn.style.display = 'none'; // Ẩn nút "Xóa hình"
        }
    </script>
@endsection
