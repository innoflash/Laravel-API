<?php

namespace Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Core\Models\User;
use Core\Contracts\Repositories\UserRepository as RepositoryInterface;

/**
 * Class DefaultUserRepository
 */
class DefaultUserRepository extends BaseRepository implements RepositoryInterface
{
    protected $fieldSearchable = [];

    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
