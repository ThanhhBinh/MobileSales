@extends('layouts.admin')
@section('title', 'Banner')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi tiết Banner</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col text-right">
                        <a href="{{ route('admin.banner.edit', ['id' => $banner->id]) }}" class="btn btn-primary">
                            <i class="far fa-edit"></i> Sửa
                        </a>

                        <!-- Nút Xóa -->
                        <a href="{{ route('admin.banner.delete', ['id' => $banner->id]) }}" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                        <a class="btn btn-info" href="{{ route('admin.banner.index') }}">
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
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:30%;">
                                <strong>Tên trường</strong>
                            </th>
                            <th class="text-center" style="width:70%;">Giá trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Id</td>
                            <td>{{ $banner->id }}</td>
                        </tr>
                        <tr>
                            <td>Hình ảnh</td>
                            <td><img style="width:20%" src="{{ asset('images/banners/' . $banner->image) }}"
                                    alt="{{ $banner->name }}" style="max-width: 100%; height: auto;"></td>
                        </tr>
                        <tr>
                            <td>Tên</td>
                            <td>{{ $banner->name }}</td>
                        </tr>
                        <tr>
                            <td>Link</td>
                            <td>{!! $banner->link !!}</td>
                        </tr>
                        <tr>
                            <td>Mô tả</td>
                            <td>{!! $banner->description !!}</td>
                        </tr>
                        <tr>
                            <td>Vị trí</td>
                            <td>{{ $banner->position }}</td>
                        </tr>
                        <tr>
                            <td>Trạng thái</td>
                            <td>{{ $banner->status }}</td>
                        </tr>
                        <tr>
                            <td>Người tạo</td>
                            <td>{{ $banner->created_by }}</td>
                        </tr>
                        <tr>
                            <td>Ngày tạo</td>
                            <td>{{ $banner->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Người cập nhật</td>
                            <td>{{ $banner->updated_by }}</td>
                        </tr>
                        <tr>
                            <td>Ngày cập nhật</td>
                            <td>{{ $banner->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
