<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\Eloquent\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Attachment\Models\Attachment;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Models\Classroom;
use Modules\Classroom\Models\Enrollment;
use Modules\User\Models\Teacher;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the teacher associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Teacher>
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Get the classrooms the user is enrolled in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Classroom>
     */
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'enrollments')->using(Enrollment::class);
    }

    /**
     * Get the classrooms the user is enrolled in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Classroom>
     */
    public function enrolledClassrooms(): BelongsToMany
    {
        return $this->classrooms()->wherePivotNotNull('enrolled_at');
    }

    /**
     * Get the classrooms the user is enrolled in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Classroom>
     */
    public function pendingClassrooms(): BelongsToMany
    {
        return $this->classrooms()->wherePivotNull('enrolled_at');
    }

    /**
     * Get the attachments for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Attachment>
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
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
}
