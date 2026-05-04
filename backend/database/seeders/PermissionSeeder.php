<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Permissions;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            
            'view-dashboard',

            'view-doctor',
            'create-doctor',
            'update-doctor',
            'delete-doctor',

            'view-news',
            'create-news',
            'update-news',
            'delete-news',

            'view-video',
            'create-video',
            'update-video',
            'delete-video',

            'view-promotion',
            'create-promotion',
            'update-promotion',
            'delete-promotion',

            'view-schedule',
            'create-schedule',
            'update-schedule',
            'delete-schedule',

            'view-hero',
            'create-hero',
            'update-hero',
            'delete-hero'
        ];

        foreach ($permissions as $perm) {
            Permissions::create([
                'id' => Str::uuid(),
                'name' => $perm
            ]);
        }
    }
}
