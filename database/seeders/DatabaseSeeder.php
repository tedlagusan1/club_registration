<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Uncomment if you want dummy users

        // Call the ClubSeeder to add default clubs
        $this->call([
            ClubSeeder::class,
            // Add other seeders here if needed
        ]);

        // Create or update a default admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Find user by email
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Change 'password' to a secure password!
                'role' => 'admin',
                'email_verified_at' => now(), // Mark admin as verified
                // Add placeholder/default values for other required fields
                'student_id' => 'ADMIN001',
                'course' => 'N/A',
                'year_level' => 'N/A',
                'grade' => 'N/A',
            ]
        );
    }
}
