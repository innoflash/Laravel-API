<?php

namespace Core\Concerns;

use Core\Exceptions\KeyIsNotExistInHashMapException;
use Core\Exceptions\ValueIsNotExistInHashMapException;

/**
 * Trait InteractsWithHashMap
 * @package Core\Traits
 */
trait InteractsWithHashMap
{
    /**
     * @return array
     */
    abstract protected static function getMap(): array;

    /**
     * @param $key
     *
     * @return mixed
     * @throws KeyIsNotExistInHashMapException
     */
    public static function getMapValue($key)
    {
        $map = static::getMap();

        if (array_key_exists($key, $map)) {
            return $map[$key];
        }

        throw new KeyIsNotExistInHashMapException();
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValueIsNotExistInHashMapException
     */
    public static function getMapKey($value)
    {
        $map = array_flip(static::getMap());

        if (array_key_exists($value, $map)) {
            return $map[$value];
        }

        throw new ValueIsNotExistInHashMapException();
    }

    /**
     * @param \Closure $callback
     */
    public static function each(\Closure $callback): void
    {
        foreach (static::getMap() as $id => $value) {
            $callback($id, $value);
        }
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function has($value): bool
    {
        return in_array($value, static::getMap());
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public static function hasKey($key): bool
    {
        return array_has(static::getMap(), $key);
    }

    /**
     * getMapKeys
     *
     * @return array
     */
    public static function getMapKeys()
    {
        return array_keys(static::getMap());
    }

    /**
     * getMapValues
     *
     * @return array
     */
    public static function getMapValues()
    {
        return array_values(static::getMap());
    }
}
