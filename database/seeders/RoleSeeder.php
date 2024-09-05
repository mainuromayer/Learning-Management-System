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
        
        Role::updateOrCreate(['title' => 'Client', 'slug' => 'client', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Support', 'slug' => 'support', 'deletable' => false]);    
        Role::updateOrCreate(['title' => 'Accounts', 'slug' => 'accounts', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Branch Manager', 'slug' => 'billing', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Technical Support', 'slug' => 'ets', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'BReseller', 'slug' => 'breseller', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'MReseller', 'slug' => 'mreseller', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Billing', 'slug' => 'billing_manager', 'deletable' => false]);
        Role::updateOrCreate(['title' => 'Support Manager', 'slug' => 'support_manager', 'deletable' => false]);
    }
}
