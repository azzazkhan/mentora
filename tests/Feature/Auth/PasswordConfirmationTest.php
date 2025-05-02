<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('auth.password.confirm'));

    $response->assertStatus(200);
})->group('web', 'auth');


test('password can be confirmed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('auth.password.confirm'), [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
})->group('web', 'auth');


test('password is not confirmed with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('auth.password.confirm'), [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
})->group('web', 'auth');
