<?php
/**
* Contains the RecipientFactory class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @package \IP1\RESTClient\Recipient
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\ClassValidationArray;
use IP1\RESTClient\SMS\ProcessedOutGoingSMS;

/**
* Handles construction of Recipients.
*/
class RecipientFactory
{
    /**
    * Creates a Contact using the stdClass given.
    * @param string $jsonContact A JSON string matching the format of the IP1 SMS API.
    * @return Contact
    */
    public static function createContactFromJSON(string $jsonContact): Contact
    {
          return self::createContactFromStdClass(json_decode($jsonContact));
    }
    /**
    * Creates a Contact using the stdClass given.
    * @param \stdClass $stdContact An stdClass object matching the format of the IP1 SMS API.
    * @return Contact
    * @throws \InvalidArgumentException Thrown when required parameters in the argument is missing.
    */
    public static function createContactFromStdClass(\stdClass $stdContact): Contact
    {
        if (empty($stdContact->FirstName)) {
            throw new \InvalidArgumentException("stdClass argument must contain FirstName attribute");
        }
        if (empty($stdContact->Phone)) {
            throw new \InvalidArgumentException("stdClass argument must contain Phone attribute");
        }

        $contact = new Contact(
            $stdContact->FirstName,
            $stdContact->Phone,
            $stdContact->LastName ?? null,
            $stdContact->Title ?? null,
            $stdContact->Organization ?? null,
            $stdContact->Email ?? null,
            $stdContact->Notes ?? null
        );
        return $contact;
    }
    /**
    * Creates a Contact using the parameters given.
    * @param string      $firstName    The first name of the contact in question.
    * @param string      $phoneNumber  Contact phone number: with country code and without spaces and dashes.
    * @param string|null $lastName     Contact last name.
    * @param string|null $title        Contact title.
    * @param string|null $organization Contact company or other organization.
    * @param string|null $email        Contact email address.
    * @param string|null $notes        Contact notes.
    * @return Contact
    */
    public static function createContactFromAttributes(
        string $firstName,
        string $phoneNumber,
        ?string $lastName = null,
        ?string $title = null,
        ?string $organization = null,
        ?string $email = null,
        ?string $notes = null
    ) : Contact {
        return new Contact(
            $firstName,
            $phoneNumber,
            $lastName,
            $title,
            $organization,
            $email,
            $notes
        );
    }

