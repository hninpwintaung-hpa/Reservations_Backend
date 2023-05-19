<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'SuperAdmin']);
        $admin = Role::create(['name' => 'Admin']);
        $staff = Role::create(['name' => 'Staff']);

        $dashboard = Permission::create(['name' => 'dashboard']);
        $deleteUser = Permission::create(['name' => 'delete-user']);
        $deleteAdmin = Permission::create(['name' => 'delete-admin']);
        $userList = Permission::create(['name' => 'user-list']);

        $superAdmin->givePermissionTo([$dashboard, $deleteAdmin, $userList, $deleteUser]);
        $admin->givePermissionTo([$dashboard, $deleteUser, $userList]);
        $staff->givePermissionTo([$dashboard]);
    }
}
