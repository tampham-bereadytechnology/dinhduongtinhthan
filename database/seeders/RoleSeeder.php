<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = ['Super Admin', 'Admin', 'Content Creator', 'User'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $contentCreator = Role::firstOrCreate(['name' => 'Content Creator']);
        $user = Role::firstOrCreate(['name' => 'User']);
        // Lấy tất cả quyền nhưng chỉ lấy tên quyền
        $permissions = Permission::all()->pluck('name')->toArray();

        $superAdmin->syncPermissions($permissions);
        $admin->syncPermissions(['create_user', 'view_user', 'view_category', 'view_blog', 'create_blog', 'update_blog', 'delete_blog', 'update_category']);
        $contentCreator->syncPermissions(['create_blog', 'update_blog', 'view_blog']);
        $user->syncPermissions(['view_blog', 'view_category']);
    }
}
