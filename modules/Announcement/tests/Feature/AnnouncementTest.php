<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Announcement\Models\Announcement;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

uses(Tests\TestCase::class);
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(fn() => DatabaseSeeder::cleanup());

test('student can list announcements', function () {
    $user = User::factory()->create();

    $classroom = Classroom::factory()->create();
    $classroom->students()->attach($user, ['enrolled_at' => now()]);

    Announcement::factory()->count(3)->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.announcements.index', [
        'classroom' => $classroom,
    ]));

    $response
        ->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', 3)->etc();
        });
})->group('api', 'announcement', 'student');


test('student cannot list announcements of non-enrolled classrooms', function () {
    $user = User::factory()->create();
    $classroom = Classroom::factory()->create();

    Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.announcements.index', [
        'classroom' => $classroom,
    ]));

    $response->assertStatus(403);
})->group('api', 'announcement', 'student');


test('teacher can list announcements', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();

    Announcement::factory()->count(3)->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.announcements.index', [
        'classroom' => $classroom,
    ]));

    $response
        ->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', 3)->etc();
        });
})->group('api', 'announcement', 'teacher');


test('teacher cannot list announcements of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();

    Announcement::factory()->count(3)->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.announcements.index', [
        'classroom' => $classroom,
    ]));

    $response->assertStatus(403);
})->group('api', 'announcement', 'teacher');


test('teacher can create announcement', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create(['status' => Status::Started]);

    $response = $this->actingAs($user)->postJson(
        route('classroom::api.announcements.store', ['classroom' => $classroom]),
        [
            'title' => fake()->words(5, true),
            'content' => fake()->sentence(),
            'attachments' => [],
        ],
    );

    $response->assertStatus(201);
})->group('api', 'announcement', 'teacher');


test('teacher cannot create announcement in other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create(['status' => Status::Started]);

    $response = $this->actingAs($user)->postJson(
        route('classroom::api.announcements.store', ['classroom' => $classroom]),
        [
            'title' => fake()->words(5, true),
            'content' => fake()->sentence(),
            'attachments' => [],
        ],
    );

    $response->assertStatus(403);
})->group('api', 'announcement', 'teacher');

test('student can view announcement', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::Student);

    $classroom = Classroom::factory()->create();
    $classroom->students()->attach($user, ['enrolled_at' => now()]);

    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('announcement::api.show', ['announcement' => $announcement]),
    );

    $response->assertStatus(200);
})->group('api', 'announcement', 'teacher');


test('student cannot view announcement of non-enrolled classrooms', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::Student);

    $classroom = Classroom::factory()->create();

    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('announcement::api.show', ['announcement' => $announcement]),
    );

    $response->assertStatus(403);
})->group('api', 'announcement', 'teacher');


test('teacher can view announcement', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();
    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('announcement::api.show', ['announcement' => $announcement]),
    );

    $response->assertStatus(200);
})->group('api', 'announcement', 'teacher');


test('teacher cannot view announcement of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();
    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('announcement::api.show', ['announcement' => $announcement]),
    );

    $response->assertStatus(403);
})->group('api', 'announcement', 'teacher');


test('teacher can update announcement', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();
    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->putJson(
        route('announcement::api.update', ['announcement' => $announcement]),
        [
            'content' => fake()->sentence(),
            'attachments' => [],
        ],
    );

    $response->assertStatus(200);
})->group('api', 'announcement', 'teacher');


test('teacher cannot update announcement of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();
    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->putJson(
        route('announcement::api.update', ['announcement' => $announcement]),
        [
            'content' => fake()->sentence(),
            'attachments' => [],
        ],
    );

    $response->assertStatus(403);
})->group('api', 'announcement', 'teacher');


test('teacher can delete announcement', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();
    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->deleteJson(
        route('announcement::api.destroy', ['announcement' => $announcement]),
    );

    $response->assertStatus(204);
})->group('api', 'announcement', 'teacher');


test('teacher cannot delete announcement of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();
    $announcement = Announcement::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->deleteJson(
        route('announcement::api.destroy', ['announcement' => $announcement]),
    );

    $response->assertStatus(403);
})->group('api', 'announcement', 'teacher');
