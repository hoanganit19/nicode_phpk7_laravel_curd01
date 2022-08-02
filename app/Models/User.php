<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    protected $table = 'users';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUsers($perPage=0){
        $users = DB::table($this->table)
            ->select('users.*', 'groups.name as group_name')
            ->orderBy('created_at', 'DESC')
            ->join('groups', 'users.group_id', '=', 'groups.id');

        if (!empty($perPage)){
            $users = $users->paginate($perPage)->withQueryString(); //Phân trang theo giới hạn $perPage
        }else{
            $users = $users->get(); //lấy tất cả bản ghi
        }

        return $users;
    }

    public function addUser($data){
        return DB::table($this->table)->insert($data);
    }

    public function getUser($id){
        return DB::table($this->table)
            ->where('id', $id)
            ->first();
    }

    public function updateUser($data, $id){
        return DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function deleteUser($id){
        return DB::table($this->table)
            ->where('id', $id)
            ->delete();
    }

    public function deleteUsers($idArr){
        return DB::table($this->table)
            ->whereIn('id', $idArr)
            ->delete();
    }
}
