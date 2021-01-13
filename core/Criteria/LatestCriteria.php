<?php

namespace Core\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

class LatestCriteria
{
    /**
     * @var string
     */
    protected string $column;

    public function __construct(string $column = 'created_at')
    {
        $this->column = $column;
    }

    /**
     * Sorts the models with latest first.
     *
     * @param Builder             $model
     * @param RepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply(Builder $model, RepositoryInterface $repository)
    {
        return $model->latest($this->column);
    }
}
