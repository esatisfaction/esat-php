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

use Panda\Support\Helpers\StringHelper;

/**
 * Class UriHelper
 * @package Esat\Support\Helpers
 */
class UriHelper
{
    /**
     * @param string $uri
     * @param array  $arguments
     *
     * @return string
     */
    public static function get($uri, $arguments = [])
    {
        return rtrim(StringHelper::interpolate($uri, $arguments, '{', '}'), '/');
    }
}
