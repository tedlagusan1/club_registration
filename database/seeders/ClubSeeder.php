<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Clear the table before seeding if needed
        // DB::table('clubs')->truncate();
        // Or use delete() if foreign key constraints cause issues with truncate
        // Club::query()->delete();

        $clubs = [
            ['name' => 'Science Club', 'description' => 'Exploring the wonders of science.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Math Club', 'description' => 'Solving problems and exploring mathematical concepts.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Debate Club', 'description' => 'Honing argumentation and public speaking skills.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business/Entrepreneurship Club', 'description' => 'Developing business acumen and entrepreneurial spirit.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Coding/Programming Club', 'description' => 'Building software and exploring technology.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insert the clubs
        // Using insert() is generally faster for many records than individual create() calls
        Club::insert($clubs);

        // Alternatively, using create() if you need model events/timestamps automatically handled:
        // foreach ($clubs as $clubData) {
        //     Club::create($clubData);
        // }
    }
}
