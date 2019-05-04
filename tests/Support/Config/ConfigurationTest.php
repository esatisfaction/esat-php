<?php

namespace Esat\Support\Config;

use Esat\Base_TestCase;
use InvalidArgumentException;
use PHPUnit\Framework\AssertionFailedError;

/**
 * Class ConfigurationTest
 * @package Esat\Support\Config
 */
class ConfigurationTest extends Base_TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function setUp()
    {
        parent::setUp();

        $this->getEsat()->setEnvironment('default');
        $this->configuration = new Configuration($this->getEsat());
    }

    /**
     * @covers \Esat\Support\Config\Configuration::get
     *
     * @throws AssertionFailedError
     */
    public function testGet()
    {
        $this->assertNotEmpty($this->configuration->get());

        $this->assertEquals('3.1', $this->configuration->get('api.version'));
        $this->assertEquals('https://api.e-satisfaction.com', $this->configuration->get('api.base_uri'));
    }
}
