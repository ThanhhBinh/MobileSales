@extends('layouts.admin')
@section('title', 'vai trò')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật vai trò</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-12 text-right">
                        <form action="{{ route('admin.roles.destroy', $roles->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger" name="delete" type="submit">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                        <a class="btn btn-info" href="{{ route('admin.roles.index') }}">
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
                <form action="{{ route('admin.roles.update', ['id' => $roles->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name">Vai trò</label>
                        <input type="text" value="{{ old('name', $roles->name) }}" name="name" id="name"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="is_system">Là vai trò của hệ thống</label>
                        <input type="text" value="{{$roles->is_system == 1 ? "Đúng" : "Không"}}" name="is_system" id="is_system"
                            class="form-control" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea name="description" value="{{ old('description', $roles->description) }}" id="description"
                            class="form-control">{{ old('description', $roles->description) }}</textarea>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" name="create" class="btn btn-success">Cập nhập vai trò</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
