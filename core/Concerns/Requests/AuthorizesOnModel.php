<?php

namespace Core\Concerns\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * Trait AuthorizesOnModel
 * @mixin FormRequest
 * @package Core\Concerns\Requests
 */
trait AuthorizesOnModel
{
    use ResolvesAction;

    /**
     * Fetches the repository to be used for fetching the model
     * @return string
     */
    abstract function getRepositoryName(): string;

    public function rules(): array
    {
        return [];
    }


    /**
     * Returns the user action that can be logged as an error when an error message is thrown.
     * @return string
     */
    protected function userAction(): string
    {
        return $this->action();
    }

    public function validate(array $rules, ...$params)
    {
        $rules = array_merge($rules, [
            'id' => 'required|integer|exists:' . $this->getModelTable() . ',id',
        ]);
        parent::validate($rules, $params);
    }

    /**
     * @inheritDoc
     */
    public function getPolicyObject()
    {
        return resolve($this->getRepositoryName())->find((int) $this->id);
    }

    /**
     * Guesses the name of the table where the id should exist in.
     * @return string
     */
    protected function getModelTable(): string
    {
        return Str::of($this->getRepositoryName())
                  ->afterLast('\\')
                  ->beforeLast('Repository')
                  ->lower()
                  ->plural()
                  ->__toString();
    }

    /**
     * Guesses the name of the item under test.
     * @return string
     */
    protected function getItemName(): string
    {
        return Str::of($this->getRepositoryName())
                  ->afterLast('\\')
                  ->beforeLast('Repository')
                  ->lower()
                  ->__toString();
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException($this->authFailureMessage());
    }

    protected function authFailureMessage(): string
    {
        return 'You are not allowed to ' . $this->userAction() . ' this ' . $this->getItemName() . '.';
    }

    public function authorize()
    {
        return $this->user()->can($this->action(), $this->getPolicyObject());
    }
}
