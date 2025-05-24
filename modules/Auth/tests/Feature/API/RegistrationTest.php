<?php

use Database\Seeders\DatabaseSeeder;

uses(Tests\TestCase::class);
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(fn() => DatabaseSeeder::cleanup());

test('new users can register', function () {
    $response = $this->post(route('auth::api.register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertNoContent();

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
})->group('api', 'auth', 'registration');
