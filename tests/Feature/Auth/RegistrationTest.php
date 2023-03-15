<?php

use App\Providers\RouteServiceProvider;
use App\Models\Club;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

// test('new users can register', function () {
//     $response = $this->post('/register', [
//         'name' => 'Test User',
//         'email' => 'test@example.com',
//         'password' => 'password',
//         'password_confirmation' => 'password',
//     ]);

//     $this->assertAuthenticated();
//     $response->assertRedirect(RouteServiceProvider::HOME);
// });

it('validates the required fields', function () {
    $response = $this->post('/register', [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'birth_date' => '',
        'phone' => '',
        'club_id' => '',
        'address' => '',
        'city' => '',
        'state' => '',
        'zip_code' => '',
        'is_guest' => '',
        'blood_type' => '',
        'emergency_contact_name' => '',
        'emergency_contact_phone' => '',
        'allergies' => '',
        'food_restrictions' => '',
        'rg' => '',
        'cpf' => '',
        'agreed' => '',
    ]);

    $response->assertInvalid([
        'name',
        'email',
        'password',
        'birth_date',
        'phone',
        'club_id',
        'address',
        'city',
        'state',
        'zip_code',
        'is_guest',
        'blood_type',
        'emergency_contact_name',
        'emergency_contact_phone',
        'allergies',
        'food_restrictions',
        'rg',
        'cpf',
        'agreed',
    ]);
    $response->assertRedirected('/register');
})->throws(Exception::class);

it('validates the state (invalid value)', function() {
    $response = $this->post('/register', [
        'state' => 'invalid value'
    ]);

    $response->assertInvalid([
        'state' => 'O estado selecionado é inválido.'
    ]);
});

it('validates the state (valid value)', function($state) {
    $response = $this->post('/register', [
        'state' => $state
    ]);

    $response->assertValid(['state']);
})->with(App\Enums\BrazilianState::toArray());

it('validates the birth_date (required)', function () {
    $response = $this->post('/register', [
        'birth_date' => 'invalid value'
    ]);

    $response->assertInvalid([
        'birth_date' => 'O campo data de nascimento não é uma data válida.'
    ]);
});

it('validates the birth_date (should be 18+)', function () {
    $response = $this->post('/register', [
        'birth_date' => '2005-06-16'
    ]);

    $response->assertInvalid([
        'birth_date' => 'O campo data de nascimento deve ser uma data posterior ou igual a 2005-06-17.'
    ]);
});

it('validates the club_id (integer)', function () {
    $response = $this->post('/register', [
        'club_id' => 'invalid value'
    ]);

    $response->assertInvalid([
        'club_id' => 'O campo clube deve ser um número inteiro.'
    ]);
});

it('validates the club_id (dont exists on database)', function () {
    $response = $this->post('/register', [
        'club_id' => 18
    ]);

    $response->assertInvalid([
        'club_id' => 'O campo clube selecionado é inválido.'
    ]);
});

it('validates the club_id (exists on database)', function () {
    $club = Club::factory()->create();

    $response = $this->post('/register', [
        'club_id' => $club->id
    ]);

    $response->assertValid(['club_id']);
});

it('validates the is_guest (wrong value)', function () {
    $response = $this->post('/register', [
        'is_guest' => 'invalid value'
    ]);

    $response->assertInvalid([
        'is_guest' => 'O campo is guest deve ser verdadeiro ou falso.'
    ]);
});

it('validates the is_guest (correct value)', function ($value) {
    $response = $this->post('/register', [
        'is_guest' => $value
    ]);

    $response->assertValid(['is_guest']);
})->with([true, false, "0", "1", 0, 1]);

it('validates the blood_type (enum)', function () {
    $response = $this->post('/register', [
        'blood_type' => 'invalid value'
    ]);

    $response->assertInvalid([
        'blood_type' => 'O tipo sanguíneo selecionado é inválido.'
    ]);
});

it('accepts only the correct blood_types', function (string $blood_type) {
    $response = $this->post('/register', [
        'blood_type' => $blood_type
    ]);

    $response->assertValid(['blood_type']);
})->with(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);

it('validates the agreed (not accepted)', function () {
    $response = $this->post('/register', [
        'agreed' => 'false'
    ]);

    $response->assertInvalid([
        'agreed' => 'O campo regulamento deve ser aceito.'
    ]);
});

it('validates the agreed (accepted)', function ($value) {
    $response = $this->post('/register', [
        'agreed' => $value
    ]);

    $response->assertValid(['agreed']);
})->with([true, 'true', 1, 'on']);
