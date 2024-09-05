<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Modules\User\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create admin office user
        $user = User::where('email', 'admin@gmail.com')->first();

        if ($user) {
            // Delete the existing user
            $user->delete();
        }
        User::updateOrCreate([
            'user_type' => 'A-1001',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => Role::where('slug', 'admin')->first()->id,
            'status' => true
        ]);
    }
}
