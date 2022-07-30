<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{User, Group};

use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $userModel, $groupModel;

    public function __construct(){
        $this->userModel = new User();
        $this->groupModel = new Group();
    }

    public function index(){

        $title = 'Danh sách người dùng';

        $users = $this->userModel->getUsers();

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
}
