<?php

use Mockery as m;
use Rymanalu\LaravelCircuitBreaker\CircuitBreaker;
use Illuminate\Contracts\Cache\Repository as Cache;

class CircuitBreakerTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testTooManyFailuresReturnsTrueIfAlreadyBreakout()
    {
        $cache = m::mock(Cache::class);

        $cache->shouldReceive('has')->once()->with('key:breakout')->andReturn(true);

        $cache->shouldReceive('add', 'forget')->never();

        $circuitBreaker = new CircuitBreaker($cache);

        $this->assertTrue($circuitBreaker->tooManyFailures('key', 1, 1));
    }

    public function testTooManyFailuresReturnsTrueIfMaxFailuresExceeded()
    {
        $cache = m::mock(Cache::class);

        $cache->shouldReceive('has')->once()->with('key:breakout')->andReturn(false);

        $cache->shouldReceive('get')->once()->with('key', 0)->andReturn(10);

        $cache->shouldReceive('add')->once()->with('key:breakout', m::type('int'), 1);

        $cache->shouldReceive('forget')->once()->with('key');

        $circuitBreaker = new CircuitBreaker($cache);

        $this->assertTrue($circuitBreaker->tooManyFailures('key', 1, 1));
    }

    public function testTrackProperlyIncrementsFailureCount()
    {
        $cache = m::mock(Cache::class);

        $cache->shouldReceive('add')->once()->with('key', 1, 1);

        $cache->shouldReceive('increment')->once()->with('key');

        $circuitBreaker = new CircuitBreaker($cache);

        $circuitBreaker->track('key', 1);
    }

    public function testResetFailures()
    {
        $cache = m::mock(Cache::class);

        $cache->shouldReceive('forget')->once()->with('key');

        $circuitBreaker = new CircuitBreaker($cache);

        $circuitBreaker->resetFailures('key');
    }
}
