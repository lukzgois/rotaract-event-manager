<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clubs = \App\Models\Club::factory(3)->create();

        \App\Models\User::factory(15)
            ->hasSubscription()
            ->sequence(
                ['club_id' => $clubs[0]->id],
                ['club_id' => $clubs[1]->id],
                ['club_id' => $clubs[2]->id],
            )
            ->create();

        \App\Models\User::factory([
            'club_id' => $clubs[0]->id,
            'email' => 'pending@test.com',
        ])
        ->hasSubscription()
        ->create();

        \App\Models\User::factory([
            'club_id' => $clubs[0]->id,
            'email' => 'paid@test.com',
        ])
        ->hasSubscription(['paid_at' => Carbon::now()])
        ->create();

        \App\Models\User::factory([
            'club_id' => $clubs[0]->id,
            'email' => 'admin@test.com',
            'user_type' => 'admin'
        ])
        ->hasSubscription()
        ->create();
    }
}
