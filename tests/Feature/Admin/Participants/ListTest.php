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

test('(pending subscription) renders the button to confirm the subscription', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    User::factory()->hasSubscription()->forClub()->create();
    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertSee("Confirmar inscrição");
});

test('(confirmed subscription) does not render the button to confirm the subscription', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    User::factory()->hasSubscription(['paid_at' => '2023-01-01'])->forClub()->create();
    $response = $this->actingAs($user)->get(ROUTE);

    $response->assertDontSee("Confirmar inscrição");
});

it('allows the subscription_status filter', function($value) {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    $response = $this->actingAs($user)->get(ROUTE . "?subscription={$value}");

    $response->assertOk();
})->with(['pending', 'confirmed', null, '']);

it('subscription_status filter does not allow other value than confirmed or pending', function() {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    $response = $this->actingAs($user)->get(ROUTE . "?subscription_status=invalid");

    $response->assertRedirect(ROUTE);
});

it('filter by the confirmed subscription', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    $confirmed = User::factory()->hasSubscription(['paid_at' => '2023-01-01'])->forClub()->create();
    $pending = User::factory()->hasSubscription()->forClub()->create();
    $response = $this->actingAs($user)->get(ROUTE . "?subscription_status=confirmed");

    $response->assertSee($confirmed->name);
    $response->assertDontSee($pending->name);
});

it('filter by pending subscriptions', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    $confirmed = User::factory()->hasSubscription(['paid_at' => '2023-01-01'])->forClub()->create();
    $pending = User::factory()->hasSubscription()->forClub()->create();
    $response = $this->actingAs($user)->get(ROUTE . "?subscription_status=pending");

    $response->assertSee($pending->name);
    $response->assertDontSee($confirmed->name);
});

it('filters by the participant name', function () {
    $user = User::factory()->hasSubscription()->forClub()->create(['user_type' => 'admin']);
    User::factory()
        ->hasSubscription()
        ->forClub()
        ->count(2)
        ->sequence(
            ['name' => 'Fulano de Tal'],
            ['name' => 'Beltrano'],
        )
        ->create();

    $response = $this->actingAs($user)->get(ROUTE . "?name=ful");

    $response->assertSee('Fulano de Tal');
    $response->assertDontSee('Beltrano');
});
