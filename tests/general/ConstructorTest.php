<?php
use IP1\RESTClient\Recipient\Group;
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\ProcessedContact;
use PHPUnit\Framework\TestCase;

class ConstructorTest extends TestCase
{
    /**
    * @covers Contact::__construct
    * @covers ProcessedContact::__construct
    */
    public function testRecipientConstructors()
    {
        new Contact("Jack", "12025550161");
        new ProcessedContact("Jack", "12025550161", 13, "Sparrow", "Captain", "Black Pearl Co.", "", "");
        $this->addToAssertionCount(1);
    }
}
