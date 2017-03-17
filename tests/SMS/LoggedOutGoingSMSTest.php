<?php

namespace IP1\RESTClient\Test\SMS;

use IP1\RESTClient\Test\Core\AbstractEnviromentProvider;
use IP1\RESTClient\Recipient\RecipientFactory;

class LoggedOutGoingSMSTest extends AbstractEnviromentProvider
{
    /**
    * @group api
    */
    public function testIsSMSListEmpty()
    {
        if (!$this->isCommunicatorEnabled()) {
              $this->markTestSkipped("Communicator is not enabled skipping test");
        }
        $sms = json_decode($this->communicator->get('api/sms/sent'));
        $this->assertEquals([], $sms);
    }
}
