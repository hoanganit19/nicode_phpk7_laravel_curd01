<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    public function getGroups(){
        return DB::table($this->table)
            ->orderBy('name')
            ->get();
    }
}
