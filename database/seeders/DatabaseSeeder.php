<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'BYAMUNGU Lewis',
            'email' => 'byamungulewis@gmail.com',
            'phone' => '0785436135',
            'role' => 'super_admin',
            'password' => 'byamungu'
        ]);

        // Seed site settings
        \App\Models\Setting::set('site_title', 'Admin Panel', 'site');
        \App\Models\Setting::set('site_description', 'Admin Panel', 'site');
        \App\Models\Setting::set('logo', '/admin-panel.png', 'site');
        \App\Models\Setting::set('favicon', '/admin-panel-favicon.png', 'site');
    }
}
