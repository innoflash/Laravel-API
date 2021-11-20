<?php

namespace Core\Abstracts\Contracts;

use Core\Abstracts\Repositories\Filter;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

interface CoreBaseRepositoryInterface extends RepositoryCriteriaInterface, RepositoryInterface
{
    public function pushFilter(Filter $filter);
}
