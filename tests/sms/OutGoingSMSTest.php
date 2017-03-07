<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Exception;
use IP1\RESTClient\SMS\OutGoingSMS;
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\RecipientFactory;
use IP1\RESTClient\Exception\UndefinedOffsetException;

/**
 * Tests for the \IP1\RESTClient\SMS\OutGoingSMS class
 */
class OutGoingSMSTest extends TestCase
{

    public function testAddRecipient()
    {
        $contact = RecipientFactory::createProcessedContactFromJSON(file_get_contents('tests/resources/processed_contact/processed_contact.json'));

        $sms = new OutGoingSMS("Jack", "Why is the rum gone?");
        $sms->addNumber("12025550111");
        $sms->addContact($contact);
        $stdSMS = json_decode(json_encode($sms));
        $this->assertEquals([1735500], $stdSMS->Contacts);
    }
    public function testNumbers()
    {
        $sms = new OutGoingSMS("Jack", "Why is the rum gone?");
        $sms->addNumber("12025550111");
        $this->assertEquals(1, count($sms->getAllNumbers()));
        $sms->removeNumber(0);
        $this->assertEquals(0, count($sms->getAllNumbers()));
        $sms->addAllNumbers(['12025550111','12025550112','12025550113']);
        $this->assertEquals(['12025550111','12025550112','12025550113'], $sms->getAllNumbers());
        $sms->addNumber('12025550114');
        $sms->addAllNumbers(['12025550115','12025550116','12025550117']);
        $this->assertEquals(['12025550111','12025550112','12025550113', '12025550114', '12025550115','12025550116','12025550117'], $sms->getAllNumbers());
        $sms->removeNumber(1);
        $this->assertEquals(['12025550111','12025550113', '12025550114', '12025550115','12025550116','12025550117'], $sms->getAllNumbers());
    }
}
