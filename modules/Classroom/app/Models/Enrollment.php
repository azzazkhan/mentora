<?php

namespace Modules\Classroom\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Enrollment extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'enrollments';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
        ];
    }

    /**
     * Get the classroom associated with the enrollment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Classroom>
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get the student associated with the enrollment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
