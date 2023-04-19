<?php

use App\Models\User;

it('responds to the url', function () {
    $response = $this->get('/inscritos');

    $response->assertStatus(200);
});

it('renders a list of users', function () {
    $users = User::factory()->forClub()->count(10)->create();
    $response = $this->get('/inscritos');

    $response->assertSee($users->pluck('name')->all());
});

it('does not render the admin users', function () {
    $admin = User::factory(['user_type' => 'admin'])->forClub()->create();
    $response = $this->get('/inscritos');

    $response->assertDontSee($admin->name);
});
