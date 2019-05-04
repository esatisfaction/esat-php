<?php

/*
 * This file is part of the e-satisfaction SDK Package.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esat;

use Esat\Support\Registry\EsatRegistry;
use InvalidArgumentException;

/**
 * Class Esat
 * @package Esat
 */
class Esat
{
    /**
     * @var EsatRegistry
     */
    protected $registry;

    /**
     * Esat constructor.
     *
     * @param string $environment
     *
     * @throws InvalidArgumentException
     */
    public function __construct($environment = 'default')
    {
        $this->registry = new EsatRegistry();
        $this->setEnvironment($environment ?: 'default');
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->registry->get('env', 'default');
    }

    /**
     * @param string $environment
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function setEnvironment($environment)
    {
        return $this->registry->set('env', $environment);
    }
}
