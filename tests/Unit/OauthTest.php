<?php

namespace GeneralSystemsVehicle\Zoom\Tests\Unit;

use GeneralSystemsVehicle\Zoom\Api\Oauth;
use GeneralSystemsVehicle\Zoom\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class OauthTest extends TestCase
{
    /** @test */
    function it_gets_an_access_token_with_an_authorization_code()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__ . '/../Fixtures/Oauth/authorization.json')),
        ]);

        $oauth = new Oauth(['mock' => $mock]);

        $response = $oauth->authorizationCode();

        $this->assertTrue(is_null($response));

        $response = $oauth->authorizationCode([
            'authorization' => 'Basic base64_encode("clientId:clientSecret")',
        ]);

        $this->assertTrue(is_null($response));

        $response = $oauth->authorizationCode([
            'authorization' => 'Basic base64_encode("clientId:clientSecret")',
            'code' => 'obBEe8ewaL_KdyNjniT4KPd8ffDWt9fGB',
        ]);

        $this->assertTrue(is_null($response));

        $response = $oauth->authorizationCode([
            'authorization' => 'Basic base64_encode("clientId:clientSecret")',
            'code' => 'obBEe8ewaL_KdyNjniT4KPd8ffDWt9fGB',
            'redirect_uri' => 'https://yourapp.test/oauth/zoom/callback',
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('access_token', $response));
        $this->assertTrue(array_key_exists('token_type', $response));
        $this->assertTrue(array_key_exists('refresh_token', $response));
        $this->assertTrue(array_key_exists('expires_in', $response));
        $this->assertTrue(array_key_exists('scope', $response));
    }

    /** @test */
    function it_gets_an_access_token_with_a_refresh_token()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__ . '/../Fixtures/Oauth/refresh.json')),
        ]);

        $oauth = new Oauth(['mock' => $mock]);

        $response = $oauth->refreshToken();

        $this->assertTrue(is_null($response));

        $response = $oauth->refreshToken([
            'authorization' => 'Basic base64_encode("clientId:clientSecret")',
        ]);

        $this->assertTrue(is_null($response));

        $response = $oauth->refreshToken([
            'authorization' => 'Basic base64_encode("clientId:clientSecret")',
            'refresh_token' => 'eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiI...',
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('access_token', $response));
    }
}
