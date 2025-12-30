<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles if they don't exist
        $roleAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        $roleManager = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Manager']);
        $roleStaff = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Staff']);
        $roleUser = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'User']);

        // Run PermissionSeeder
        $this->call(PermissionSeeder::class);

        // Create Admin User if not exists
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'Admin',
            ]);
        }
        
        $user->assignRole($roleAdmin);
    }
}
