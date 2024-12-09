@extends('layouts.admin')
@section('title','Chi tiết đơn hàng')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thùng rác chi tiết đơn hàng</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
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
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                Quay về trang
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
           <div class="col-md">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width:30px">#</th>
                        <th>Tên</th>
                            <th>Link</th>
                            <th>Vị trí</th>
                        <th class="text-center" style="width:200px">Chức năng</th>
                        <th class="text-center" style="width:30px">ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $row)
                    <tr>
                      @php
                        $args = ['id' => $row->id]
                      @endphp
                        <td class="text-center">
                            <input type="checkbox" id="checkId" value="1" name="checkId[]">
                        </td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->link }}</td>
                        <td>{{ $row->position }}</td>
                        <td class="text-center">
                            
                            <a href="{{ route('admin.orderdetail.show', $args ) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.orderdetail.restore', $args ) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-undo"></i>
                            </a>
                            <form action="{{ route('admin.orderdetail.destroy', $args ) }}" method="post" class="d-inline" >
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger d-inline" name="delete" type="submit" >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        
                        </td>
                        <td class="text-center">{{ $row->id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
           </div>
        </div>

      </div>
    </div>
  </section>

@endsection