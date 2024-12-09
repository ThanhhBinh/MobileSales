@extends('layouts.admin')
@section('title', 'shipping')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật shipping - {{ $shipping->shipping_method_id }}</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-12 text-right">
                        <form action="{{ route('admin.shipping.destroy', $shipping->shipping_method_id) }}" method="post"
                            class="d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger" name="delete" type="submit">
                                <i class="fas fa-trash"></i>
                                Xóa
                            </button>
                        </form>
                        <a class="btn btn-info" href="{{ route('admin.shipping.index') }}">
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
                <form action="{{ route('admin.shipping.index') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="shipping_id">Lô hàng</label>
                        <input type="text" value="{{ old('shipping_id', $shipping->order_id) }}" name="shipping_id"
                            id="shipping_id" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="order_id">Tổng trọng lượng</label>
                        <input type="text" value="{{ old('shipping_id', $shipping->total_weight) }}" name="shipping_id"
                            id="shipping_id" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="shipping_method">Thời gian giao hàng</label>
                        <input type="text" value="{{ old('shipping_id', $shipping->created_at) }}" name="shipping_id"
                            id="shipping_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="shipping_method">Uớc tính_thời gian giao hàng</label>
                        <input type="text" value="{{ old('shipping_id', $shipping->estimated_delivery_time) }}"
                            name="shipping_id" id="shipping_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="status">Trạng thái giao hàng</label>
                        <input type="text"
                            value="{{ old('status', \App\Models\ShippingMethod::status()[$shipping->status] ?? 'Không xác định') }}"
                            name="status" id="status" class="form-control" readonly>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Sản phẩm
                            </th>
                            <th class="text-center">Cân nặng</th>
                            <th class="text-center">Chiều dài</th>
                            <th class="text-center">Chiều ngang</th>
                            <th class="text-center">Chiều cao</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $row)
                            <tr>
                                <td>{!! $row->name !!}</td>
                                <td class="text-center">{!! $row->height !!} <span>gam</span>
                                </td>
                                <td class="text-center">{!! $row->height !!} <span>centimet</span>
                                </td>
                                <td class="text-center">{!! $row->height !!} <span>centimet</span>
                                </td>
                                <td class="text-center">{!! $row->height !!} <span>centimet</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
