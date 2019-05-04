<?php

namespace Esat\Support\Model;

use Esat\Support\Traits\EnumTrait;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Throwable;

/**
 * Class BaseModel
 * @package Esat\Support\Model
 */
abstract class BaseModel
{
    use EnumTrait;

    const NULL_VALUE_STRING = 'null';
    const NULL_VALUE_INT_NUMBER = -PHP_INT_MAX;
    const NULL_VALUE_FLOAT_NUMBER = -1.7976931348623e+308;

    /**
     * BaseModel constructor.
     *
     * @param array $model
     */
    public function __construct($model = [])
    {
        $this->loadFromArray($model);
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getPropertyByName($name, $default = null)
    {
        try {
            return $this->$name;
        } catch (Throwable $ex) {
            return $default;
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setPropertyByName($name, $value)
    {
        try {
            $this->$name = $value;
        } catch (Throwable $ex) {
        }
    }

    /**
     * @param array $array
     *
     * @return $this
     */
    public function loadFromArray($array = [])
    {
        foreach ($array as $name => $value) {
            $this->setPropertyByName($name, $value);
        }

        return $this;
    }

    /**
     * Convert the current object and its related entities to array
     *
     * @param int $filter It can be configured using the ReflectionProperty constants
     *
     * @return array
     * @throws ReflectionException
     */
    public function toArray($filter = ReflectionProperty::IS_PROTECTED)
    {
        $objectArray = [];

        // Get all properties
        $ref = new ReflectionClass($this);
        $properties = $ref->getProperties($filter);
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $objectArray[$propertyName] = $this->resolveProperty($this->$propertyName, $filter);
        }

        return $objectArray;
    }

    /**
     * @param array $parameters
     * @param int   $filter
     *
     * @return array
     * @throws ReflectionException
     */
    public function toArrayExtended($parameters = [], $filter = ReflectionProperty::IS_PROTECTED)
    {
        return $this->toArray($filter) + ($parameters ?: []);
    }

    /**
     * Convert array with related entities to array
     *
     * @param string|array|object|mixed $propertyValue
     * @param int                       $filter It can be configured using the ReflectionProperty constants
     *
     * @return array
     */
    private function resolveProperty($propertyValue, $filter = ReflectionProperty::IS_PROTECTED)
    {
        // Check if property exists and return null otherwise
        if (empty($propertyValue)) {
            return $propertyValue;
        }

        // Resolve array of properties
        if (is_array($propertyValue)) {
            $objectArray = [];
            foreach ($propertyValue as $key => $subPropertyValue) {
                $objectArray[$key] = $this->resolveProperty($subPropertyValue, $filter);
            }

            return $objectArray;
        }

        return (is_object($propertyValue) && method_exists($propertyValue, 'toArray')) ? $propertyValue->toArray($filter) : $propertyValue;
    }

    /**
     * @param $name
     * @param $value
     *
     * @throws Exception
     */
    public function __set($name, $value)
    {
        throw new Exception(static::class . ' does not have a property with the name [' . $name . ']');
    }
}
