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
