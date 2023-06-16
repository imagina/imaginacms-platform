<?php

namespace Modules\Isite\Traits;

trait Rateable
{
    /**
     * Returns all ratings for this model.
     */
    public function ratings()
    {
        return $this->morphMany("Modules\Rateable\Entities\Rating", 'rateable');
    }

    /**
     * BASE METHODS TO CALCULATES
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }

    public function timesRated()
    {
        return $this->ratings()->count();
    }

    public function maxValueRated()
    {
        return $this->ratings()->max('rating');
    }
}
