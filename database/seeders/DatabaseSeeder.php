<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 1. SEED PENGATURAN
        $this->call([
            PengaturanSeeder::class,
        ]);

        // 🔥 2. BUAT ROLE SUPERADMIN
        $role = Role::updateOrCreate(
            ['name' => 'Superadmin'],
            [
                'permissions' => [
                    [
                        'menu' => 'ALL',
                        'view' => true,
                        'create' => true,
                        'update' => true,
                        'delete' => true,
                    ]
                ]
            ]
        );

        // 🔥 3. BUAT USER SUPERADMIN
        User::updateOrCreate(
            ['email' => 'admin@internal'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role_id' => $role->id,
            ]
        );
    }
}
