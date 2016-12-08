<?php

namespace Rymanalu\LaravelCircuitBreaker;

use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository as Cache;

class CircuitBreaker implements CircuitBreakerInterface
{
    /**
     * The cache store implementation.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Create a new circuit breaker instance.
     *
     * @param  \Illuminate\Contracts\Cache\Repository  $cache
     * @return void
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get the number of failures for the given key.
     *
     * @param  string  $key
     * @return int
     */
    public function failures($key)
    {
        return $this->cache->get($key, 0);
    }

    /**
     * Reset the number of failures for the given key.
     *
     * @param  string  $key
     * @return bool
     */
    public function resetFailures($key)
    {
        return $this->cache->forget($key);
    }

    /**
     * Increment the counter for a given key for a given decay time.
     *
     * @param  string  $key
     * @param  float|int  $decayMinutes
     * @return int
     */
    public function track($key, $decayMinutes = 1)
    {
        $this->cache->add($key, 1, $decayMinutes);

        return (int) $this->cache->increment($key);
    }

    /**
     * Determine if the given key has too many failures.
     *
     * @param  string  $key
     * @param  int  $maxFailures
     * @param  int  $decayMinutes
     * @return bool
     */
    public function tooManyFailures($key, $maxFailures, $decayMinutes = 1)
    {
        if ($this->cache->has($key.':breakout')) {
            return true;
        }

        if ($this->failures($key) > $maxFailures) {
            $this->cache->add($key.':breakout', Carbon::now()->getTimestamp() + ($decayMinutes * 60), $decayMinutes);

            $this->resetFailures($key);

            return true;
        }

        return false;
    }
}
