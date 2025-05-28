<?php

namespace Modules\Classroom\Concerns\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Classroom\Models\Activity;

trait IsActivity
{
    /**
     * Get the activity for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne<Attachment>
     */
    public function activity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }

    /**
     * Laravel will call this function while booting the model.
     *
     * @return void
     */
    public static function bootIsActivity()
    {
        static::created(function (Model $model): void {
            $activity = new Activity;
            $activity->subject()->associate($model);
            $activity->classroom()->associate($model->classroom);
            $activity->save();
        });

        static::deleted(function (Model $model): void {
            $model->activity()->delete();
        });
    }
}
