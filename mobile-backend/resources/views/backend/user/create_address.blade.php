@extends('layouts.admin') 
@section('title', 'Thêm địa chỉ')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm địa chỉ</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-12 text-right">
                        <a class="btn btn-info" href="{{ route('admin.user.edit',$user_id) }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
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

                <form action="{{ route('admin.user.store_address') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="last_name">Họ</label>
                        <input type="text" value="{{ old('last_name') }}" name="last_name" id="last_name"
                            class="form-control">
                    </div>
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">
                        <label for="first_name">Tên</label>
                        <input type="text" value="{{ old('first_name') }}" name="first_name" id="first_name"
                            class="form-control">
                    </div>
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">
                        <label for="email">E-mail</label>
                        <input type="text" value="{{ old('email') }}" name="email" id="email"
                            class="form-control">
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">
                        <label for="city">Thành phố</label>
                        <input type="text" value="{{ old('city') }}" name="city" id="city"
                            class="form-control">
                    </div>
                    @error('city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">
                        <label for="state">Phường/Thị xã</label>
                        <input type="text" value="{{ old('state') }}" name="state" id="state"
                            class="form-control">
                    </div>
                    @error('state')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">
                        <label for="address">Địa chỉ</label>
                        <input type="text" value="{{ old('address') }}" name="address" id="address"
                            class="form-control">
                    </div>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">
                        <label for="postal_code">Mã bưu chính</label>
                        <input type="number" value="{{ old('postal_code') }}" name="postal_code" id="postal_code"
                            class="form-control">
                    </div>
                    @error('postal_code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">
                        <label for="phone">Số điện thoại</label>
                        <input type="number" value="{{ old('phone') }}" name="phone" id="phone"
                            class="form-control">
                    </div>
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <input type="hidden" value="{{ $user_id }}" name="user_id" id="user_id">

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-success">Thêm địa chỉ</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
