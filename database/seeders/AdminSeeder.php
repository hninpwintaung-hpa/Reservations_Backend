<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $superAdmin = User::create(
            [
                'name' => 'user1',
                'email' => 'user1@gmail.com',
                'employee_id' => '123456',
                'password' => Hash::make('user112345'),
                'phone' => '09740883309',
                'status' => '1',
                'team_id' => '1',
            ]
        );

        $admin = User::create(
            [
                'name' => 'user2',
                'email' => 'user2@gmail.com',
                'employee_id' => '223456',
                'password' => Hash::make('user212345'),
                'phone' => '09740883308',
                'status' => '1',
                'team_id' => '1',
            ]
        );


        $staff = User::create(
            [
                'name' => 'user3',
                'email' => 'user3@gmail.com',
                'employee_id' => '323456',
                'password' => Hash::make('user312345'),
                'phone' => '09740883300',
                'status' => '1',
                'team_id' => '2',
            ]
        );

        $superAdmin->assignRole('SuperAdmin');
        $admin->assignRole('Admin');
        $staff->assignRole('Staff');
    }
}
