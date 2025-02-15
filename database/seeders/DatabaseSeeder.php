<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Create roles
        $roles = ['admin', 'user'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        //Create permissions

        $permissions = [
            'isAdmin',
            'isUser',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //Assign permissions to roles

        $role = Role::findByName('admin');

        $role->givePermissionTo('isAdmin');

        $role = Role::findByName('user');

        $role->givePermissionTo('isUser');





        //Create admin

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        //Create user

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');
    }
}
