<?php

use App\Models\Club;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Carbon;

it('belongs to a user', function () {
    $user = User::factory()->forClub()->create();
    $subscription = Subscription::factory()->for($user)->create();

    expect($subscription->user)->toBeInstanceOf(User::class);
});

test('isPaid(): returns true if paid_at is set', function() {
    $user = User::factory()->forClub()->create();
    $subscription = Subscription::factory(['paid_at' => '2022-01-01'])->for($user)->create();

    expect($subscription->isPaid())->toBeTrue();
});

test('isPaid(): returns false if paid_at is not set', function() {
    $user = User::factory()->forClub()->create();
    $subscription = Subscription::factory()->for($user)->create();

    expect($subscription->isPaid())->toBeFalse();
});

test('isPending(): returns false if paid_at is set', function() {
    $user = User::factory()->forClub()->create();
    $subscription = Subscription::factory(['paid_at' => '2022-01-01'])->for($user)->create();

    expect($subscription->isPending())->toBeFalse();
});

test('isPending(): returns true if paid_at is not set', function() {
    $user = User::factory()->forClub()->create();
    $subscription = Subscription::factory()->for($user)->create();

    expect($subscription->isPending())->toBeTrue();
});

it('returns the totals of confirmed/pending subscriptions grouped by club', function () {
    $clubs = Club::factory()->count(2)->create();
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

    $totals = Subscription::totalPerClub();

    expect($totals)->toHaveLength(2);
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
});
