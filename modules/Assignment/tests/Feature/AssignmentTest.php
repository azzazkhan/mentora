<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Assignment\Models\Assignment;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

uses(Tests\TestCase::class);
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(fn() => DatabaseSeeder::cleanup());

test('student can list assignments', function () {
    $user = User::factory()->create()->assignRole(Role::Student);

    $classroom = Classroom::factory()->create();
    $classroom->students()->attach($user, ['enrolled_at' => now()]);

    Assignment::factory()->count(3)->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.assignments.index', [
        'classroom' => $classroom,
    ]));

    $response
        ->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', 3)->etc();
        });
})->group('api', 'assignment', 'student');


test('student cannot list assignments of non-enrolled classrooms', function () {
    $user = User::factory()->create()->assignRole(Role::Student);

    $classroom = Classroom::factory()->create();

    Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.assignments.index', [
        'classroom' => $classroom,
    ]));

    $response->assertStatus(403);
})->group('api', 'assignment', 'student');


test('teacher can list assignments', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();

    Assignment::factory()->count(3)->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.assignments.index', [
        'classroom' => $classroom,
    ]));

    $response
        ->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', 3)->etc();
        });
})->group('api', 'assignment', 'teacher');


test('teacher cannot list assignments of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();

    Assignment::factory()->count(3)->for($classroom)->create();

    $response = $this->actingAs($user)->get(route('classroom::api.assignments.index', [
        'classroom' => $classroom,
    ]));

    $response->assertStatus(403);
})->group('api', 'assignment', 'teacher');


test('teacher can create assignment', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create(['status' => Status::Started]);

    $response = $this->actingAs($user)->postJson(
        route('classroom::api.assignments.store', ['classroom' => $classroom]),
        [
            'title' => fake()->words(5, true),
            'content' => fake()->sentence(),
            'due_date' => now()->addHour(),
            'attachments' => [],
        ],
    );

    $response->assertStatus(201);
})->group('api', 'assignment', 'teacher');


test('teacher cannot create assignment in other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create(['status' => Status::Started]);

    $response = $this->actingAs($user)->postJson(
        route('classroom::api.assignments.store', ['classroom' => $classroom]),
        [
            'title' => fake()->words(5, true),
            'description' => fake()->sentence(),
            'due_date' => now()->addHour(),
            'attachments' => [],
        ],
    );

    $response->assertStatus(403);
})->group('api', 'assignment', 'teacher');


test('student can view assignment', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::Student);

    $classroom = Classroom::factory()->create();
    $classroom->students()->attach($user, ['enrolled_at' => now()]);

    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('assignment::api.show', ['assignment' => $assignment]),
    );

    $response->assertStatus(200);
})->group('api', 'assignment', 'teacher');


test('student cannot view assignment of non-enrolled classrooms', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::Student);

    $classroom = Classroom::factory()->create();

    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('assignment::api.show', ['assignment' => $assignment]),
    );

    $response->assertStatus(403);
})->group('api', 'assignment', 'teacher');


test('teacher can view assignment', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();
    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('assignment::api.show', ['assignment' => $assignment]),
    );

    $response->assertStatus(200);
})->group('api', 'assignment', 'teacher');


test('teacher cannot view assignment of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();
    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->getJson(
        route('assignment::api.show', ['assignment' => $assignment]),
    );

    $response->assertStatus(403);
})->group('api', 'assignment', 'teacher');


test('teacher can update assignment', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();
    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->putJson(
        route('assignment::api.update', ['assignment' => $assignment]),
        [
            'description' => fake()->sentence(),
        ],
    );

    $response->assertStatus(200);
})->group('api', 'assignment', 'teacher');


test('teacher cannot update assignment of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();
    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->putJson(
        route('assignment::api.update', ['assignment' => $assignment]),
        [
            'description' => fake()->sentence(),
        ],
    );

    $response->assertStatus(403);
})->group('api', 'assignment', 'teacher');


test('teacher can delete assignment', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->for($user->teacher)->create();
    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->deleteJson(
        route('assignment::api.destroy', ['assignment' => $assignment]),
    );

    $response->assertStatus(204);
})->group('api', 'assignment', 'teacher');


test('teacher cannot delete assignment of other classrooms', function () {
    $user = User::factory()->has(Teacher::factory())->create();
    $user->assignRole(Role::Teacher);

    $classroom = Classroom::factory()->create();
    $assignment = Assignment::factory()->for($classroom)->create();

    $response = $this->actingAs($user)->deleteJson(
        route('assignment::api.destroy', ['assignment' => $assignment]),
    );

    $response->assertStatus(403);
})->group('api', 'assignment', 'teacher');
