<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "Project Manager",
                "User with the highest level of access"
            ],

            [
                "Web Developer",
                "User can build websites"
            ],
            [
                "Mobile Developer",
                "User can build mobile applications"
            ],
            [
                "Frontend Developer",
                "User can build front side of website",
                2
            ],
            [
                "Backend Developer",
                "User can build backend scripting",
                2
            ],
            [
                "IOS Developer",
                "User can build backend scripting",
                3
            ],
            [
                "Android Developer",
                "User can build backend scripting",
                3
            ],
            [
                "Media Marketer",
                "User can advertise"
            ]
        ];

        foreach($roles as $role){

            if(!isset($role[2])){
            
                \App\Models\Role::create([
                    "role_name"=> $role[0],
                    "role_description"=> $role[1],
                    "status"=> "active"
                ]);
            }
            else{
                \App\Models\Role::create([
                    "role_name"=> $role[0],
                    "role_description"=> $role[1],
                    "parent_id"=> $role[2] ,
                    "status"=> "active"
                ]);
            }
        }
    }
}