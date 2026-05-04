<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Database\Seeders\PermissionSeeder;
use App\Models\Permissions;
use App\Models\Roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // 🔹 buat role
        $admin = Roles::create([
            'id' => Str::uuid(),
            'name' => 'admin'
        ]);

        $editor = Roles::create([
            'id' => Str::uuid(),
            'name' => 'editor'
        ]);

        // 🔹 ambil semua permission
        $permissions = Permissions::pluck('id');

        // 🔥 admin dapat semua permission
        $admin->permissions()->attach($permissions);

        // 🔹 editor sebagian
        $editor->permissions()->attach(
            Permissions::whereIn('name', [
                'view-dashboard',
                'create-news',
                'update-news',
            ])->pluck('id')
        );
    
    }
}
