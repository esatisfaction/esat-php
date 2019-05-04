<?php

namespace Esat;

use PHPUnit\Framework\TestCase;

/**
 * Class Base_TestCase
 * @package Esat
 */
class Base_TestCase extends TestCase
{
    /**
     * @var Esat
     */
    protected $esat;

    /**
     * @var string
     */
    protected $environment = 'tests';

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function setUp()
    {
        parent::setUp();

        // Set error reporting
        error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED));

        // Initialize dummy Esat
        $this->esat = new Esat($this->getEnvironment() ?: 'tests');
    }

    /**
     * @return Esat
     */
    public function getEsat()
    {
        return $this->esat;
    }

    /**
     * @param Esat $esat
     */
    public function setEsat(Esat $esat)
    {
        $this->esat = $esat;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     *
     * @return $this
     */
    public function setEnvironment(string $environment)
    {
        $this->environment = $environment;

        return $this;
    }
}
