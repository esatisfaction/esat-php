<?php

/*
 * This file is part of the e-satisfaction SDK Package.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esat\Support\Registry;

use InvalidArgumentException;
use Panda\Registry\SharedRegistry;
use Panda\Support\Helpers\ArrayHelper;

/**
 * Class EsatRegistry
 * @package Esat\Support\Registry
 */
class EsatRegistry extends SharedRegistry
{
    const CONTAINER = 'esat.sdk';

    /**
     * Set the entire items array.
     *
     * @param array $items
     *
     * @throws InvalidArgumentException
     */
    public function setItems(array $items)
    {
        // Set items in registry
        $items = ArrayHelper::set(parent::getItems(), self::CONTAINER, $items, false);

        // Set registry back
        parent::setItems($items);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return ArrayHelper::get(parent::getItems(), self::CONTAINER, [], false);
    }
}
