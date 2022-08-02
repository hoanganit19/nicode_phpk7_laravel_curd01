@extends('layouts.master')

@section('title', $title)

@section('content')
    <h2>{{$title}}</h2>
    <a href="{{route('users.add')}}" class="btn btn-primary">Thêm mới</a>
    <hr>
    @if (session('msg'))
        <div class="alert alert-{{session('msg_type')?session('msg_type'):'success'}}">{{session('msg')}}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%"><input class="check-all" onchange="handleCheckAll(this)" type="checkbox"></th>
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
                    <input type="checkbox" onchange="handleCheckboxItem(this)" class="check-item" value="{{$user->id}}">
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
                    <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning btn-sm">Sửa</a>
                </td>
                <td>
                    <a href="{{route('users.delete', $user->id)}}" class="btn btn-danger btn-sm remove" onclick="deleteUser(event)">Xoá</a>
                </td>
            </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8">
                        <div class="alert alert-danger text-center">Không có dữ liệu</div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <hr>
    <div class="row">
        <div class="col-6">
            <button type="button" class="btn btn-danger delete-selection" onclick="deleteSection()"  disabled>Xoá đã chọn (<span>0</span>)</button>
        </div>
        <div class="col-6 d-flex justify-content-end">
            {{$users->links()}}
        </div>
    </div>

    <form action="" method="post" class="delete-form">
        <input type="hidden" name="ids" value="">
        @csrf
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        function deleteUser(event){
            event.preventDefault();

            Swal.fire({
                title: 'Bạn có chắn chắn muốn xoá?',
                text: "Nếu xoá bạn sẽ không thể khôi phục!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok, Xóa luôn!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteForm = document.querySelector('.delete-form');
                    deleteForm.action = event.target.href;
                    deleteForm.submit();
                }
            })

        }

        const checkItems = document.querySelectorAll('.check-item');

        const deleteButton = document.querySelector('.delete-selection');

        let countDelete = 0;

        function handleCheckAll(currentObj){
            const statusChecked = currentObj.checked;

            if (checkItems.length){
                checkItems.forEach(checkbox => {
                    checkbox.checked = statusChecked;
                })
            }

            countDelete = 0;

            if (statusChecked){
                countDelete = checkItems.length;
            }

            deleteButton.children[0].innerText = countDelete;

            if (countDelete>0){
                deleteButton.removeAttribute('disabled');
            }else{
                deleteButton.setAttribute('disabled', 'disabled');
            }

        }

        function handleCheckboxItem(currentObj){

            const checkAllObj = document.querySelector('.check-all');

            const checkBoxStatus = currentObj.checked;

            if (!checkBoxStatus){
                checkAllObj.checked = false;
                countDelete--;

                deleteButton.children[0].innerText = countDelete;

                if (countDelete>0){
                    deleteButton.removeAttribute('disabled');
                }else{
                    deleteButton.setAttribute('disabled', 'disabled');
                }

                return; //ngắt hàm
            }

            countDelete = 0; //reset count

            const checkAllStatus = Array.from(checkItems).every(item => {
                if (item.checked===true){
                    countDelete++;
                }
                return item.checked === true;
            });

            deleteButton.children[0].innerText = countDelete;

            if (countDelete>0){
                deleteButton.removeAttribute('disabled');
            }else{
                deleteButton.setAttribute('disabled', 'disabled');
            }

            checkAllObj.checked = checkAllStatus;

        }

        function deleteSection(){
            if (countDelete>0){
                Swal.fire({
                    title: 'Bạn có chắn chắn muốn xoá?',
                    text: "Nếu xoá bạn sẽ không thể khôi phục!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok, Xóa luôn!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const deleteIds = [];
                        Array.from(checkItems).forEach(checkbox => {
                            if (checkbox.checked === true){
                                deleteIds.push(checkbox.value);
                            }
                        });

                        if (deleteIds.length){
                            const deleteForm = document.querySelector('.delete-form');

                            deleteForm.querySelector('[name="ids"]').value = deleteIds.join(',');

                            deleteForm.action = '{{route('users.deletes')}}';

                            deleteForm.submit();

                        }

                    }
                })
            }
        }

    </script>
@endsection
