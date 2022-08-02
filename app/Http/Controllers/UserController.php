<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{User, Group};

use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $userModel, $groupModel, $perPage;


    public function __construct(){
        $this->userModel = new User();
        $this->groupModel = new Group();
        $this->perPage = env('PER_PAGE');
    }

    public function index(){

        $title = 'Danh sách người dùng';

        $users = $this->userModel->getUsers($this->perPage);

        return view('users.lists', compact(
            'title',
            'users'
        ));
    }

    public function add(){

        $title = 'Thêm người dùng';

        $groups = $this->groupModel->getGroups();

        return view('users.add', compact(
            'title',
            'groups'
        ));
    }

    public function postAdd(UserRequest $request){

        $dataInsert = $request->except('_token');

        $dataInsert['created_at'] = date('Y-m-d H:i:s');
        $dataInsert['updated_at'] = date('Y-m-d H:i:s');

        $this->userModel->addUser($dataInsert);

        return redirect()->route('users.index')->with('msg', 'Thêm người dùng thành công');

    }

    public function edit($id){
        $title = 'Cập nhật người dùng';
        $groups = $this->groupModel->getGroups();

        $user = $this->userModel->getUser($id);

        if (empty($user)){
            return redirect()->route('users.index')->with('msg', 'Người dùng không tồn tại')->with('msg_type', 'danger');
        }

        return view('users.edit', compact(
            'title',
            'groups',
            'user'
        ));
    }

    public function postEdit(UserRequest $request, $id){
        $dataUpdate = $request->except('_token');

        $dataUpdate['updated_at'] = date('Y-m-d H:i:s');

        $this->userModel->updateUser($dataUpdate, $id);

        return redirect()->route('users.edit', $id)->with('msg', 'Cập nhật người dùng thành công');
    }

    public function delete($id){
        $this->userModel->deleteUser($id);

        return redirect()->route('users.index')->with('msg', 'Xoá người thành công');
    }

    public function deletes(Request $request){
       if ($request->ids){
           $ids = $request->ids;
           $idArr = explode(',', $ids);
           $this->userModel->deleteUsers($idArr);

           return redirect()->route('users.index')->with('msg', 'Xoá người dùng thành công');
       }

       return redirect()->route('users.index')->with('msg', 'Xoá người dùng không thành công')->with('msg_type', 'danger');

    }
}
