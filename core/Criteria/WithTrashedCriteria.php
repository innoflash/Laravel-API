<?php

namespace Core\Criteria;

use Core\Contracts\CriteriaContract;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

class WithTrashedCriteria implements CriteriaContract
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
