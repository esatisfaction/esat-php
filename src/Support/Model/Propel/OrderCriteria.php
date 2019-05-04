<?php

namespace Esat\Support\Model\Propel;

use Esat\Support\Model\BaseModel;
use ReflectionProperty;

/**
 * Class OrderCriteria
 * @package Esat\Support\Model\Propel
 */
class OrderCriteria extends BaseModel
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @var array
     */
    protected $order_by;

    /**
     * @param string $columnName
     *
     * @return $this
     */
    public function asc($columnName)
    {
        return $this->add($columnName, self::ASC);
    }

    /**
     * @param string $columnName
     *
     * @return $this
     */
    public function desc($columnName)
    {
        return $this->add($columnName, self::DESC);
    }

    /**
     * @param string $columnName The name of the column in phpname type (e.g. 'ColumnName')
     * @param string $order
     *
     * @return $this
     */
    public function add($columnName, $order = self::ASC)
    {
        $this->order_by[$order][] = $columnName;

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return $this->order_by;
    }

    /**
     * @param array $order_by
     *
     * @return $this
     */
    public function setOrderBy(array $order_by)
    {
        $this->order_by = $order_by;

        return $this;
    }

    /**
     * @param int $filter
     *
     * @return array
     */
    public function toArray($filter = ReflectionProperty::IS_PROTECTED)
    {
        return $this->getOrderBy();
    }

    /**
     * @param int $filter
     *
     * @return array
     */
    public function toParameterArray($filter = ReflectionProperty::IS_PROTECTED)
    {
        return ['order_by' => $this->toArray($filter)];
    }
}
