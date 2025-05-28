<?php

namespace Modules\Announcement\Models;

use App\Concerns\Eloquent\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Announcement\Database\Factories\AnnouncementFactory;
use Modules\Announcement\Events\AnnouncementCreated;
use Modules\Announcement\Events\AnnouncementDeleted;
use Modules\Attachment\Concerns\HasAttachments;
use Modules\Classroom\Concerns\Eloquent\IsActivity;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class Announcement extends Model
{
    use HasFactory, HasUuid, BelongsToThroughTrait, HasAttachments, IsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'edited',
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
        'edited' => false,
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'created' => AnnouncementCreated::class,
        'deleted' => AnnouncementDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'edited' => 'boolean',
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return new AnnouncementFactory;
    }

    /**
     * Get the teacher who made the announcement.
     *
     * @return \Znck\Eloquent\Relations\BelongsToThrough<Teacher, Classroom>
     */
    public function teacher(): BelongsToThrough
    {
        return $this->belongsToThrough(Teacher::class, Classroom::class);
    }

    /**
     * Get the classroom in which the announcement was made.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Classroom>
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
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
        static::updating(function (Announcement $announcement) {
            $announcement->edited = true;
        });
    }
}
