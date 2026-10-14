<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::firstOrNew(['email' => 'admin@gmail.com']);
        $admin->name = 'Admin';
        $admin->role = 'super_admin';
        $admin->email_verified_at ??= now();

        if (! $admin->exists) {
            $admin->password = bcrypt('Enrollment123');
        }

        $admin->save();
    }
}
