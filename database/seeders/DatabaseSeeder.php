<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clubs = \App\Models\Club::factory(3)->create();

        \App\Models\User::factory(15)
            ->sequence(
                ['club_id' => $clubs[0]->id],
                ['club_id' => $clubs[1]->id],
                ['club_id' => $clubs[2]->id],
            )
            ->create();

        \App\Models\User::factory([
            'club_id' => $clubs[0]->id,
            'email' => 'admin@test.com',
            'user_type' => 'admin'
        ])
        ->create();
    }
}
