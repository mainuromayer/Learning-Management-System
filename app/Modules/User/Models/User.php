<?php

namespace App\Modules\User\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Traits\ModelLifeCycleTrait;
use App\Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Modules\UserPermission\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    // In User model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }


}
