<?php

namespace IP1\RESTClient\Test\Core;

use PHPUnit\Framework\TestCase;
use IP1\RESTClient\Core\Communicator;

abstract class AbstractEnviromentProvider extends TestCase
{
    protected $communicator;
    public function __construct()
    {
        // Uses Enviroment Variables provided by Travis CI for security reasons.
        $this->communicator = new Communicator(getenv("USER"), getenv("PASS"));
    }
}
