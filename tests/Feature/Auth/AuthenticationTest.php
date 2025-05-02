<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get(route('auth.login'));

    $response->assertStatus(200);
})->group('web', 'auth');


test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
})->group('web', 'auth');


test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
})->group('web', 'auth');


test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('auth.logout'));

    $this->assertGuest();
    $response->assertRedirect(route('home', absolute: false));
})->group('web', 'auth');
