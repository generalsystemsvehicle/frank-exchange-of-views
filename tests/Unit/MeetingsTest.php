<?php

namespace GeneralSystemsVehicle\Zoom\Tests\Unit;

use GeneralSystemsVehicle\Zoom\Api\Meetings;
use GeneralSystemsVehicle\Zoom\Tests\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class MeetingsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Meetings/index.json')),
        ]);

        $meetings = new Meetings(['mock' => $mock]);

        $response = $meetings->index('me');

        $this->assertTrue(is_null($response));

        $response = $meetings->index('me', [
            'authorization' => 'Bearer apitoken',
            'query' => [
                'type' => 'scheduled',
                'page_size' => 30,
                'page_number' => 1,
            ],
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('meetings', $response));
    }

    /** @test */
    function it_gets_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Meetings/get.json')),
        ]);

        $meetings = new Meetings(['mock' => $mock]);

        $response = $meetings->get('1234555466');

        $this->assertTrue(is_null($response));

        $response = $meetings->get('1234555466', [
            'authorization' => 'Bearer apitoken',
            'query' => [
                'occurrence_id' => '1234555466',
            ],
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('id', $response));
        $this->assertTrue(array_key_exists('join_url', $response));
        $this->assertTrue(array_key_exists('start_url', $response));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Meetings/create.json')),
        ]);

        $meetings = new Meetings(['mock' => $mock]);

        $response = $meetings->create('me');

        $this->assertTrue(is_null($response));

        $response = $meetings->create('me', [
            'authorization' => 'Bearer apitoken',
        ]);

        $this->assertTrue(is_null($response));

        $response = $meetings->create('me', [
            'authorization' => 'Bearer apitoken',
            'body' => json_encode([
                'topic' => 'Topic',
                'agenda' => 'Agenda',
                'type' => 8,
                'password' => '787900',
                'start_time' => '2020-04-01T09:00:00',
                'duration' => 480,
                'timezone' => 'America/Chicago',
                'recurrence' => [
                    'type' => 1,
                    'end_date_time' => '2020-04-01T17:00:00'
                ],
                'settings' => [
                    'host_video' => true,
                    'participant_video' => false,
                    'join_before_host' => false,
                    'mute_upon_entry' => true,
                    'audio' => 'voip',
                    'auto_recording' => 'none',
                    'waiting_room' => false
                ]
            ]),
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('id', $response));
        $this->assertTrue(array_key_exists('join_url', $response));
        $this->assertTrue(array_key_exists('start_url', $response));
    }

    /** @test */
    function it_updates_a_record()
    {
        $mock = new MockHandler([
            new Response(204, ['Content-Type' => 'application/json']),
        ]);

        $meetings = new Meetings(['mock' => $mock]);

        $response = $meetings->update('1234555466');

        $this->assertTrue(is_null($response));

        $response = $meetings->update('1234555466', [
            'authorization' => 'Bearer apitoken',
        ]);

        $this->assertTrue(is_null($response));

        $response = $meetings->update('1234555466', [
            'authorization' => 'Bearer apitoken',
            'body' => json_encode([
                'topic' => 'Topic',
                'agenda' => 'Agenda',
                'type' => 8,
                'password' => '787900',
                'start_time' => '2020-04-01T09:00:00',
                'duration' => 480,
                'timezone' => 'America/Chicago',
                'recurrence' => [
                    'type' => 1,
                    'end_date_time' => '2020-04-01T17:00:00'
                ],
                'settings' => [
                    'host_video' => true,
                    'participant_video' => false,
                    'join_before_host' => false,
                    'mute_upon_entry' => true,
                    'audio' => 'voip',
                    'auto_recording' => 'none',
                    'waiting_room' => false
                ]
            ]),
            'query' => [
                'occurrence_id' => '1234555466',
            ],
        ]);

        $this->assertTrue(is_null($response));
    }

    /** @test */
    function it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(204, ['Content-Type' => 'application/json']),
        ]);

        $meetings = new Meetings(['mock' => $mock]);

        $response = $meetings->delete('1234555466');

        $this->assertTrue(is_null($response));

        $response = $meetings->delete('1234555466', [
            'authorization' => 'Bearer apitoken',
            'query' => [
                'occurrence_id' => '1234555466',
                'schedule_for_reminder' => true,
            ],
        ]);

        $this->assertTrue(is_null($response));
    }
}
