<?php

use App\Models\User;

test('it denies unautheticated users', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirectToRoute('login');
});

test('it allows authenticated users', function () {
    $user = User::factory()->hasSubscription()->forClub()->create();
    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});

it('shows the subscription status (pending)', function () {
    $user = User::factory()->hasSubscription()->forClub()->create();

    $response = $this->actingAs($user)->get('/dashboard');
    $response->assertSee('Sua inscrição ainda não está confirmada.');
});

it('shows the subscription status (paid)', function () {
    $user = User::factory()->hasSubscription(['paid_at' => '2023-01-01 00:00:00'])->forClub()->create();

    $response = $this->actingAs($user)->get('/dashboard');
    $response->assertSee('Sua inscrição está confirmada!');
});

it('shows the payment cards if the subscription is pending', function () {
    $user = User::factory()->hasSubscription()->forClub()->create();

    $response = $this->actingAs($user)->get('/dashboard');
    $response->assertSee('Pagamento via PIX');
    $response->assertSee('Pagamento parcelado via Cartão de Crédito');
});

it('doesnt show the payment cards if the subscription is paid', function () {
    $user = User::factory()->hasSubscription(['paid_at' => '2023-01-01 00:00:00'])->forClub()->create();

    $response = $this->actingAs($user)->get('/dashboard');
    $response->assertDontSee('Pagamento via PIX');
    $response->assertDontSee('Pagamento parcelado via Cartão de Crédito');
});
