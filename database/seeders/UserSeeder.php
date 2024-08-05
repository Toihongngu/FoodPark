<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name'=>'Admin',
                'email'=>'admin@gmail.com',
                'role'=>'admin',
                'password'=>'$2y$10$eGph8tpT8c7EGkQ2kQ6FsOXYHnpP9G7kHT.zJnhY3U4RvazE.b/s6' //password
            ],
            [
                'name'=>'User',
                'email'=>'user@gmail.com',
                'role'=>'user',
                'password'=>'$2y$10$eGph8tpT8c7EGkQ2kQ6FsOXYHnpP9G7kHT.zJnhY3U4RvazE.b/s6' //password
            ]
            ]);
    }
}