    /**
    * Creates a ProcessedContact using the JSON given.
    * @param string $jsonContact A JSON string matching the format of the IP1 SMS API.
    * @return ProcessedContact
    */
    public static function createProcessedContactFromJSON(string $jsonContact): ProcessedContact
    {
        return self::createProcessedContactFromStdClass(json_decode($jsonContact));
    }
    /**
    * Take an array filled with contact stdClasses and returns a ClassValidationArray filled with ProcessedContact.
    * @param array $contactArray An array filled with stdClass contacts.
    * @return ClassValidationArray Filled with ProcessedContact.
    */
    public static function createProcessedContactFromStdClassArray(array $contactArray): ClassValidationArray
    {
        $contacts = new ClassValidationArray();
        foreach ($contactArray as $c) {
            $contacts[] = self::createProcessedContactFromStdClass($c);
        }
        return $contacts;
    }
    /**
    * Creates a ProcessedContact using the stdClass given.
    * @param \stdClass $stdContact An stdClass object matching the format of the IP1 SMS API.
    * @return ProcessedContact
    * @throws \InvalidArgumentException Thrown when required parameters in the argument is missing.
    */
    public static function createProcessedContactFromStdClass(\stdClass $stdContact): ProcessedContact
    {
        if (empty($stdContact->FirstName)) {
            throw new \InvalidArgumentException("stdClass argument must contain FirstName attribute");
        }
        if (empty($stdContact->Phone)) {
            throw new \InvalidArgumentException("stdClass argument must contain Phone attribute");
        }
        $contact = new ProcessedContact(
            $stdContact->FirstName,
            $stdContact->Phone,
            $stdContact->ID,
            $stdContact->LastName ?? null,
            $stdContact->Title ?? null,
            $stdContact->Organization ?? null,
            $stdContact->Email ?? null,
            $stdContact->Notes ?? null,
            isset($stdContact->Created) ? new \DateTime($stdContact->Created, new \DateTimeZone("UTC")) : null,
            isset($stdContact->Modified) ? new \DateTime($stdContact->Modified, new \DateTimeZone("UTC")) : null
        );
        return $contact;
    }
    /**
    * Takes a JSON string group and returns a ProcessedGroup.
    * @param string $jsonGroup A single group JSON string.
    * @return ProcessedGroup
    */
    public static function createProcessedGroupFromJSON(string $jsonGroup): ProcessedGroup
    {
        return self::createProcessedGroupFromStdClass(json_decode($jsonGroup));
    }
    /**
    * Takes a stdClass group and returns a ProcessedGroup.
    * @param \stdClass $stdGroup A single stdClass group.
    * @return ProcessedGroup
    */
    public static function createProcessedGroupFromStdClass(\stdClass $stdGroup): ProcessedGroup
    {
        return new ProcessedGroup(
            $stdGroup->Name,
            $stdGroup->Color,
            $stdGroup->ID,
            new \DateTime($stdGroup->Created),
            new \DateTime($stdGroup->Modified)
        );
    }
    /**
    * @param string $jsonMembership A membership JSON string.
    * @return ProcessedMembership
    */
    public static function createProcessedMembershipFromJSON(string $jsonMembership): ProcessedMembership
    {
        return self::createProcessedMembershipFromStdClass(json_decode($jsonMembership));
    }
    /**
    * @param array $stdGroups An array filled with stdclass Group.
    * @return ClassValidationArray Filled with ProcessedGroup.
    */
    public static function createProcessedGroupsFromStdClassArray(array $stdGroups): ClassValidationArray
    {
        $groups = new ClassValidationArray();
        foreach ($stdGroups as $value) {
            $groups[] = self::createProcessedGroupFromStdClass($value);
        }
        return $groups;
    }
    /**
    * @param \stdClass $stdMembership An stdClass membership.
    * @return ProcessedMembership
    */
    public static function createProcessedMembershipFromStdClass(\stdClass $stdMembership): ProcessedMembership
    {
        return new ProcessedMembership(
            $stdMembership->Group,
            $stdMembership->Contact,
            $stdMembership->ID,
            new \DateTime($stdMembership->Created)
        );
    }
    /**
    * @param array $stdMemberships An stdClass Membership.
    * @return ClassValidationArray Filled with ProcessedMembership.
    */
    public static function createProcessedMembershipsFromStdClassArray(array $stdMemberships): ClassValidationArray
    {
        $memberships = new ClassValidationArray();
        foreach ($stdMemberships as $m) {
            $memberships[] = self::createProcessedMembershipFromStdClass($m);
        }
        return $memberships;
    }
    /**
    * @param string $membershipJSONArray An stdClass Group array encoded as a JSON string.
    * @return ClassValidationArray Filled with ProcessedMembership
    */
    public static function createProcessedMembershipsFromStringArray(string $membershipJSONArray): ClassValidationArray
    {
        return self::createProcessedMembershipsFromStdClassArray(json_decode($membershipJSONArray));
    }
    public static function createProcessedOutGoingSMSFromStdClass(\stdClass  $stdClassSMS): ProcessedOutGoingSMS
    {
        return new ProcessedOutGoingSMS(
            $stdClassSMS->From,
            $stdClassSMS->Message,
            $stdClassSMS->To,
            $stdClassSMS->ID,
            new DateTime($stdClassSMS->Created),
            new DateTime($stdClassSMS->Updated),
            $stdClassSMS->Status,
            $stdClassSMS->StatusDescription,
            $stdClassSMS->BundleID
        );
    }
    public static function createProcessedOutGoingSMSFromStdClassArray(array $stdClassArray): ClassValidationArray
    {
        $array = new ClassValidationArray(ProcessedOutGoingSMS::class);
        foreach ($stdClassArray as $stdClass) {
            $array[]= self::createProcessedOutGoingSMSFromStdClass($stdClass);
        }
        return $array;
    }
    public static function createProcessedOutGoingSMSFromJSONArray(string $jsonArray): ClassValidationArray
    {
        return self::createProcessedOutGoingSMSFromStdClassArray(json_decode($jsonArray));
    }
}
