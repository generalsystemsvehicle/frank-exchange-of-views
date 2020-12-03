<?php

namespace GeneralSystemsVehicle\Zoom\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Zoom\Guzzle\Api;

class Users extends Api
{
    /**
     * Get a user.
     * https://marketplace.zoom.us/docs/api-reference/zoom-api/users/user
     *
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
