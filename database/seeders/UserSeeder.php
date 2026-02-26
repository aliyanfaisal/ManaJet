<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=>"Project Manager",
            "email"=> "pm@manajet.com",
            "role_id"=> Role::find(1)->id,
            "password"=> Hash::make("pm-manajet$15"),
            "phone"=> "03155687559"
        ]);
    }
}
