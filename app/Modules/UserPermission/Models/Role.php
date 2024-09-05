<?php

namespace App\Modules\UserPermission\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\UserPermission\Models\Permission;
use App\Modules\UserPermission\Models\Module;

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
