<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperadminSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin', 'display_name' => 'Super Admin', 'guard_name' => 'web']);

        $user  = User::create([
            'name' => 'Hafiz M Moaz',
            'email' => 'hafizmoazkhalid@gmail.com',
            'role_id' => 1,
            'password' => bcrypt(12345678)
        ]);
        
        $user->assignRole('Super Admin');

    }

}
