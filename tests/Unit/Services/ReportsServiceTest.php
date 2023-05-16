<?php

use App\Models\Club;
use App\Models\User;
use App\Services\ReportsService;
use Illuminate\Support\Carbon;

it('returns the totals of confirmed/pending subscriptions grouped by club', function () {
    $clubs = Club::factory()->count(3)->create();
    User::factory(4)
        ->hasSubscription()
        ->sequence(
            ['club_id' => $clubs[0]->id],
            ['club_id' => $clubs[1]->id],
        )
        ->create();

    User::factory([
        'club_id' => $clubs[0]->id,
        'email' => 'paid@test.com',
    ])
    ->hasSubscription(['paid_at' => Carbon::now()])
    ->create();

    $totals = ReportsService::subscriptionsPerClub();

    expect($totals)->toHaveLength(3);
    expect($totals->toArray())->toContain([
        'name' => $clubs[0]->name,
        'total' => 3,
        'pending' => 2,
        'paid' => 1
    ]);
    expect($totals->toArray())->toContain([
        'name' => $clubs[1]->name,
        'total' => 2,
        'pending' => 2,
        'paid' => 0
    ]);
    expect($totals->toArray())->toContain([
        'name' => $clubs[2]->name,
        'total' => 0,
        'pending' => 0,
        'paid' => 0
    ]);
});
