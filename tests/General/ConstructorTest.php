<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.1.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/

namespace IP1\RESTClient\Test\General;

use IP1\RESTClient\Recipient\Group;
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\ProcessedContact;
use IP1\RESTClient\Recipient\Membership;
use IP1\RESTClient\Recipient\ProcessedMembership;
use IP1\RESTClient\Recipient\ProcessedGroup;
use IP1\RESTClient\SMS\ProcessedOutGoingSMS;
use PHPUnit\Framework\TestCase;
use \DateTime;

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
        new ProcessedGroup("Crew men", "#ffffff", 12, new DateTime(), new DateTime());
        new Membership(12, 22);
        new ProcessedMembership(12, 22, 43, new DateTime());
        new ProcessedMembership(1, 2, 3, new  DateTime());
        $this->addToAssertionCount(1);
    }
    public function testSMSConstructors()
    {
        new ProcessedOutGoingSMS("Jack", "Why is the rum gone?", "12025550109", 1, new DateTime(), new DateTime(), 22);
        $this->addToAssertionCount(1);
    }
}
