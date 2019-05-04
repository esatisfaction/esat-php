<?php

namespace Esat\Support\Services;

use Esat\Esat;
use Psr\Log\LoggerInterface;

/**
 * Class BaseService
 * @package Esat\Support\Services
 */
abstract class BaseService
{
    /**
     * @var Esat
     */
    protected $esat;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * BaseService constructor.
     *
     * @param Esat            $esat
     * @param LoggerInterface $logger
     */
    public function __construct(Esat $esat, LoggerInterface $logger)
    {
        $this->esat = $esat;
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
