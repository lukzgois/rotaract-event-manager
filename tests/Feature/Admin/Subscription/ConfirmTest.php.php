<?php

use App\Models\Subscription;
use App\Models\User;

beforeEach(function () {
    $participant =  User::factory()->hasSubscription()->forClub()->create();
    $this->subscription = $participant->subscription;
});

function sendRequest($data = []) {
    $subscription_id = test()->subscription->id;
    $route = "/admin/subscriptions/{$subscription_id}/confirm";

    $admin = User::factory()->admin()->hasSubscription()->forClub()->create();

    return test()->actingAs($admin)->post($route, $data);
}

it('it denies unautheticated users', function () {
    $subscription_id = test()->subscription->id;
    $route = "/admin/subscriptions/{$subscription_id}/confirm";
    $response = $this->post($route);

    $response->assertRedirectToRoute('login');
});

it('it does not allow non admin users', function () {
    $user = User::factory()->hasSubscription()->forClub()->create();
    $subscription_id = test()->subscription->id;
    $route = "/admin/subscriptions/{$subscription_id}/confirm";

    $response = $this->actingAs($user)->post($route);

    $response->assertStatus(403);
});

it('denies if the subscription is already confirmed', function() {
    $user = User::factory()->admin()->forClub()->create();
    $subscription = User::factory()->has(Subscription::factory()->confirmed())->forClub()->create()->subscription;
    $route = "/admin/subscriptions/{$subscription->id}/confirm";

    $response = $this->actingAs($user)->post($route);

    $response->assertRedirectToRoute('participants.index');
    $response->assertSessionHas('error');
});

it('it allows authenticated users', function () {
    $response = sendRequest();

    $response->assertStatus(200);
});

it('sets the subscription data', function () {
    $data = [
        'value' => '180',
        'payment_type' => 'pix',
        'ticket_batch' => '1 Lote',
    ];

    sendRequest($data);
    $this->subscription->refresh();

    expect($this->subscription->value)->toBe(180);
    expect($this->subscription->payment_type)->toBe('pix');
    expect($this->subscription->ticket_batch)->toBe('1 Lote');
});

