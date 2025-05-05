<?php

namespace Modules\Classroom\Models;

use App\Concerns\Eloquent\HasUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Classroom\Database\Factories\ClassroomFactory;
use Modules\Classroom\Events\ClassroomCreated;
use Modules\User\Models\Teacher;

class Classroom extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
        'cover',
        'color',
        'start_at',
        'end_at',
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
    protected $attributes = [];

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'created' => ClassroomCreated::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
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
        return $this->belongsToMany(User::class, 'enrollments')->using(Enrollment::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // ...
    }
}
