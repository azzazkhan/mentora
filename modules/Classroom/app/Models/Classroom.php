<?php

namespace Modules\Classroom\Models;

use App\Concerns\Eloquent\HasUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Announcement\Models\Announcement;
use Modules\Assignment\Models\Assignment;
use Modules\Classroom\Concerns\Eloquent\HasAttributes;
use Modules\Classroom\Concerns\Eloquent\HasQueryScopes;
use Modules\Classroom\Database\Factories\ClassroomFactory;
use Modules\Classroom\Enums\Classroom\Cover;
use Modules\Classroom\Enums\Color;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Events\ClassroomCreated;
use Modules\Classroom\Events\ClassroomUpdated;
use Modules\User\Models\Teacher;

class Classroom extends Model
{
    use HasFactory, HasUuid, HasQueryScopes, HasAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'cover',
        'color',
        'fee',
        'registration_started_at',
        'registration_ended_at',
        'started_at',
        'ended_at',
        'teacher_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => Status::Pending,
        'color' => Color::Blue,
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'created' => ClassroomCreated::class,
        'updated' => ClassroomUpdated::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fee' => 'integer',
            'cover' => Cover::class,
            'color' => Color::class,
            'status' => Status::class,
            'registration_started_at' => 'datetime',
            'registration_ended_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return new ClassroomFactory;
    }

    /**
     * Get the teacher associated with the classroom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Teacher>
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the students enrolled in the classroom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function students(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'enrollments')
            ->using(Enrollment::class)
            ->withTimestamps()
            ->as('enrollment')
            ->withPivot(['enrolled_at', 'transaction_id']);
    }

    /**
     * Get the pending students enrolled in the classroom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function pendingStudents(): BelongsToMany
    {
        return $this->students()->wherePivotNull('enrolled_at');
    }

    /**
     * Get the enrolled students in the classroom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function enrolledStudents(): BelongsToMany
    {
        return $this->students()->wherePivotNotNull('enrolled_at');
    }

    /**
     * Get the activities for this classroom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Activity>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the announcements for this classroom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Assignment>
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    /**
     * Get the assignments in the classroom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Assignment>
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get the route key name.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Get the route key.
     *
     * @return string
     */
    public function getRouteKey(): string
    {
        return $this->uuid;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        //
    }

    /**
     * Check if the specified student has enrolled in the classroom.
     */
    public function enrolled(User $student): bool
    {
        return $this
            ->enrolledStudents()
            ->wherePivot('user_id', $student->getKey())
            ->exists();
    }
}
