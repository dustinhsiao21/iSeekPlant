<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * mock.
     *
     * @param string $class
     * @param array $partial
     * @return \Mockery\Mock
     */
    protected function initMock($class, array $partial = null)
    {
        $mock = ($partial) ? \Mockery::mock($class, $partial) : \Mockery::mock($class);
        $this->app->instance($class, $mock);

        return $mock;
    }
}
