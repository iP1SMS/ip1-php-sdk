<?php

namespace IP1\RESTClient\Test\Core;

use PHPUnit\Framework\TestCase;
use IP1\RESTClient\Core\Communicator;

abstract class AbstractEnviromentProvider extends TestCase
{
    private $communicator;
    private $communicatorEnabled = false;
    public function setUp()
    {
        if (getenv("USER") || getenv("PASS")) {
            // Uses Enviroment Variables provided by Travis CI for security reasons.
            $this->communicator = new Communicator(getenv("USER"), getenv("PASS"));
            $this->communicatorEnabled = true;
        }
    }
    public function isCommunicatorEnabled(): bool
    {
        return $this->communicatorEnabled;
    }
    public function getCommunicator(): ?Communicator
    {
        if (!$this->isCommunicatorEnabled()) {
              $this->markTestSkipped("Communicator is not enabled skipping test");
              return null;
        }
        return $this->communicator;
    }
}
