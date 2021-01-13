<?php

namespace Core\Concerns;

use Carbon\Carbon;

trait FormatsDates
{
    /**
     * Converts created_to a DateTime object.
     *
     * @param $created_at
     *
     * @return \DateTime
     */
    public function getCreatedAtAttribute($created_at): \DateTime
    {
        return Carbon::parse($created_at)->toDateTime();
    }

    /**
     * Converts updated_to a DateTime object.
     *
     * @param $updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAtAttribute($updated_at): \DateTime
    {
        return Carbon::parse($updated_at)->toDateTime();
    }
}
