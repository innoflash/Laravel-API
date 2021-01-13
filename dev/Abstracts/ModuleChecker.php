<?php

namespace Dev\Abstracts;

use Dev\Exceptions\NoModuleSetException;
use Illuminate\Support\Facades\Cache;

class ModuleChecker
{
    /**
     * Checks if a module is set.
     * @throws NoModuleSetException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Exception
     */
    public function checkModule()
    {
        if (!cache()->has('current_module')) {
            throw new NoModuleSetException();
        }
    }

    /**
     * Deletes the current module.
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function clearModule()
    {
        cache()->delete('current_module');
    }

    /**
     * Fetches the current module.
     * @return string
     * @throws NoModuleSetException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function module(): string
    {
        $this->checkModule();

        return Cache::get('current_module');
    }
}
