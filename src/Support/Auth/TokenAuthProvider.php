<?php

/*
 * This file is part of the e-satisfaction SDK Package.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esat\Support\Auth;

use Esat\Http\Auth\AuthProviderInterface;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

/**
 * Class TokenAuthProvider
 * @package Esat\Support\Auth
 */
class TokenAuthProvider implements AuthProviderInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * TokenAuthProvider constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param RequestInterface $request
     *
     * @return RequestInterface
     * @throws InvalidArgumentException
     */
    public function setRequestAuth(RequestInterface &$request)
    {
        // Set request headers
        return $request = $request->withHeader('esat-auth', $this->getToken());
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }
}
