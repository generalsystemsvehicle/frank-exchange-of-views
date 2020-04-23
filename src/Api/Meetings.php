<?php

namespace GeneralSystemsVehicle\Zoom\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use GuzzleHttp\Exception\RequestException;
use GeneralSystemsVehicle\Zoom\Guzzle\Api;

class Meetings extends Api
{
    /**
     * Get the meetings index.
     * https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetings
     *
     * @param  string $userId
     * @param  array  $payload
     * @return array|null
     */
    public function index($userId = 'me', $payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        return $this->try(function() use ($userId, $payload)
        {
            return $this->client->get('v2/users/'.$userId.'/meetings', [
                'query' => Arr::get($payload, 'query', []),
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }

    /**
     * Get a meeting.
     * https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meeting
     *
     * @param  string $meetingId
     * @param  array  $payload
     * @return array|null
     */
    public function get($meetingId, $payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        return $this->try(function() use ($meetingId, $payload)
        {
            return $this->client->get('v2/meetings/'.$meetingId, [
                'query' => Arr::get($payload, 'query', []),
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }

    /**
     * Create a meeting.
     * https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingcreate
     *
     * @param  string $userId
     * @param  array  $payload
     * @return array|null
     */
    public function create($userId = 'me', $payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        if (! Arr::has($payload, 'body')) {
            return null;
        }

        return $this->try(function() use ($userId, $payload)
        {
            return $this->client->post('v2/users/'.$userId.'/meetings', [
                'body' => Arr::get($payload, 'body'),
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }

    /**
     * Update a meeting
     * https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingupdate
     *
     * @param  string $meetingId
     * @param  array  $payload
     * @return array|null
     */
    public function update($meetingId, $payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        if (! Arr::has($payload, 'body')) {
            return null;
        }

        return $this->try(function() use ($meetingId, $payload)
        {
            return $this->client->patch('v2/meetings/'.$meetingId, [
                'body' => Arr::get($payload, 'body'),
                'query' => Arr::get($payload, 'query', []),
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }

    /**
     * Delete a meeting.
     * https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingdelete
     *
     * @param  string $meetingId
     * @param  array  $payload
     * @return array|null
     */
    public function delete($meetingId, $payload = [])
    {
        if (! Arr::has($payload, 'authorization')) {
            return null;
        }

        return $this->try(function() use ($meetingId, $payload)
        {
            return $this->client->delete('v2/meetings/'.$meetingId, [
                'query' => Arr::get($payload, 'query', []),
                'headers' => [
                    'Authorization' => Arr::get($payload, 'authorization'),
                ],
            ]);
        });
    }
}
