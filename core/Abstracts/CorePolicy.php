<?php

namespace Core\Abstracts;

use Carbon\Carbon;
use Core\Exceptions\MinistrySubscriptionExpiredException;
use Core\Models\Account;
use Core\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

abstract class CorePolicy
{
    use HandlesAuthorization;

    /**
     * Fetches the authenticated user.
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * Gets the role name.
     *
     * @param int $roleId
     *
     * @return string
     */
    protected function getRole(int $roleId): string
    {
        return User::getMapValue($roleId);
    }

    /**
     * Checks if this ministry`s account is still active.
     *
     * @param User|null $user
     *
     * @return bool
     * @throws MinistrySubscriptionExpiredException
     */
    protected function isSubscriptionActive(User $user = null)
    {
        $user ?: auth()->user();
        if (Carbon::parse($user->account->expiry_date)->isBefore(now())) {
            throw new MinistrySubscriptionExpiredException();
        }

        return true;
    }

    /**
     * Checks if model belongs to user.
     *
     * @param User  $user
     * @param Model $model
     *
     * @return bool
     */
    protected function belongsToMinistry(User $user, Model $model): bool
    {
        return $user->hasRole($this->getRole(User::MINISTRY))
               && (int) $model->ministry_id === $user->id;
    }

    /**
     * Tests if a ministry can create a model.
     *
     * @param User     $user
     * @param string   $model
     * @param int      $limit
     * @param int|null $accountId
     *
     * @return bool
     * @throws MinistrySubscriptionExpiredException
     */
    protected function ministryCanCreate(User $user, string $model, int $limit, int $accountId = null): bool
    {
        if (!$accountId) {
            $accountId = Account::FREE;
        }

        if ((int) $user->account->account_id === $accountId) {
            return $model::where('ministry_id', $user->id)
                         ->whereBetween('created_at', [now()->firstOfMonth(), now()->lastOfMonth()])
                         ->count() < $limit;
        }

        return $this->isSubscriptionActive($user);
    }
}
