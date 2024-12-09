@extends('layouts.admin')
@section('title','Khuyến mãi')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết khuyến mãi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Chi tiết khuyến mãi</li>
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
                    <a href="{{ route('admin.promotion.edit', ['id' => $promotion->id]) }}" class="btn btn-sm btn-primary">
                        <i class="far fa-edit"></i> Sửa
                    </a>
                    <a href="#" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.promotion.index') }}">
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
                        <td>Id</td>
                        <td>{{ $promotion->id }}</td>
                    </tr>
                    <tr>
                        <td>Tên khuyến mãi</td>
                        <td>{{ $promotion->promotion_name }}</td>
                    </tr>
                    <tr>
                        <td>Loại giảm giá</td>
                        <td>{{ $promotion->discount_type }}</td>
                    </tr>
                    <tr>
                        <td>Giá khuyến mãi</td>
                        <td>{{ $promotion->discount_value }}</td>
                    </tr>
                    <tr>
                        <td>Thời gian bắt đầu</td>
                        <td>{{ $promotion->start_date }}</td>
                    </tr>
                    <tr>
                        <td>Thời gian kết thúc</td>
                        <td>{{ $promotion->end_date }}</td>
                    </tr>
                    <tr>
                        <td>Created_at</td>
                        <td>{{ $promotion->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Created_by</td>
                        <td>{{ $promotion->created_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
