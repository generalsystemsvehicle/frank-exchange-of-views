<?php

namespace GeneralSystemsVehicle\Zoom\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use GuzzleHttp\Exception\RequestException;
use GeneralSystemsVehicle\Zoom\Guzzle\Api;

class OAuth extends Api
{
    /**
     * Get an access token and refresh token with an authorization code.
     * https://marketplace.zoom.us/docs/guides/auth/oauth
     *
     * @param  array  $payload
     * @return array|null
     */
    public function authorizationCode($payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        if (! Arr::has($payload, 'code')) {
            return null;
        }

        if (! Arr::has($payload, 'redirect_uri')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('oauth/token', [
                'query' => [
                    'grant_type' => 'authorization_code',
                    'code' => Arr::get($payload, 'code'),
                    'redirect_uri' => Arr::get($payload, 'redirect_uri'),
                ],
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }

    /**
     * Get an access token and refresh token with a refresh token.
     * https://marketplace.zoom.us/docs/guides/auth/oauth#refreshing
     *
     * @param  array  $payload
     * @return array|null
     */
    public function refreshToken($payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        if (! Arr::has($payload, 'refresh_token')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('oauth/token', [
                'query' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => Arr::get($payload, 'refresh_token'),
                ],
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }
}
