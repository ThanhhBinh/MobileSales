@extends('layouts.admin')
@section('title', 'Danh mục')
@section('content')

    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Chi tiết danh mục</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="col text-right">
                                    <a href="{{ route('admin.category.edit', ['id' => $query->id]) }}"
                                        class="btn  btn-primary">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="{{ route('admin.category.delete', ['id' => $query->id]) }}"
                                        class="btn  btn-danger">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                    <a class="btn  btn-info" href="{{ route('admin.category.index') }}">
                                        <i class="fa fa-arrow-left"></i> Về danh sách
                                    </a>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- Thông tin danh mục --}}

                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                                                <div class="card-header with-border clearfix">

                                                    <div class="card-title">
                                                        <i class="fas fa-info"></i>
                                                         Thông tin danh mục
                                                    </div>
                                                    <div class="card-tools float-right">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse">
                                                            <i class="fa toggle-icon fa-minus"></i> </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="display: block;">
                                                    <div class="row">
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
                                                                    <td>{{ $query->id }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Hình ảnh</td>
                                                                    <td><img style="width:150px"
                                                                            src="{{ asset('images/categorys/' . $query->image) }}"
                                                                            alt="{{ $query->name }}"
                                                                            style="max-width: 100%; height: auto;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tên danh mục</td>
                                                                    <td>{{ $query->name }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Chi tiết danh mục</td>
                                                                    <td>{!! $query->description !!}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Slug</td>
                                                                    <td>{{ $query->slug }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ID Danh mục cha</td>
                                                                    <td>{{ $query->fullName() }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Thứ tự sắp xếp</td>
                                                                    <td>{{ $query->sort_order }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Trạng thái</td>
                                                                    <td>{{ $query->status == 1 ? 'Xuất bản' : 'Chưa xuất bản' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Ngày tạo</td>
                                                                    <td>{{ $query->categorycreatedat }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Người tạo</td>
                                                                    <td>{{ $query->username }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Các sản phẩm có trong danh mục --}}
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="card card-primary card-outline opened" id="nopcommerce-news-box">
                                                <div class="card-header with-border clearfix">
                                                    <div class="card-title">
                                                        <i class="fas fa-info"></i>
                                                        Các sản phẩm trong danh mục
                                                    </div>
                                                    <div class="card-tools float-right">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                            <i class="fa toggle-icon fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="display: block;">
                                                    <div class="row">
                                                        <table class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" style="width:30px">
                                                                        <input type="checkbox" id="select-all">
                                                                    </th>
                                                                    <th class="text-center" style="width:150px">Hình ảnh</th>
                                                                    <th style="width:300px">Tên sản phẩm</th>
                                                                    <th class="text-center" style="width:100px">Giá</th>
                                                                    <th class="text-center" style="width:150px">Trạng thái</th>
                                                                    <th class="text-center" style="width:150px">Xem</th>
                                                                    <th class="text-center" style="width:150px">Xóa</th>

                                                                    <th class="text-center" style="width:50px">ID</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if($list->isEmpty())
                                                                    <tr>
                                                                        <td colspan="12" class="text-center">Không có sản phẩm nào trong danh mục này.</td>
                                                                    </tr>
                                                                @else
                                                                    @foreach ($list as $row)
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                <input type="checkbox" class="product-checkbox" value="{{ $row->product_id }}"
                                                                                    name="checkId[]">
                                                                            </td>
                                                                            <td class="text-center" style="width: 150px">
                                                                                <img src="{{ asset('images/products/' . $row->product_name) }}" class="img-fluid"
                                                                                    alt="{{ $row->product_name }}">
                                                                            </td>
                                                                            <td>{!! $row->product_name !!}</td>
                                                                            <td class="text-center">{{ number_format($row->product_price, 0, ',', '.') }}₫</td>
                                                                            <td class="text-center" style="width:100px">
                                                                                @if ($row->product_status == 1)
                                                                                    <i style="color: rgb(38, 184, 38); font-size: 20px" class="fas fa-check"></i> <!-- Chấp thuận -->
                                                                                @elseif ($row->product_status == 2)
                                                                                <i style="color: red; font-size: 20px" class="fas fa-times"></i>
                                                                                @endif
                                                                            </td>
                                                                           
                                                                            <td class="text-center">
                                                                                <a href="{{ route('admin.product.edit', ['id' => $row->product_id]) }}"
                                                                                    class="btn  btn-primary">
                                                                                    <i class="fas fa-eye"></i> Xem
                                                                                </a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a href="{{ route('admin.product.delete', ['id' => $row->product_id]) }}"
                                                                                    class="btn  btn-danger">
                                                                                    <i class="fas fa-trash"></i> Xóa
                                                                                </a>
                                                                            </td>
                                                                            <td class="text-center">{{ $row->product_id }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>

                                                        <div class="col-12 text-center">
                                                            <a class="btn btn-success" href="{{ route('admin.product.create') }}">
                                                                <i class="fas fa-plus"></i> Thêm mới
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </section>
@endsection
