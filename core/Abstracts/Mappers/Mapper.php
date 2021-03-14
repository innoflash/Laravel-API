<?php

namespace Core\Abstracts\Mappers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface Mapper
{
    /**
     * @param string      $class
     * @param string|null $key
     *
     * @return mixed
     */
    public function map(string $class, string $key = null): Model;

    /**
     * @param string $class
     * @param string $key
     *
     * @return mixed
     */
    public function mapCollection(string $class, string $key);

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function withNullableFields(array $keys): Mapper;

    /**
     * @param array $attributes
     *
     * @return Mapper
     */
    public function encrypt(array $attributes): Mapper;

    /**
     * @param int|null $id
     *
     * @return Mapper
     */
    public function withId(int $id = null): Mapper;

    /**
     * @param int|null $ministryId
     *
     * @return Mapper
     */
    public function withMinistryId(int $ministryId = null): Mapper;

    /**
     * @param array $data
     *
     * @return Mapper
     */
    public function withData(array $data): Mapper;

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function except(array $keys): Mapper;

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function only(array $keys): Mapper;

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param \Closure $callback
     *
     * @return Mapper
     */
    public function beforeMap(\Closure $callback): Mapper;

    /**
     * @param string      $key
     * @param string|null $field
     * @param array|null  $hashMap
     *
     * @return Mapper
     */
    public function prepareData(string $key, string $field = null, array $hashMap = null): Mapper;

    /**
     * Create a new mapper from a subset of data
     *
     * @param string $key
     *
     * @return Mapper
     */
    public function newFromSubset(string $key): Mapper;
}
