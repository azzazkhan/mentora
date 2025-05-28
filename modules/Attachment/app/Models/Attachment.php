<?php

namespace Modules\Attachment\Models;

use App\Concerns\Eloquent\HasUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Assignment\Models\Summary;
use Modules\Attachment\Database\Factories\AttachmentFactory;
use Modules\Attachment\Events\AttachmentCreated;

class Attachment extends Model
{
    use HasFactory, HasUuid, Prunable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'size',
        'mime_type',
        'disk',
        'path',
        'user_id',
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
        'created' => AttachmentCreated::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return new AttachmentFactory;
    }

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::query()
            ->where(function (Builder $query) {
                $query
                    ->where('attachable_type', null)
                    ->orWhere('attachable_id', null);
            })
            ->where('created_at', '<=', now()->subHours(12));
    }

    /**
     * Get the parent attachable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model>
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user that uploaded this attachment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the summary for this attachment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Summary>
     */
    public function summary(): HasOne
    {
        return $this->hasOne(Summary::class);
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
