<?php

namespace Core\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

interface CriteriaContract
{
    /**
     * @param Builder             $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply(Builder $model, RepositoryInterface $repository);
}
