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
     * @var string
     */
    private $domain;

    /**
     * TokenAuthProvider constructor.
     *
     * @param string $token
     * @param string $domain
     */
    public function __construct($token, $domain)
    {
        $this->token = $token;
        $this->domain = $domain;
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
        $request = $request->withHeader('esat-domain', $this->getDomain());
        $request = $request->withHeader('esat-auth', $this->getToken());

        return $request;
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

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     *
     * @return $this
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;

        return $this;
    }
}
