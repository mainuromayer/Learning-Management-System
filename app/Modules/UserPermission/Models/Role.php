<?php

namespace App\Modules\UserPermission\Models;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use App\Modules\UserPermission\Models\Module;
use App\Modules\UserPermission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','deletable'];


    //relationship 

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function modules(){
        return $this->belongsToMany(Module::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
