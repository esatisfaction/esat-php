<?php

namespace Esat\Support\Model\Propel;

use Esat\Support\Model\BaseModel;
use Esat\Support\Traits\EnumTrait;
use ReflectionProperty;

/**
 * Class FilterCriteria
 * @package Esat\Support\Model\Propel
 */
class FilterCriteria extends BaseModel
{
    use EnumTrait;

    const CRITERIA_EQUAL = 'EQUAL';
    const CRITERIA_NOT_EQUAL = 'NOT_EQUAL';
    const CRITERIA_ALT_NOT_EQUAL = 'ALT_NOT_EQUAL';
    const CRITERIA_NULL = 'NULL';
    const CRITERIA_NOT_NULL = 'NOT_NULL';
    const CRITERIA_GREATER_THAN = 'GREATER_THAN';
    const CRITERIA_LESS_THAN = 'LESS_THAN';
    const CRITERIA_GREATER_EQUAL = 'GREATER_EQUAL';
    const CRITERIA_LESS_EQUAL = 'LESS_EQUAL';
    const CRITERIA_LIKE = 'LIKE';
    const CRITERIA_NOT_LIKE = 'NOT_LIKE';
    const CRITERIA_IN = 'IN';
    const CRITERIA_NOT_IN = 'NOT_IN';

    const VALUE_NULL_ALIAS = 'null';

    /**
     * @var array
     */
    protected $filter_by;

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function equal($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_EQUAL);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function notEqual($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_NOT_EQUAL);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function altNotEqual($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_ALT_NOT_EQUAL);
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function null($name)
    {
        return $this->add($name, self::VALUE_NULL_ALIAS, self::CRITERIA_NULL);
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function notNull($name)
    {
        return $this->add($name, self::VALUE_NULL_ALIAS, self::CRITERIA_NOT_NULL);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function greaterThan($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_GREATER_THAN);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function lessThan($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_LESS_THAN);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function greaterEqual($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_GREATER_EQUAL);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function lessEqual($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_LESS_EQUAL);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function like($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_LIKE);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function notLike($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_NOT_LIKE);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function in($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_IN);
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function notIn($name, $value)
    {
        return $this->add($name, $value, self::CRITERIA_NOT_IN);
    }

    /**
     * @param string $name The name of the column in phpname type (e.g. 'ColumnName')
     * @param mixed  $value
     * @param string $type
     *
     * @return $this
     */
    public function add($name, $value, $type = self::CRITERIA_EQUAL)
    {
        $this->filter_by[$type][$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getFilterBy()
    {
        return $this->filter_by;
    }

    /**
     * @param array $filter_by
     *
     * @return $this
     */
    public function setFilterBy(array $filter_by)
    {
        $this->filter_by = $filter_by;

        return $this;
    }

    /**
     * @param int $filter
     *
     * @return array
     */
    public function toArray($filter = ReflectionProperty::IS_PROTECTED)
    {
        return $this->getFilterBy();
    }

    /**
     * @param string $key
     * @param int    $filter
     *
     * @return array
     */
    public function toParameterArray($key = 'filter_by', $filter = ReflectionProperty::IS_PROTECTED)
    {
        return [$key => $this->toArray($filter)];
    }
}
