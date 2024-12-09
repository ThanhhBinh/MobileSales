@extends('layouts.admin')
@section('title', 'Chi tiết sản phẩm')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>CHI TIẾT SẢN PHẨM</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{ route('admin.product.edit', ['product_id' => $product->product_id]) }}" class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i> Sửa
                        </a>
                        <a href="{{ route('admin.product.delete', ['product_id' => $product->product_id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                        <a class="btn btn-sm btn-info" href="{{ route('admin.product.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
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
                            <td>ID</td>
                            <td>{{ $product->product_id }}</td>
                        </tr>
                        <tr>
                            <td>Mã danh mục</td>
                            <td>{{ $product->category_id }}</td>
                        </tr>
                        <tr>
                            <td>Mã thương hiệu</td>
                            <td>{{ $product->brand_id }}</td>
                        </tr>
                        <tr>
                            <td>Tên sản phẩm</td>
                            <td>{{ $product->product_name }}</td>
                        </tr>
                        <tr>
                            <td>Tồn kho</td>
                            <td>{{ $product->product_stock }}</td>
                        </tr>
                        <tr>
                            <td>Mô tả sản phẩm</td>
                            <td>{!! $product->description !!}</td>
                        </tr>
                        <tr>
                            <td>Người dùng</td>
                            <td>{{ $userName }}</td>
                        </tr>
                        <tr>
                            <td>Hình ảnh</td>
                            <td>
                                <img style="width: 100px" class="img img-fluid"
                                    src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->image }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Giá sản phẩm</td>
                            <td>{{ $product->price }}</td>
                        </tr>
                        <tr>
                            <td>Giá khuyến mãi</td>
                            <td>{{ $product->discount }}</td>
                        </tr>
                        <tr>
                            <td>Ngày tạo</td>
                            <td>{{ $product->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Ngày cập nhật</td>
                            <td>{{ $product->updated_at }}</td>
                        </tr>
                        <tr>
                            <td>Trạng thái</td>
                            <td>{{ $product->status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
