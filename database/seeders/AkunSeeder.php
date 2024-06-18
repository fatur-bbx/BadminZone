<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        $user = [
            [
                'name'=>'AkunAdmin',
                'email'=>'admin@gmail.com',
                'level'=>0,
                'password'=>Hash::make('123456')
            ],
            
            [
                'name'=>'AkunStaff1',
                'email'=>'staff1@gmail.com',
                'level'=>1,
                'password'=>Hash::make('123456')
            ],
            [
                'name'=>'AkunStaff2',
                'email'=>'staff2@gmail.com',
                'level'=>1,
                'password'=>Hash::make('123456')
            ],

        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
