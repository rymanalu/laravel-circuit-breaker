<?php

namespace Rymanalu\LaravelCircuitBreaker;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rymanalu\LaravelCircuitBreaker\CircuitBreaker
 */
class CircuitBreakerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CircuitBreaker::class;
    }
}
