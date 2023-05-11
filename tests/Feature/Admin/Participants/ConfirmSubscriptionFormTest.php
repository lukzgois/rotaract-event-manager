<?php

use App\Models\User;

beforeEach(function () {
    $this->participant =  User::factory()->hasSubscription()->forClub()->create();
});

function visit() {
    $id = test()->participant->id;
    $route = "/admin/participants/{$id}/confirm_subscription";
    $user = User::factory()->admin()->hasSubscription()->forClub()->create();

    return test()->actingAs($user)->get($route);
}

it('it denies unautheticated users', function () {
    $id = $this->participant->id;
    $route = "/admin/participants/{$id}/confirm_subscription";
    $response = $this->get($route);

    $response->assertRedirectToRoute('login');
});

it('it does not allow non admin users', function () {
    $user = User::factory()->hasSubscription()->forClub()->create();
    $id = $this->participant->id;
    $route = "/admin/participants/{$id}/confirm_subscription";

    $response = $this->actingAs($user)->get($route);

    $response->assertStatus(403);
});

it('it allows authenticated users', function () {
    $response = visit();

    $response->assertStatus(200);
});

it('renders the view', function () {
    $response = visit();

    $response->assertViewIs('admin.participants.confirm_subscription');
});

it('passes the required properties to the view', function () {
    $response = visit();

    $response->assertViewHas('subscription', $this->participant->subscription);
    $response->assertViewHas('participant', $this->participant);
});
