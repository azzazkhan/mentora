<?php

use Database\Seeders\DatabaseSeeder;

uses(Tests\TestCase::class);
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(fn() => DatabaseSeeder::cleanup());

test('registration screen can be rendered', function () {
    $response = $this->get(route('auth::register'));

    $response->assertStatus(200);
})->group('web', 'auth', 'registration');

test('new users can register', function () {
    $response = $this->post(route('auth::register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
})->group('web', 'auth', 'registration');
