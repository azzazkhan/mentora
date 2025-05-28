<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

uses(Tests\TestCase::class);
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    DatabaseSeeder::cleanup();

    $this->student = User::factory()->create()->assignRole(Role::Student);
    $this->teacher = User::factory()->has(Teacher::factory())->create()->assignRole(Role::Teacher);
    $this->classroom = Classroom::factory()->for($this->teacher->teacher)->create();

    $this->classroom->students()->attach($this->student, ['enrolled_at' => now()]);
});

test('teacher can list submissions for assignment of their classroom', function () {
    $assignment = Assignment::factory()->for($this->classroom)->create();

    $response = $this
        ->actingAs($this->teacher)
        ->getJson(route('assignment::api.submissions.index', [
            'assignment' => $assignment,
        ]));

    $response->assertStatus(200);
})->group('api', 'submission', 'teacher');


test('teacher cannot list submissions for assignment of other classrooms', function () {
    $teacher = User::factory()->has(Teacher::factory())->create()->assignRole(Role::Teacher);
    $assignment = Assignment::factory()->for($this->classroom)->create();

    $response = $this
        ->actingAs($teacher)
        ->getJson(route('assignment::api.submissions.index', [
            'assignment' => $assignment,
        ]));

    $response->assertStatus(403);
})->group('api', 'submission', 'teacher');


test('student can view their submission record', function () {
    $assignment = Assignment::factory()->for($this->classroom)->create();
    $submission = $assignment->submissions()->where('user_id', $this->student->getKey())->firstOrFail();

    $response = $this->actingAs($this->student)->get(route('assignment::api.submissions.show', [
        'assignment' => $assignment,
        'submission' => $submission,
    ]));

    $response->assertStatus(200);
})->group('api', 'submission', 'student');


test('unenrolled student cannot view their submission record', function () {
    $assignment = Assignment::factory()->for($this->classroom)->create();
    $submission = $assignment->submissions()->where('user_id', $this->student->getKey())->firstOrFail();
    $this->classroom->students()->detach($this->student);

    $response = $this->actingAs($this->student)->get(route('assignment::api.submissions.show', [
        'assignment' => $assignment,
        'submission' => $submission,
    ]));

    $response->assertStatus(403);
})->group('api', 'submission', 'student');


test('student cannot view others submission record', function () {
    $user = User::factory()->create()->assignRole(Role::Student);

    $this->classroom->students()->attach($user, ['enrolled_at' => now()]);

    $assignment = Assignment::factory()->for($this->classroom)->create();
    $submission = $assignment->submissions()->whereNot('user_id', $user->getKey())->firstOrFail();

    $response = $this->actingAs($user)->get(route('assignment::api.submissions.show', [
        'assignment' => $assignment,
        'submission' => $submission,
    ]));

    $response->assertStatus(403);
})->group('api', 'submission', 'student');


// test('student can update their submission')->group('api', 'submission', 'student')->skip('work in progress');
// test("student cannot update other student's submissions")->group('api', 'submission', 'student')->skip('work in progress');
// test("student can add attachments to their submission")->group('api', 'submission', 'student')->skip('work in progress');
// test("student can turn in their submission submission")->group('api', 'submission', 'student')->skip('work in progress');
// test("student can turn in submission after due date [constrained]")->group('api', 'submission', 'student')->skip('work in progress');
// test("student cannot turn in submission with no attachments")->group('api', 'submission', 'student')->skip('work in progress');
// test("student cannot turn in submission after due date")->group('api', 'submission', 'student')->skip('work in progress');

// test("student can turn back their submission")->group('api', 'submission', 'student')->skip('work in progress');
// test("student cannot turn back their submission after due date")->group('api', 'submission', 'student')->skip('work in progress');

// test('teacher can list assignment submissions of their classroom')->group('api', 'submission', '')->skip('work in progress');
// test('teacher cannot list assignment submissions of other classrooms')->group('api', 'submission', '')->skip('work in progress');
// test('teacher can view details of assignment submission of their classroom')->group('api', 'submission', '')->skip('work in progress');
// test('teacher cannot view details of assignment submission of other classroom')->group('api', 'submission', '')->skip('work in progress');

// test("teacher can update assignment submission of their classrooms")->group('api', 'submission', '')->skip('work in progress');
// test("teacher cannot update assignment submission of other classrooms")->group('api', 'submission', '')->skip('work in progress');

// test("teacher can grade assignment submission")->group('api', 'submission', 'teacher')->skip('work in progress');
// test("teacher cannot grade assignment submission before due date")->group('api', 'submission', 'teacher')->skip('work in progress');
// test("teacher cannot grade missing assignment submission")->group('api', 'submission', 'teacher')->skip('work in progress');

// test("late submissions are marked as late")->group('api', 'submission')->skip('work in progress');
