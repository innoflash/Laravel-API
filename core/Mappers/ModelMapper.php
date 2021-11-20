<?php

namespace Core\Mappers;

use Illuminate\Support\Arr;
use Core\Abstracts\Mappers\Mapper;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;
use Core\Exceptions\CoreInternalErrorException;
use Symfony\Component\HttpFoundation\File\File;

class ModelMapper implements Mapper
{
    protected Collection $data;
    protected Collection $dataArrays;
    protected Collection $nullableFields;
    protected Collection $files;
    protected $beforeMap = false;
    protected int $user_id;
    protected int $id;

    public function __construct(array $data = [], int $userId = null)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($userId)) {
            $this->user_id = $userId;
        }
        $this->nullableFields = new Collection();
        $this->data           = $this->clearCollection($this->parseData($data));
        $this->dataArrays     = $this->data->filter(function ($value) {
            return $value instanceof Collection;
        });
    }

    /**
     * @param             $key
     * @param             $value
     * @param Collection  $data
     * @param string|null $parentKey
     */
    private function removeNull($key, $value, Collection $data, string $parentKey = null)
    {
        if (is_null($value)) {
            $parentKey = $parentKey ? $parentKey . '.' . $key : $key;
            $this->nullableFields->put($parentKey, $value);

            $data->forget($key);
        }
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function parseData($data)
    {
        if (is_array($data)) {
            return (new Collection($data))->map(function ($value) {
                $value = $this->searchFile($value);

                return $this->parseData($value);
            });
        }

        return $data;
    }

    /**
     * @param Collection  $data
     * @param string|null $parentKey
     *
     * @return Collection
     */
    private function clearCollection(Collection $data, string $parentKey = null)
    {
        foreach ($data as $key => $value) {
            if ($value instanceof Collection) {
                $this->removeEmptyCollection($key, $value, $data, $parentKey);
            }

            $this->removeNull($key, $value, $data, $parentKey);
        }

        return $data;
    }

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function withNullableFields(array $keys): Mapper
    {
        $this->nullableFields = $this->nullableFields->filter(function ($value, $key) use ($keys) {
            return in_array($key, $keys);
        });

        $deepArr = $this->nullableFields->keys()->reduce(function ($deep, $key) {
            Arr::set($deep, $key, null);

            return $deep;
        }, []);

        // Illuminate Collection merge() only merged at top level, need to deep merge nested arrays with array_merge_recursive
        $this->data = new Collection(array_merge_recursive($this->data->toArray(), $deepArr));
        // also map to dataArrays to ensure deep values arent overwritten in all() method calls
        $this->dataArrays = (new Collection(array_merge_recursive($this->dataArrays->toArray(),
            $deepArr)))->filter(function ($value) {
            return $value instanceof Collection;
        });

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return Mapper
     */
    public function encrypt(array $attributes): Mapper
    {
        $this->data = $this->data->map(function ($item, $key) use ($attributes) {
            if (in_array($key, $attributes)) {
                return bcrypt($item);
            }

            return $item;
        });

        return $this;
    }

    /**
     * @param             $key
     * @param Collection  $value
     * @param Collection  $data
     * @param string|null $parentKey
     */
    private function removeEmptyCollection($key, Collection $value, Collection $data, string $parentKey = null)
    {
        $key   = $parentKey ? $parentKey . '.' . $key : $key;
        $value = $this->clearCollection($value, $key);

        if ($value->isEmpty()) {
            $data->forget($key);
        }
    }

    /**
     * @param \Closure $callback
     *
     * @return $this
     */
    public function beforeMap(\Closure $callback): Mapper
    {
        $this->beforeMap = $callback;

        return $this;
    }

    /**
     * @param $data
     *
     * @return null
     */
    private function searchFile($data)
    {
        if ($data instanceof File) {
            $this->files[] = $data;

            return null;
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function map(string $class, string $key = null): Model
    {
        $data = $this->all();

        if (!$key) {
            return $this->makeModel($class, $data->toArray());
        }

        $data = $data->get($key);

        if (is_null($data)) {
            return $this->makeModel($class);
        }

        return $this->makeModel($class, $data->toArray());
    }

    /**
     * @param string $class
     * @param string $key
     *
     * @return Collection|mixed
     */
    public function mapCollection(string $class, string $key)
    {
        $data = $this->all();

        return $this->makeModelCollection($data, $key, function (array $attributes) use ($class) {
            return $this->makeModel($class, $attributes);
        });
    }

    /**
     * @param Collection $collection
     * @param string     $key
     * @param callable   $callback
     *
     * @return Collection
     */
    private function makeModelCollection(Collection $collection, string $key, callable $callback): Collection
    {
        $property = $collection->get($key);

        if (is_null($property)) {
            return new Collection();
        }

        $property = $property instanceof Arrayable ? $property->toArray() : $property;

        return new Collection(array_map($callback, $property));
    }

    /**
     * @param string $class
     * @param array  $attributes
     *
     * @return Model
     * @throws CoreInternalErrorException
     */
    private function makeModel(string $class, array $attributes = []): Model
    {
        $model = app($class);
        if (!$model instanceof Model) {
            throw new CoreInternalErrorException("Class {$class} must be an instance of " . Model::class);
        }

        if (is_callable($this->beforeMap)) {
            $attributes = ($this->beforeMap)($attributes);
        };

        $fillablesCollection = collect($model->getFillable());

        $attributes = Arr::where($attributes, fn($value, $key) => $fillablesCollection->contains($key));

        return $model->fill($attributes);
    }

    /**
     * @param int $userId
     *
     * @return Mapper
     */
    public function withId(int $id = null): Mapper
    {
        if (!is_null($id)) {
            $this->id = $id;
        }

        $this->mergeIdWithData();

        $this->mergeIdWithDataArrays();

        return $this;
    }

    /**
     * @return void
     */
    private function mergeIdWithData(): void
    {
        if ($this->id) {
            $this->data = $this->data->merge(['id' => $this->id]);
        }
    }

    /**
     * @param array $keys
     *
     * @return void
     */
    private function mergeIdWithDataArrays(array $keys = ['*']): void
    {
        if ($keys === ['*']) {
            $this->includeInAllDataArrays(['id' => $this->id]);
        } else {
            $this->includeInDataArrays($keys, ['id' => $this->id]);
        }
    }

    /**
     * @param array $data
     *
     * @return Mapper
     */
    public function withData(array $data): Mapper
    {
        $this->data = $this->data->merge($data);
        $this->includeInAllDataArrays($data);

        return $this;
    }

    /**
     * @param array $includeData
     */
    private function includeInAllDataArrays(array $includeData): void
    {
        $this->dataArrays = $this->dataArrays->map(function (Collection $collection) use ($includeData) {
            return $this->includeInAll($collection, $includeData);
        });
    }

    /**
     * @param array $keys
     * @param array $includeData
     */
    private function includeInDataArrays(array $keys, array $includeData): void
    {
        $this->dataArrays = $this->dataArrays->map(function (Collection $collection, $key) use ($keys, $includeData) {
            if (in_array($key, $keys)) {
                return $this->includeInAll($collection, $includeData);
            }

            return $collection;
        });
    }

    /**
     * @param Collection $collection
     * @param array      $includeData
     *
     * @return Collection
     */
    private function includeInAll(Collection $collection, array $includeData): Collection
    {
        foreach ($collection as $key => $item) {
            if ($item instanceof Collection) {
                $collection[$key] = $this->includeInAll($item, $includeData);
                continue;
            }

            $collection = $collection->merge($includeData);
        }

        return $collection;
    }

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function except(array $keys): Mapper
    {
        $this->data->forget($keys);
        $this->dataArrays->forget($keys);

        return $this;
    }

    /**
     * @param array $keys
     *
     * @return Mapper
     */
    public function only(array $keys): Mapper
    {
        $this->data       = $this->data->only($keys);
        $this->dataArrays = $this->dataArrays->only($keys);

        return $this;
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->data->get($key, $default);
    }

    /**
     * @return Collection
     */
    public function files(): Collection
    {
        return $this->files;
    }

    /**
     * @param string      $key
     * @param string|null $field
     * @param array|null  $hashMap
     *
     * @return Mapper
     */
    public function prepareData(string $key, string $field = null, array $hashMap = null): Mapper
    {
        $data = $this->data->get($key, new Collection());

        if ($data instanceof Collection) {
            if ($field && $hashMap) {
                foreach ($hashMap as $alias) {
                    $isExists = $data->search(function (Collection $item) use ($field, $alias) {
                        return $item->get($field) == $alias;
                    });

                    if ($isExists === false) {
                        $data->push(new Collection([$field => $alias, 'user_id' => $this->user_id]));
                    }
                }
            } else {
                $data->push(new Collection(['user_id' => $this->user_id]));
            }
        }

        $this->data->put($key, $data);

        return $this;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->data->merge($this->dataArrays);
    }

    /**
     * Create a new mapper from a subset of data
     *
     * @param string $key
     *
     * @return Mapper
     */
    public function newFromSubset(string $key): Mapper
    {
        return new ModelMapper(
            Arr::get($this->all()->toArray(), $key, [])
        );
    }

    public function withUserId(int $userId): Mapper
    {
        $this->data = $this->data->merge([
            'user_id' => $userId
        ]);

        return $this;
    }
}
