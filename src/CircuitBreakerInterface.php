<?php

namespace Rymanalu\LaravelCircuitBreaker;

interface CircuitBreakerInterface
{
    /**
     * Get the number of failures for the given key.
     *
     * @param  string  $key
     * @return int
     */
    public function failures($key);

    /**
     * Reset the number of failures for the given key.
     *
     * @param  string  $key
     * @return bool
     */
    public function resetFailures($key);

    /**
     * Increment the counter for a given key for a given decay time.
     *
     * @param  string  $key
     * @param  float|int  $decayMinutes
     * @return int
     */
    public function track($key, $decayMinutes = 1);

    /**
     * Determine if the given key has too many failures.
     *
     * @param  string  $key
     * @param  int  $maxFailures
     * @param  int  $decayMinutes
     * @return bool
     */
    public function tooManyFailures($key, $maxFailures, $decayMinutes = 1);
}
