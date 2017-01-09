<?php

namespace WoWStats\Tests;

use \Illuminate\Foundation\Testing\TestCase as IllumunateTestCase;
use \Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends IllumunateTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
