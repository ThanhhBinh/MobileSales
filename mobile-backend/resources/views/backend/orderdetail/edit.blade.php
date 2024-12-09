@extends('layouts.admin')
@section('title', 'Cập nhật chi tiết sản phẩm')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>CẬP NHẬT CHI TIẾT SẢN PHẨM</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Cập nhật chi tiết sản phẩm</li>
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
                        <a class="btn btn-sm btn-info" href="{{ route('admin.orderdetail.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orderdetail.update', $orderdetail->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="quantity">Số lượng</label>
                        <input type="number" name="quantity" value="{{ $orderdetail->quantity }}" id="quantity" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="amount">Tổng tiền</label>
                        <input type="text" name="amount" value="{{ $orderdetail->amount }}" id="amount" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="price">Giá</label>
                        <input type="text" name="price" value="{{ $orderdetail->price }}" id="price" class="form-control">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Cập nhật chi tiết sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
