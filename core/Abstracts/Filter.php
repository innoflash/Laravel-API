<?php

namespace Core\Abstracts;

abstract class Filter
{
    abstract public function getAvailableFilters(): array;
}
