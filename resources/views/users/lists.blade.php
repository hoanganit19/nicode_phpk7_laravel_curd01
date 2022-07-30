@extends('layouts.master')

@section('title', $title)

@section('content')
    <h2>{{$title}}</h2>
    <a href="{{route('users.add')}}" class="btn btn-primary">Thêm mới</a>
    <hr>
    @if (session('msg'))
        <div class="alert alert-success">{{session('msg')}}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%"><input type="checkbox"></th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Nhóm</th>
                <th>Trạng thái</th>
                <th width="5%">Sửa</th>
                <th width="5%">Xoá</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->count()>0)
                @foreach($users as $user)
            <tr>
                <td>
                    <input type="checkbox" value="{{$user->id}}">
                </td>
                <td>
                    {{$user->name}}
                </td>
                <td>
                    {{$user->email}}
                </td>
                <td>
                    {{$user->phone}}
                </td>
                <td>
                    {{$user->group_name}}
                </td>
                <td>
                    {!!$user->status?'<button class="btn btn-success btn-sm">Kích hoạt</button>':'<button class="btn btn-danger btn-sm">Chưa kích hoạt</button>'!!}
                </td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                </td>
                <td>
                    <a href="#" class="btn btn-danger btn-sm">Xoá</a>
                </td>
            </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">
                        <div class="alert alert-danger text-center">Không có dữ liệu</div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <hr>
    <button type="button" class="btn btn-danger" disabled>Xoá đã chọn (0)</button>
@endsection
