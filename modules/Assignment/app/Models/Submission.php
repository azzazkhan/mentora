<?php

namespace Modules\Assignment\Models;

use App\Concerns\Eloquent\HasUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Assignment\Database\Factories\SubmissionFactory;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Attachment\Concerns\HasAttachments;
use Modules\Classroom\Models\Classroom;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class Submission extends Model
{
    use HasFactory, HasUuid, BelongsToThroughTrait, HasAttachments;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'grade',
        'status',
        'is_late',
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
        'is_late' => false,
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'grade' => 'integer',
            'is_late' => 'boolean',
            'submitted_at' => 'datetime',
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return new SubmissionFactory;
    }

    /**
     * Get the classroom that the submission belongs to.
     */
    public function classroom(): BelongsToThrough
    {
        return $this->belongsToThrough(Classroom::class, Assignment::class);
    }

    /**
     * Get the assignment that the submission belongs to.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the user who made the submission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function turnedIn(): Attribute
    {
        return Attribute::get(function (mixed $value, array $attrs) {
            return Status::resolve($attrs['status'])->is([
                Status::TurnedIn,
                Status::Locked,
                Status::Processing,
                Status::Finalized,
            ]);
        });
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
        // ...
    }
}
