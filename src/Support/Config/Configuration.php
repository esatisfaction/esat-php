<?php

/*
 * This file is part of the e-satisfaction SDK Package.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esat\Support\Config;

use Esat\Esat;
use InvalidArgumentException;
use Panda\Config\Parsers\JsonParser;
use Panda\Config\SharedConfiguration;
use Panda\Support\Helpers\ArrayHelper;

/**
 * Class Configuration
 * @package Esat\Support\Config
 */
class Configuration
{
    /**
     * @var Esat
     */
    protected $esat;

    /**
     * @var JsonParser
     */
    protected $parser;

    /**
     * @var SharedConfiguration
     */
    protected $config;

    /**
     * Configuration constructor.
     *
     * @param Esat $esat
     *
     * @throws InvalidArgumentException
     */
    public function __construct(Esat $esat)
    {
        $this->esat = $esat;
        $this->config = new SharedConfiguration();
        $this->parser = new JsonParser();

        $this->setConfig();
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        $configKey = 'esat.sdk.config' . ($key ? '.' . $key : '');

        return $this->config->get($configKey, $default);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        return $this->config->set('esat.sdk.config.' . $key, $value);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function setConfig()
    {
        $configuration = $this->loadConfig();
        $this->config->set('esat.sdk.config', $configuration);
    }

    /**
     * @param string $configFile
     *
     * @return array
     */
    protected function loadConfig($configFile = '')
    {
        // Load default configuration
        $defaultConfigFile = $this->getConfigFile($configFile, 'default');
        $defaultConfigArray = $this->parser->parse($defaultConfigFile) ?: [];

        // Load environment configuration
        $envConfigFile = $this->getConfigFile($configFile, $this->esat->getEnvironment());
        $envConfigArray = $this->parser->parse($envConfigFile) ?: [];

        // Merge environment config to default and set to application
        return ArrayHelper::merge($defaultConfigArray, $envConfigArray, $deep = true);
    }

    /**
     * Get the configuration file according to the given environment, if any.
     *
     * @param string $configFile
     * @param string $environment
     *
     * @return string
     */
    private function getConfigFile($configFile, $environment = 'default')
    {
        // Get base config folder
        $configFolder = __DIR__ . '/../../../config';

        // Normalize config file
        $configFile = $configFile ?: 'config';

        // Check if there is an environment-specific config file
        $envConfigFile = $configFolder . DIRECTORY_SEPARATOR . $configFile . '-' . $environment . '.json';
        if (!is_file($envConfigFile)) {
            $envConfigFile = $configFolder . DIRECTORY_SEPARATOR . $configFile . '.json';
        }

        return $envConfigFile;
    }
}
