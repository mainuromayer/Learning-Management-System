<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\UserPermission\Models\Module;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all permissions and modules
        $admin_permissions = Permission::all();
        $admin_modules = Module::all();

        // Update or create the Admin role
        $admin_role = Role::updateOrCreate(
            ['slug' => 'admin'],
            ['title' => 'Admin', 'deletable' => false]
        );

        // Sync permissions
        $admin_role->permissions()->sync($admin_permissions->pluck('id'));

        // Sync modules
        $admin_role->modules()->sync($admin_modules->pluck('id'));

        Role::updateOrCreate( ['title' => 'Dashboard', 'slug' => 'dashboard', 'deletable' => false] );
        Role::updateOrCreate(['title' => 'Category', 'slug' => 'category', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Course', 'slug' => 'course', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Student', 'slug' => 'student', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Instructor', 'slug' => 'instructor', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Assignment', 'slug' => 'assignment', 'deletable' => false]);
    }
}
