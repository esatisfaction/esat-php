<?php

namespace Esat\Support\Model\Propel;

use Esat\Support\Model\BaseModel;

/**
 * Class Pager
 * @package Esat\Support\Model\Propel
 */
class Pager extends BaseModel
{
    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $max_per_page;

    /**
     * @var int
     */
    protected $last_page;

    /**
     * @var int
     */
    protected $total_results;

    /**
     * @var array
     */
    protected $results;

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
     * @return int
     */
    public function getLastPage()
    {
        return $this->last_page;
    }

    /**
     * @param int $last_page
     *
     * @return $this
     */
    public function setLastPage(int $last_page)
    {
        $this->last_page = $last_page;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalResults()
    {
        return $this->total_results;
    }

    /**
     * @param int $total_results
     *
     * @return $this
     */
    public function setTotalResults(int $total_results)
    {
        $this->total_results = $total_results;

        return $this;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param array $results
     *
     * @return $this
     */
    public function setResults(array $results)
    {
        $this->results = $results;

        return $this;
    }
}
