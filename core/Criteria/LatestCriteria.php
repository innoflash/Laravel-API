<?php

namespace Core\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LatestCriteria implements CriteriaInterface
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
     * @param             $model
     * @param RepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->latest($this->column);
    }
}
