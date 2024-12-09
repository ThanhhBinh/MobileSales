@extends('layouts.admin')
@section('title', 'Thêm người dùng')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm người dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Thêm người dùng</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" name="create" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i> Lưu
                        </button>
                        <a class="btn btn-sm btn-info" href="{{ route('admin.user.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="name">Tài khoản</label>
                            <input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control" />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="username">Tên tài khoản</label>
                            <input type="text" value="{{ old('username') }}" name="username" id="username" class="form-control" />
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gender">Giới tính</label>
                            <input type="text" value="{{ old('gender') }}" name="gender" id="gender" class="form-control" />
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                        
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" value="{{ old('phone') }}" name="phone" id="phone" class="form-control" />
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control" />
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="roles">Quyền</label>
                            <input type="text" value="{{ old('roles') }}" name="roles" id="roles" class="form-control" />
                            @error('roles')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password">Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" required />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="address">Địa chỉ</label>
                            <input type="text" value="{{ old('address') }}" name="address" id="address" class="form-control" />
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image">Hình ảnh</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Xuất bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
