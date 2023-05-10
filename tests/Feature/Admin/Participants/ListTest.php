<?php

use App\Models\User;

CONST ROUTE = '/admin/participants';

it('it denies unautheticated users', function () {
    $response = $this->get(ROUTE);

    $response->assertRedirectToRoute('login');
});

it('it does not allow non admin users', function () {
    $user = User::factory()->hasSubscription()->forClub()->create();

    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertStatus(403);
});

it('it allows authenticated users', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);

    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertStatus(200);
});

it('renders the admin dashboard', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);

    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertViewIs('admin.participants.index');
});

it("renders the participants' properties", function ($prop) {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    $participants = User::factory()->hasSubscription()->forClub()->count(5)->create();
    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertSee($participants->pluck($prop)->toArray());
})->with(['name', 'nickname']);

it("renders the participants' club", function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    $participants = User::factory()->hasSubscription()->forClub()->count(5)->create();
    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertSee($participants->pluck('club.name')->toArray());
});

it("renders the participants subscription's status (pending)", function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    User::factory()->hasSubscription()->forClub()->create();
    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertSee("Pendente");
});

it("renders the participants subscription's status (confirmed)", function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    User::factory()->hasSubscription(['paid_at' => '2023-01-01'])->forClub()->create();
    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertSee("Confirmada");
});
