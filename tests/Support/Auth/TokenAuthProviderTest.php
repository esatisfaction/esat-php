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

use Esat\Base_TestCase;
use GuzzleHttp\Psr7\Request;

/**
 * Class TokenAuthProviderTest
 * @package Esat\Support\Auth
 */
class TokenAuthProviderTest extends Base_TestCase
{
    /**
     * @covers \Esat\Http\Auth\TokenAuthProvider::setRequestAuth
     *
     * @throws \InvalidArgumentException
     */
    public function testSetRequestAuth()
    {
        // Create provider
        $token = 'mock_token';
        $provider = new TokenAuthProvider($token);

        // Create mock request
        $request = new Request('GET', '/path/to/resource', ['test_header' => 'test_value']);
        $this->assertEquals('test_value', $request->getHeader('test_header')[0]);

        // Set auth to request
        $request2 = $provider->setRequestAuth($request);

        // Assert request headers
        $this->assertEquals($request->getHeaders(), $request2->getHeaders());
        $this->assertEquals($token, $request->getHeader('esat-auth')[0]);
    }
}
