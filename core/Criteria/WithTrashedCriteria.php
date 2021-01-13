<?php

namespace Core\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

class WithTrashedCriteria
{
    /***
     * @param Builder             $model
     * @param RepositoryInterface $response
     *
     * @return mixed
     */
    public function apply(Builder $model, RepositoryInterface $response)
    {
        return $model->withTrashed();
    }
}
