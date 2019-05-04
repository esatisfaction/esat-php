<?php

namespace Esat\Support\Helpers;

use InvalidArgumentException;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;

/**
 * Class UuidHelper
 * @package Esat\Support\Helpers
 */
class UuidHelper
{
    /**
     * @return string
     * @throws InvalidArgumentException
     * @throws UnsatisfiedDependencyException
     */
    public static function create()
    {
        /**
         * We are generating the smallest uuid possible
         * to reduce space and query lengths when a uuid
         * is included in urls and other cases.
         *
         * We are encoding a uuid from bytes to a string using
         * base64 algorithm.
         */
        $uuid = base64_encode(Uuid::uuid4()->getBytes());

        /**
         * Remove strange characters to avoid conflicts
         * when a uuid is being used to html in a form.
         */
        $uuid = str_replace('/', '-', $uuid);
        $uuid = str_replace('+', '-', $uuid);
        $uuid = str_replace('-', '', $uuid);
        $uuid = str_replace('=', '', $uuid);

        return $uuid;
    }
}
