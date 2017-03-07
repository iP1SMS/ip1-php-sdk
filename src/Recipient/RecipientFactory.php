<?php
/**
* Contains the RecipientFactory class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Recipient\ProcessedContact;

/**
* Handles construction of Recipients.
* @package \IP1\RESTClient\Recipient
*/
class RecipientFactory
{
    /**
    * Creates a Contact using the stdClass given.
    * @param string $jsonContact A JSON string matching the format of the IP1 SMS API
    * @return Contact
    */
    public static function createContactFromJSON(string $jsonContact): Contact
    {
          return self::createContactFromStdClass(json_decode($jsonContact));
    }
    /**
    * Creates a Contact using the stdClass given.
    * @param \stdClass $stdContact An stdClass object matching the format of the IP1 SMS API
    * @return Contact
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
    * @param string $firstName               The first name of the contact in question
    * @param string $phoneNumber             Contact phone number: with country code and without spaces and dashes
    * @param string $lastName (optional)     Contact last name
    * @param string $title (optional)        Contact title
    * @param string $organization (optional) Contact company or other organization
    * @param string $email (optional)        Contact email address
    * @param string $notes (optional)        Contact notes
    * @return Contact
    */
    public static function createContactFromAttributes(
        string $firstName,
        string $phoneNumber,
        string $lastName = null,
        string $title = null,
        string $organization = null,
        string $email = null,
        string $notes = null
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
    * @param string $jsonContact A JSON string matching the format of the IP1 SMS API
    * @return ProcessedContact
    */
    public static function createProcessedContactFromJSON(string $jsonContact): ProcessedContact
    {
        return self::createProcessedContactFromStdClass(json_decode($jsonContact));
    }
    public static function createProcessedContactFromStdClassArray(array $contactArray): array
    {
        $contacts = [];
        foreach ($contactArray as $c) {
            $contacts[] = self::createProcessedContactFromStdClass($c);
        }
        return $contacts;
    }
    /**
    * Creates a ProcessedContact using the stdClass given.
    * @param \stdClass $stdContact An stdClass object matching the format of the IP1 SMS API
    * @return ProcessedContact
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
}
