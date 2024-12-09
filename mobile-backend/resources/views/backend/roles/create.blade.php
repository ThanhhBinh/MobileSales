@extends('layouts.admin')
@section('title', 'Thêm vai trò')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm vai trò</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-12 text-right">
                        <a class="btn btn-info" href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="content">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Tên vai trò</label>
                                <input type="text" value="{{ old('name') }}" name="name" id="name"
                                    class="form-control" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description">Mô tả</label>
                                <input type="text" value="{{ old('description') }}" name="description" id="description"
                                    class="form-control" />
                            </div>

                            <!-- Vai trò hệ thống -->
                            <div class="mb-3">
                                <label class="form-label">Là vai trò hệ thống?</label>
                                <input type="text" value="Không" name="is_system" id="is_system"
                                    class="form-control" disabled/>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="create" class="btn btn-success">
                        <i class="fa fa-save"></i> Lưu
                    </button>
                </div>
            </div>
        </section>
    </form>
@endsection
