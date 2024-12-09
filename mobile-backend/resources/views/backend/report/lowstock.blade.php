@extends('layouts.admin')
@section('title', 'Sản phẩm còn ít hàng')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="content-header">
                <h1 class="m-0">Sản phẩm còn ít hàng</h1>
            </div>

            {{-- Thông báo thành công --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Thông báo lỗi --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Danh sách sản phẩm --}}
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Mô tả</th>
                                <th class="text-center">Số lượng còn lại</th>
                                <th class="text-center">Chức năng</th>
                                <th class="text-center">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($product as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{!! $item->description !!}</td>
                                    <td class="text-center">{{ $item->stock }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.product.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                            Chỉnh sửa <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $item->id }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Không có sản phẩm nào còn ít hàng.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Phân trang --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        {{-- Hiển thị số lượng sản phẩm mỗi trang --}}
                        <form method="GET" class="d-inline-block">
                            <label for="items_per_page">Số sản phẩm mỗi trang:</label>
                            <select name="items_per_page" id="items_per_page" class="form-control d-inline-block w-auto"
                                onchange="this.form.submit()">
                                <option value="7" {{ $product->perPage() == 7 ? 'selected' : '' }}>7</option>
                                <option value="15" {{ $product->perPage() == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ $product->perPage() == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $product->perPage() == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $product->perPage() == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </form>

                        {{-- Hiển thị phân trang --}}
                        <div>
                            {{ $product->links() }}
                        </div>
                    </div>

                    {{-- Thống kê số sản phẩm --}}
                    <div class="text-right mt-2">
                        <p>Hiển thị từ {{ $product->firstItem() }} đến {{ $product->lastItem() }} của {{ $product->total() }} sản phẩm.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
