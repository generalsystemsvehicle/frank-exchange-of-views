<?php

namespace GeneralSystemsVehicle\Zoom\Tests\Unit;

use GeneralSystemsVehicle\Zoom\Tests\Stubs\StubbedContract;
use GeneralSystemsVehicle\Zoom\Tests\Stubs\StubbedEvent;
use GeneralSystemsVehicle\Zoom\Tests\Stubs\StubbedImplementation;
use GeneralSystemsVehicle\Zoom\Tests\Stubs\StubbedListener;
use GeneralSystemsVehicle\Zoom\Tests\TestCase;
use GeneralSystemsVehicle\Zoom\ZoomServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ServiceProviderTest extends TestCase
{
    /** @test */
    function it_sets_up_a_listener()
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $dispatcher->forget(StubbedEvent::class);

        $this->assertFalse($dispatcher->hasListeners(StubbedEvent::class));

        $provider = new ZoomServiceProvider($this->app);

        $this->setProperty($provider, 'events', [
            StubbedEvent::class => [
                StubbedListener::class,
            ],
        ]);

        $this->invokeMethod($provider, 'bootEvents', [ ]);

        $this->assertTrue($dispatcher->hasListeners(StubbedEvent::class));
    }

    /** @test */
    function it_cannot_bind_a_contract_without_an_implementation()
    {
        $this->expectException(BindingResolutionException::class);

        $this->app->make(StubbedContract::class);
    }

    /** @test */
    function it_binds_a_contract_to_an_implementation()
    {
        $provider = new ZoomServiceProvider($this->app);

        $this->setProperty($provider, 'serviceBindings', [
            StubbedContract::class => StubbedImplementation::class,
        ]);

        $this->invokeMethod($provider, 'registerServices');

        $contract = $this->app->make(StubbedContract::class);

        $this->assertTrue($contract instanceof StubbedImplementation);
    }
}
