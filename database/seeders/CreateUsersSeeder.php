<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
               'name'=>'Admin User',
               'email'=>'admin@admin.com',
               'type'=>1,
               'password'=> bcrypt('123123123'),
            ],
            [
                'name'=>'Company User',
                'email'=>'company@company.com',
                'type'=> 2,
                'password'=> bcrypt('123123123'),
            ],
            [
               'name'=>'User',
               'email'=>'user@user.com',
               'type'=>0,
               'password'=> bcrypt('123123123'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
