<?php

use App\Models\User;

it('it denies unautheticated users', function () {
    $response = $this->get('/admin');

    $response->assertRedirectToRoute('login');
});

it('it does not allow non admin users', function () {
    $user = User::factory()->hasSubscription()->forClub()->create();

    $response = $this->actingAs($user)->get('/admin');

    $response->assertStatus(403);
});

it('it allows authenticated users', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);

    $response = $this->actingAs($user)->get('/admin');

    $response->assertStatus(200);
});

it('renders the admin dashboard', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);

    $response = $this->actingAs($user)->get('/admin');

    $response->assertViewIs('admin.dashboard');
});
