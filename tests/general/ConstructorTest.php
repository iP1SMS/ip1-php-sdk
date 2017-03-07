<?php
use IP1\RESTClient\Recipient\Group;
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\ProcessedContact;
use IP1\RESTClient\Recipient\Membership;
use IP1\RESTClient\Recipient\ProcessedMembership;
use IP1\RESTClient\Recipient\ProcessedGroup;
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
        new Group("Crew men", "#ffffff");
        new ProcessedGroup("Crew men", "#ffffff", 12, new \DateTime(), new \DateTime());
        new Membership(12, 22);
        new ProcessedMembership(12, 22, 43, new \DateTime());
        $this->addToAssertionCount(1);
    }
}
