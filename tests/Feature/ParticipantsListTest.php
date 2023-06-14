<?php

use App\Models\Club;
use App\Models\User;

it('responds to the url', function () {
    $response = $this->get('/inscritos');

    $response->assertStatus(200);
});

it('renders a list of users', function () {
    $users = User::factory()->hasSubscription(['paid_at' => '2023-01-01'])->forClub()->count(10)->create();
    $response = $this->get('/inscritos');

    $response->assertSee($users->pluck('name')->all());
});

it('renders the clubs', function () {
    User::factory()->hasSubscription(['paid_at' => '2023-01-01'])->forClub()->count(10)->create();
    $clubs = Club::all()->pluck('name');
    $response = $this->get('/inscritos');

    $response->assertSee($clubs->all());
});

it('does not render the admin users', function () {
    $admin = User::factory(['user_type' => 'admin'])->forClub()->create();
    $response = $this->get('/inscritos');

    $response->assertDontSee($admin->name);
});
