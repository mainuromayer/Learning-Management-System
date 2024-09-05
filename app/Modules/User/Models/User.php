<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\UserPermission\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ModelLifeCycleTrait;
class User extends Authenticatable
{
    // use HasFactory;
    use ModelLifeCycleTrait;

    public function hasPermission($permission): bool
    {
        return $this->role->permissions()->where('slug', $permission)->first() ? true : false;
    }

    public function hasModulePermission($module): bool
    {
        return $this->role->modules()->where('slug', $module)->first() ? true : false;
    }
        
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
