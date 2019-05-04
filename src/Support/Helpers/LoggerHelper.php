<?php

/*
 * This file is part of the e-satisfaction SDK Package.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esat\Support\Helpers;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Class LoggerHelper
 * @package Esat\Support\Helpers
 */
class LoggerHelper
{
    /**
     * @param LoggerInterface $logger
     * @param Throwable       $exception
     * @param int             $level
     * @param bool            $logTrace
     */
    public static function logThrowable(LoggerInterface $logger, Throwable $exception, $level = Logger::ERROR, $logTrace = true)
    {
        $stringArray = self::throwableToStringArray($exception, $logTrace);
        foreach ($stringArray as $item) {
            $logger->log($level, $item);
        }
    }

    /**
     * @param Throwable $exception
     * @param bool      $includeTrace
     *
     * @return string
     */
    public static function throwableToString(Throwable $exception, $includeTrace = true)
    {
        $stringArray = self::throwableToStringArray($exception, $includeTrace);

        return implode("\n", $stringArray);
    }

    /**
     * @param Throwable $exception
     * @param bool      $includeTrace
     *
     * @return array
     */
    public static function throwableToStringArray(Throwable $exception, $includeTrace = true)
    {
        // Log first message
        $array[] = '! ' . $exception->getMessage();

        // Log all previous exceptions
        $previous = $exception->getPrevious();
        while ($previous) {
            // Log message
            $array[] = ' >' . $previous->getMessage();

            // Get previous
            $previous = $previous->getPrevious();
        }

        // Log trace, if requested
        if ($includeTrace) {
            $trace = $exception->getTrace();
            foreach ($trace as $index => $item) {
                // Create trace item log record
                $record = [
                    '  #' . $index,
                    $item['file'] . '::' . $item['line'],
                    $item['class'] . $item['type'] . $item['function'],
                ];

                // Log trace
                $array[] = implode(' ', $record);
            }
        }

        return $array;
    }
}
