<?php

namespace Core\Abstracts;

use Core\Abstracts\Filter;
use Core\Exceptions\NotAFilterException;
use Prettus\Repository\Eloquent\BaseRepository as PrettusBaseRepository;

abstract class BaseRepository extends PrettusBaseRepository
{
    public function pushFilter(Filter $filter): void
    {
        if (!$this->isAssoc($filter->getAvailableFilters())) {
            throw new NotAFilterException('The available filters are not valid, please you an associative array!');
        }

        if (request()->has('filter')) {
            $requestFilterKeys = array_keys(request('filter'));

            foreach ($requestFilterKeys as $key) {
                if (in_array($key, array_keys($filter->getAvailableFilters()))) {
                    $filterClass  = $filter->getAvailableFilters()[$key];
                    $requestValue = request('filter')[$key];

                    $this->pushCriteria(new $filterClass($requestValue));
                }
            }
        }
    }

    private function isAssoc(array $arr)
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
