@extends('layouts.master')

@section('title', $title)

@section('content')
    <h2>{{$title}}</h2>
    <a href="{{route('users.index')}}" class="btn btn-primary">Quay lại</a>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger text-center">
            Vui lòng kiểm tra lỗi bên dưới
        </div>
    @endif

    @if (session('msg'))
        <div class="alert alert-{{session('msg_type')?session('msg_type'):'success'}}">{{session('msg')}}</div>
    @endif
    <form action="" method="post">
        <div class="mb-3">
            <label for="">Tên</label>
            <input type="text" name="name" class="form-control" placeholder="Tên..." value="{{old('name') ?? $user->name}}"/>
            @error('name')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email..." value="{{old('email') ?? $user->email}}"/>
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="">Điện thoại</label>
            <input type="text" name="phone" class="form-control" placeholder="Điện thoại..." value="{{old('phone') ?? $user->phone}}"/>
            @error('phone')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="">Nhóm</label>
            <select name="group_id" class="form-control">
                <option value="0">Chọn nhóm</option>
                @if ($groups->count() > 0)
                    @foreach($groups as $group)
                        <option value="{{$group->id}}" {{isSelected('group_id', $user->group_id, $group->id)}}>{{$group->name}}</option>
                    @endforeach
                @endif
            </select>
            @error('group_id')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="0" {{isSelected('group_id', $user->status, 0)}}>Chưa kích hoạt</option>
                <option value="1" {{isSelected('group_id', $user->status, 1)}}>Kích hoạt</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        @csrf
    </form>
@endsection
