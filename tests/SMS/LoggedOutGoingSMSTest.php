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
        $sms = json_decode($this->getCommunicator()->get('api/sms/sent'));
        $this->assertEquals([], $sms);
    }
}
