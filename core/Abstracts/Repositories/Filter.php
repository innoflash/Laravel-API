<?php

namespace Core\Abstracts\Repositories;

abstract class Filter
{
    abstract public function getAvailableFilters(): array;
}
