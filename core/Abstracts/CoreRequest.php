<?php

namespace Core\Abstracts;

use Core\Abstracts\Mappers\Mapper;
use Core\Mappers\ModelMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class CoreRequest extends FormRequest
{
    /**
     * The rules to be applied to the request.
     * @return array
     */
    abstract function rules(): array;

    protected function prepareForValidation()
    {
        $this->merge($this->route()->parameters());
    }

    /**
     * Makes the mapper object.
     * @return Mapper
     */
    public function mapper(): Mapper
    {
        return new ModelMapper($this->validated(), $this->ministryId());
    }

    /**
     * Fetches the ministry id and set it to the mapper.
     * @return int|string|null
     */
    private function ministryId()
    {
        return $this->ministry_id ?: auth('api')->id();
    }

    /**
     * Maps a model from the given data.
     *
     * @param string      $class
     * @param string|null $key
     *
     * @return mixed
     */
    public function map(string $class, string $key = null): Model
    {
        return $this->mapper()->map($class, $key);
    }

    /**
     * Maps collections from the given data.
     *
     * @param string $class
     * @param string $key
     *
     * @return mixed
     */
    public function mapCollection(string $class, string $key)
    {
        return $this->mapper()->mapCollection($class, $key);
    }

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function mapperExcept(array $keys): Mapper
    {
        return $this->mapper()->except($keys);
    }

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function mapperOnly(array $keys = []): Mapper
    {
        if ($keys) {
            return $this->mapper()->only($keys);
        }

        $keys = array_keys($this->container->call([$this, 'rules']));

        return $this->mapper()->only($keys);
    }
}
