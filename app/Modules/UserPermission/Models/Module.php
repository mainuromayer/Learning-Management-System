<?php

namespace App\Modules\UserPermission\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\UserPermission\Models\permissions;
use App\Modules\UserPermission\Models\Role;


class Module extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'slug'];


    //relationships

    public function permissions(){
        return $this->hasMany(Permission::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }


    
}
