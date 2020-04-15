<?php

namespace GeneralSystemsVehicle\Zoom\Tests\Unit;

use GeneralSystemsVehicle\Zoom\Api\Users;
use GeneralSystemsVehicle\Zoom\Tests\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class UsersTest extends TestCase
{
    /** @test */
    function it_gets_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/get.json')),
        ]);

        $users = new Users(['mock' => $mock]);

        $response = $users->get();

        $this->assertTrue(is_null($response));

        $response = $users->get('me', [
            'authorization' => 'Bearer apitoken',
            'query' => [
                'login_type' => '100',
            ],
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('id', $response));
        $this->assertTrue(array_key_exists('first_name', $response));
        $this->assertTrue(array_key_exists('last_name', $response));
        $this->assertTrue(array_key_exists('email', $response));
    }
}
