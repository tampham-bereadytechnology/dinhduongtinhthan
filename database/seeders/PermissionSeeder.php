<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = ['create_category', 'delete_category', 'update_category', 'view_category','create_blog', 'delete_blog', 'update_blog', 'view_blog', 'create_user', 'delete_user', 'update_user', 'view_user'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
