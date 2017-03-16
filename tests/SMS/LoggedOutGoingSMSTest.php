<?php

namespace IP1\RESTClient\Test\SMS;

use IP1\RESTClient\Test\Core\AbstractEnviromentProvider;
use IP1\RESTClient\Recipient\RecipientFactory;

class LoggedOutGoingSMSTest extends AbstractEnviromentProvider
{
    public function testIsSMSListEmpty()
    {
        $sms = json_decode($this->communicator->get('api/sms/sent'));
        $this->assertEquals([], $sms);
    }
}
