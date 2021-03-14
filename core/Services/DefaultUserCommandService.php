<?php

namespace Core\Services;

use Core\Contracts\Repositories\UserRepository;
use Core\Models\User;
use Core\Contracts\Services\UserCommandService as CommandServiceInterface;

/**
 * Class DefaultUserCommandService
 */
class DefaultUserCommandService implements CommandServiceInterface
{
    private UserRepository $userRepository;

    /**
     * DefaultUserCommandService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function create(User $user): User
    {
        return $this->userRepository->saveModel($user);
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function update(User $user): User
    {
        /** @var User $user */
        return $this->userRepository->updateModel($user, $user->id);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->userRepository->delete($id);
    }
}
