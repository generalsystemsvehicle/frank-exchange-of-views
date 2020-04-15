<?php

namespace GeneralSystemsVehicle\Zoom\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use GuzzleHttp\Exception\RequestException;
use GeneralSystemsVehicle\Zoom\Guzzle\Api;

class Users extends Api
{
    /**
     * Get a user.
     * @param  string $userId
     * @param  array  $payload
     * @return array|null
     */
    public function get($userId = 'me', $payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        return $this->try(function() use ($userId, $payload)
        {
            return $this->client->get('v2/users/'.$userId, [
                'query' => Arr::get($payload, 'query', []),
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }
}
