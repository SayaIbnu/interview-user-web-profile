<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // 🔹 ambil role admin
        $role = Roles::where('name', 'admin')->first();

        if (!$role) {
            throw new \Exception('Role admin tidak ditemukan, jalankan RoleSeeder dulu');
        }

        // 🔹 buat user
        $user = User::create([
            'id' => Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'admin@rskg.com',
            'password' => bcrypt('password')
        ]);

        // 🔥 attach role (INI KUNCI, jangan DB::table)
        $user->roles()->attach($role->id);
    }
}
