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

    $response = $this->actingAs($user)->post($route, [
        'value' => '180,00',
        'ticket_batch' => 'first_batch',
        'payment_type' => 'pix'
    ]);

    $response->assertRedirectToRoute('participants.index');
    $response->assertSessionHas('error');
});

it('validates the required fields', function () {
    $data = [
        'value' => '',
        'ticket_batch' => '',
        'payment_type' => '',
    ];
    $response = sendRequest($data);

    $response->assertInvalid([
        'value',
        'ticket_batch',
        'payment_type',
    ]);
});

it('validates if the value is a decimal with 2 digits (invalid value)', function ($value) {
    $data = ['value' => $value];

    $response = sendRequest($data);

    $response->assertInvalid([
        'value' => 'O campo value deve ser um número decimal válido.'
    ]);
})->with(['abc', '1abas', '100', '231.13144']);

it('validates if the value is a decimal with 2 digits (valid value)', function ($value) {
    $data = ['value' => $value];

    $response = sendRequest($data);

    $response->assertValid(['value']);
})->with(['100,00', '180,50']);

it('validates the ticket_batch value (invalid value)', function () {
    $data = ['ticket_batch' => 'invalid'];

    $response = sendRequest($data);

    $response->assertInvalid([
        'ticket_batch' => 'O lote de ingressos selecionado é inválido.'
    ]);
});

it('validates the ticket_batch value (valid value)', function () {
    $data = ['ticket_batch' => 'second_batch'];

    $response = sendRequest($data);

    $response->assertValid(['ticket_batch']);
});

it('validates the payment_type value (invalid value)', function () {
    $data = ['payment_type' => 'invalid'];

    $response = sendRequest($data);

    $response->assertInvalid([
        'payment_type' => 'A forma de pagamento selecionada é inválida.'
    ]);
});

it('validates the payment_type value (valid value)', function () {
    $data = ['payment_type' => 'pix'];

    $response = sendRequest($data);

    $response->assertValid(['payment_type']);
});

