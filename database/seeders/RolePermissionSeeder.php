<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage companies',
            'manage jobs',
            'manage applicants',
            'view companies',
            'view jobs',
            'view applicants',
            'view bookmarks',
            'apply jobs',
            'history applicants',
        ];

        // buat permission jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // admin memiliki semua permission
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        // perusahaan memiliki permission 
        $companyRole = Role::firstOrCreate(['name' => 'company']);
        $companyPermissions = [
            'manage companies',
            'manage jobs',
            'view applicants',
        ];
        $companyRole->syncPermissions($companyPermissions);

        // pemalar memiliki permission
        $applicantRole = Role::firstOrCreate(['name' => 'applicant']);
        $applicantPermissions = [
            'view companies',
            'view jobs',
            'apply jobs',
            'view bookmarks',
            'history applicants',
        ];
        $applicantRole->syncPermissions($applicantPermissions);

        // buat akun admin
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => bcrypt('123123123'),
        ]);
        $admin->assignRole($adminRole);
    }
}
