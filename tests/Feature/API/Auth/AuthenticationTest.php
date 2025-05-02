<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('users can login with valid credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson(route('api.auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
})->group('api', 'auth');


test('login response has valid structure', function () {
    $user = User::factory()->create();

    $response = $this->postJson(route('api.auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json
                ->has('token', function (AssertableJson $json) {
                    $json
                        ->whereType('value', 'string')
                        ->whereType('type', 'string')
                        ->whereType('expires_at', 'string');
                })
                ->has('user', function (AssertableJson $json) {
                    $json
                        ->whereType('uuid', 'string')
                        ->whereType('name', 'string')
                        ->whereType('email', 'string')
                        ->whereType('verified', 'boolean')
                        ->whereType('created_at', 'string')
                        ->whereType('updated_at', 'string');
                });
        });
})->group('api', 'auth');


test('user can authenticate using bearer token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withToken($token)->getJson(route('api.me'));

    $response->assertStatus(200)->assertJson(
        fn(AssertableJson $json) => $json->where('uuid', $user->uuid)->etc(),
    );
})->group('api', 'auth');


test('users can not login with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->postJson(route('api.auth.login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(422);
})->group('api', 'auth');


test('user can logout', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withToken($token)->postJson(route('api.auth.logout'));

    $response->assertNoContent();
})->group('api', 'auth');
