<?php

namespace Esat\Support\Model\Propel;

use Esat\Support\Model\BaseModel;
use ReflectionException;
use ReflectionProperty;

/**
 * Class Pagination
 * @package Esat\Support\Model\Propel
 */
class Pagination extends BaseModel
{
    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $max_per_page = 10;

    /**
     * @var bool
     */
    protected $include_results = true;

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxPerPage()
    {
        return $this->max_per_page;
    }

    /**
     * @param int $max_per_page
     *
     * @return $this
     */
    public function setMaxPerPage(int $max_per_page)
    {
        $this->max_per_page = $max_per_page;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIncludeResults()
    {
        return $this->include_results;
    }

    /**
     * @param bool $include_results
     *
     * @return $this
     */
    public function setIncludeResults(bool $include_results)
    {
        $this->include_results = $include_results;

        return $this;
    }

    /**
     * @param int $filter
     *
     * @return array
     * @throws ReflectionException
     */
    public function toParameterArray($filter = ReflectionProperty::IS_PROTECTED)
    {
        return ['pagination' => $this->toArray($filter)];
    }
}
