<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator with full access',
            ],
            [
                'name' => 'manager',
                'description' => 'Manager with inventory management access',
            ],
            [
                'name' => 'staff',
                'description' => 'Staff with basic access',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
