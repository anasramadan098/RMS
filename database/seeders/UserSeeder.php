<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Tenant;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Tenant
        Tenant::create([
            'name' => 'Demo Account',
            'email' => 'admin@free.com',
            'password' => Hash::make('password'),
            'phone' => '123456789',
            'address' => '123 Main St',
            'subscribtion_type' => 'demo',
            'subscribtion_created' => now(),
            'subscribtion_amount' => 100.00,
            'is_subscribe' => true,
        ]);
        Tenant::create([
            'name' => 'Demo Account',
            'email' => 'admin2@free.com',
            'password' => Hash::make('password'),
            'phone' => '123456789',
            'address' => '123 Main St',
            'subscribtion_type' => 'demo',
            'subscribtion_created' => now(),
            'subscribtion_amount' => 100.00,
            'is_subscribe' => true,
        ]);

        User::create([
            'name' => 'System Owner',
            'email' => 'owner2@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::OWNER->value,
            'email_verified_at' => now(),
            'tenant_id' => 2,
        ]);


        // Create default owner account
        User::create([
            'name' => 'System Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::OWNER->value,
            'email_verified_at' => now(),
            'tenant_id' => Tenant::first()->id,
        ]);
        

        // Create default employee account
        // User::create([
        //     'name' => 'John Employee',
        //     'email' => 'employee@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => UserRole::EMPLOYEE->value,
        //     'email_verified_at' => now(),
        // ]);

        // Create additional test users
        // User::factory(8)->create();

        Project::create([
            'name' => 'Project 1',
            'description' => 'Project 1 Description',
            'user_id' => 1,
            'tenant_id' => 1,
        ]);

        
    }
}
