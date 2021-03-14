<?php

namespace Core\Contracts\Services;

use Core\Models\User;

/**
 * Interface UserCommandService
 */
interface UserCommandService
{
    /**
     * @param User $user
     *
     * @return User
     */
    public function create(User $user): User;

    /**
     * @param User $user
     *
     * @return User
     */
    public function update(User $user): User;

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;
}
