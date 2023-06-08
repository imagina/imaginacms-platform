<?php

namespace Modules\Rateable\Traits;


use Modules\Rateable\Entities\Rating;

trait Rateable
{


	/**
     * Returns all ratings for this model.
     */
	public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
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