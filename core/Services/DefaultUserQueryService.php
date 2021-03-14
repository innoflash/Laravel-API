<?php

namespace Core\Services;

use Core\Models\User;
use Core\Contracts\Repositories\UserRepository;
use Core\Contracts\Services\UserQueryService as QueryServiceInterface;

/**
 * Class DefaultUserQueryService
 */
class DefaultUserQueryService implements QueryServiceInterface
{
    private UserRepository $userRepository;

    /**
     * DefaultUserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(
       UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     *
     * @return User
     */
    public function find(int $id): User
    {
        return $this->userRepository->find($id);
    }
}
