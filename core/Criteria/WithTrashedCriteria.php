<?php

namespace Core\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WithTrashedCriteria implements CriteriaInterface
{
    /***
     * @param $model
     * @param RepositoryInterface $response
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $response)
    {
        return $model->withTrashed();
    }
}
