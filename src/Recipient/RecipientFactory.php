<?php

namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Recipient\ProcessedContact;

class RecipientFactory
{

    public static function createContactFromJSON(string $jsonContact): Contact
    {
          return self::createContactFromStdClass(json_decode($jsonContact));
    }
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
    public static function createProcessedContactFromJSON(string $jsonContact): ProcessedContact
    {
        return self::createProcessedContactFromStdClass(json_decode($jsonContact));
    }
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
