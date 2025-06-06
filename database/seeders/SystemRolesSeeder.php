<?php

namespace BabeRuka\SystemRoles\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('system_roles')->insert([
            [
                'role_id' => 1,
                'role_name' => 'Super Admin',
                'role_guard_name' => 'super_admin',
                'role_description' => null,
                'role_lang_name' => 'eng',
                'role_role_class' => 'RolesController',
                'role_sequence' => 1,
                'created_at' => Carbon::parse('2025-05-27 16:01:33'),
                'updated_at' => Carbon::parse('2025-05-27 16:01:42'),
            ],
            [
                'role_id' => 2,
                'role_name' => 'Admin',
                'role_guard_name' => 'admin',
                'role_description' => null,
                'role_lang_name' => 'eng',
                'role_role_class' => 'RolesController',
                'role_sequence' => 2,
                'created_at' => Carbon::parse('2025-05-27 16:01:56'),
                'updated_at' => Carbon::parse('2025-05-27 16:03:01'),
            ],
            [
                'role_id' => 3,
                'role_name' => 'Manager',
                'role_guard_name' => 'manager',
                'role_description' => null,
                'role_lang_name' => 'eng',
                'role_role_class' => 'RolesController',
                'role_sequence' => 3,
                'created_at' => Carbon::parse('2025-05-27 16:05:11'),
                'updated_at' => Carbon::parse('2025-05-27 17:33:57'),
            ],
            [
                'role_id' => 4,
                'role_name' => 'User',
                'role_guard_name' => 'user',
                'role_description' => null,
                'role_lang_name' => 'eng',
                'role_role_class' => 'RolesController',
                'role_sequence' => 4,
                'created_at' => Carbon::parse('2025-05-27 16:05:25'),
                'updated_at' => Carbon::parse('2025-05-27 17:34:01'),
            ]
        ]);
    }
}
