<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.2.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
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
