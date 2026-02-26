<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'can_add_project',
                [1]
            ],
            [
                'can_add_task',
                [1]
            ],
            [
                'can_add_ticket',
                [1]
            ],
            [
                'can_add_user',
                [1]
            ],
            [
                'can_manage_options',
                [1]
            ],
            [
                'can_add_notice',
                [1]
            ],
            [
                'can_view_project',
                [1, 2, 3, 4, 5,8]
            ],
            [
                'can_view_task',
                [1, 2, 3, 4, 5,8]
            ],
            [
                'can_view_ticket',
                [1]
            ],
            [
                'can_chat',
                [1, 2, 3, 4, 5,8]
            ],
            [
                'can_manage_profile',
                [1, 2, 3, 4, 5,8]
            ],
            [
                'can_add_role',
                [1]
            ],
            [
                'can_add_project_category',
                [1]
            ],
            [
                'can_add_team',
                [1]
            ],
            [
                'can_view_team',
                [1]
            ],
            [
                'can_add_permission',
                [1]
            ]
        ];

        foreach ($permissions as $per) {
            $permission = \App\Models\Permission::create([
                "permission_name" => $per[0],
                "status" => "active"
            ]);

            foreach ($per[1] as $role_id) {
                RolePermission::create([
                    "role_id" => $role_id,
                    "permission_id" => $permission->id
                ]);

            }

        }
    }
}