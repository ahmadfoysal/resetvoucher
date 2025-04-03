<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mikrotik;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Create roles
        $roles = ['superadmin', 'admin', 'user'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        //Create permissions

        $permissions = [
            'isSuperAdmin',
            'isAdmin',
            'isUser',
            'canManageUsers',
            'canManageMikrotiks',
            'canManageResetVouchers',
            'canManageSystemLogs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //Assign permissions to roles

        $role = Role::findByName('superadmin');

        $role->givePermissionTo('isSuperAdmin');

        $role->givePermissionTo('canManageUsers');

        $role = Role::findByName('admin');

        $role->givePermissionTo('isAdmin');

        $role->givePermissionTo('canManageUsers');
        $role->givePermissionTo('canManageMikrotiks');
        $role->givePermissionTo('canManageResetVouchers');
        $role->givePermissionTo('canManageSystemLogs');



        $role = Role::findByName('user');

        $role->givePermissionTo('isUser');
        $role->givePermissionTo('canManageResetVouchers');






        //Create superadmin

        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
            'api_token' => bin2hex(random_bytes(30)),
        ]);

        $superadmin->assignRole('superadmin');

        //Create 5 dummy admis


        for ($i = 1; $i <= 5; $i++) {
            $admin = User::create([
                'name' => 'Admin ' . $i,
                'email' => 'admin' . $i . '@gmail.com',
                'password' => bcrypt('password'),
                'api_token' => bin2hex(random_bytes(30)),
            ]);
            $admin->assignRole('admin');
        }


        //Create 10 dummy users

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => bcrypt('password'),
                'api_token' => bin2hex(random_bytes(30)),
                'admin_id' => rand(1, 5),
            ]);
            $user->assignRole('user');
        }

        //Create 20 dummy mikrotiks

        for ($i = 1; $i <= 20; $i++) {
            $mikrotik = Mikrotik::create([
                'name' => 'Mikrotik ' . $i,
                'ip' => '192.168.1.' . $i,
                'port' => '8728',
                'username' => 'admin',
                'password' => 'password',
                'location' => 'Location ' . $i,
                'user_id' => rand(1, 10),
                'admin_id' => rand(1, 5),
            ]);
        }
    }
}
