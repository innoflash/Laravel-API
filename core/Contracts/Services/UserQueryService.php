<?php

namespace Core\Contracts\Services;

use Core\Models\User;

/**
 * Interface UserQueryService
 */
interface UserQueryService
{
    /**
     * @param int $id
     *
     * @return User
     */
    public function find(int $id): User;
}
