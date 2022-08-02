<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id;

        if (!empty($id)){
            $uniqueRule = 'unique:users,email,'.$id;
        }else{
            $uniqueRule = 'unique:users,email';
        }

        return [
            'name' => 'required',
            'email' => 'required|email|'.$uniqueRule,
            'phone' => 'regex:/^0\d{9}$/i',
            'group_id' => ['required', function($attribute, $value, $fail){
                if ($value==0){
                    $fail('Vui lòng chọn nhóm người dùng');
                }
            }],
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không đúng định dạng',
            'unique' => ':attribute đã tồn tại trên hệ thống',
            'regex' => ':attribute không hợp lệ',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'group_id' => 'Nhóm',
            'status' => 'Trạng thái'
        ];
    }
}
