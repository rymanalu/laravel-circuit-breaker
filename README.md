# Laravel 5 Circuit Breaker

[![Build Status](https://travis-ci.org/rymanalu/laravel-circuit-breaker.svg?branch=master)](https://travis-ci.org/rymanalu/laravel-circuit-breaker)

This package provides an implementation of Circuit Breaker pattern for Laravel 5.


## Installation
First, install this package:
```
composer require rymanalu/laravel-circuit-breaker
```

Next, add the ServiceProvider to the providers array in `config/app.php`:
```php
Rymanalu\LaravelCircuitBreaker\CircuitBreakerServiceProvider::class,
```

You can use the facade for shorter code. Add this to your aliases:
```php
'CircuitBreaker' => Rymanalu\LaravelCircuitBreaker\CircuitBreakerFacade::class,
```

## APIs
```php
<?php

use CircuitBreaker;

/**
 * Get the number of failures for the given key.
 *
 * @param  string  $key
 * @return int
 */
CircuitBreaker::failures($key);

/**
 * Reset the number of failures for the given key.
 *
 * @param  string  $key
 * @return bool
 */
CircuitBreaker::resetFailures($key);

/**
  * Increment the counter for a given key for a given decay time.
  *
  * @param  string  $key
  * @param  float|int  $decayMinutes
  * @return int
  */
CircuitBreaker::track($key, $decayMinutes = 1);

/**
 * Determine if the given key has too many failures.
 *
 * @param  string  $key
 * @param  int  $maxFailures
 * @param  int  $decayMinutes
 * @return bool
 */
CircuitBreaker::tooManyFailures($key, $maxFailures, $decayMinutes = 1);
```
