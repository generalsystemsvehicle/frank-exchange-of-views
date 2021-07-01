<?php

namespace GeneralSystemsVehicle\Zoom;

trait ServiceBindings
{
    /**
     * All of the service bindings for package.
     *
     * @var array
     */
    protected $serviceBindings = [
        Api\Meetings::class,
        Api\Oauth::class,
        Api\Users::class,
    ];
}
