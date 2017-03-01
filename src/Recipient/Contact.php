<?php

namespace IP1\RESTClient\Recipient;

class Contact implements \JsonSerializable
{
    private $firstName;
    private $lastName;
    private $title;
    private $organization;
    private $phone;
    private $email;
    private $notes;

    private function __construct(
        string $firstName,
        string $phoneNumber
    ) {
        if (empty($firstName)) {
            throw new \InvalidArgumentException("\$firstName cannot be empty.");
        }
        if (empty($phoneNumber)) {
            throw new \InvalidArgumentException("\$phoneNumber cannot be empty.");
        }
        $this->firstName =  $firstName;
        $this->phone = $phoneNumber;
    }



    public static function createFromJSON(string $jsonContact)
    {
        return self::createFromStdClass(json_decode($jsonContact));
    }
    public static function createFromStdClass(\stdClass $stdContact): Contact
    {
        if (empty($stdContact->FirstName)) {
            throw new \InvalidArgumentException("stdClass argument must contain FirstName attribute");
        }
        if (empty($stdContact->Phone)) {
            throw new \InvalidArgumentException("stdClass argument must contain Phone attribute");
        }

        $contact = new Contact($stdContact->FirstName, $stdContact->Phone);
        isset($stdContact->LastName) ? $contact->setLastName($stdContact->LastName) : null;
        isset($stdContact->Title) ? $contact->setTitle($stdContact->Title) : null;
        isset($stdContact->Organization) ? $contact->setOrganization($stdContact->Organization) : null;
        isset($stdContact->Email) ? $contact->setEmail($stdContact->Email) : null;
        isset($stdContact->Notes) ? $contact->setNotes($stdContact->Notes) : null;
        return $contact;
    }
    public static function createFromAttributes(
        string $firstName,
        string $phoneNumber,
        string $lastName = null,
        string $title = null,
        string $organization = null,
        string $email = null,
        string $notes = null
    ) {
        $contact = new Contact($firstName, $phoneNumber);
        $contact->setLastName($lastName);
        $contact->setOrganization($organization);
        $contact->setTitle($title);
        $contact->setEmail($email);
        $contact->setNotes($notes);
        return $contact;
    }
    public function jsonSerialize()
    {
        $returnObject = new \stdClass();
        $returnObject->FirstName = $this->firstName ?:null;
        $returnObject->LastName = $this->lastName ?:null;
        $returnObject->Title = $this->title ?:null;
        $returnObject->Organization = $this->organization ?: null;
        $returnObject->Phone = $this->phone ?:null;
        $returnObject->Email = $this->email ?: null;
        $returnObject->Notes = $this->notes ?:null;


        return array_filter((array) $returnObject);
    }
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    public function setLastName(?string $lastName)
    {
        $this->lastName = $lastName;
    }
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phone = $phoneNumber;
    }
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }
    public function setOrganization(?string $organization)
    {
        $this->organization = $organization;
    }
    public function setEmail(?string $email)
    {
        $this->email = $email;
    }
    public function setNotes(?string $notes)
    {
        $this->notes = $notes;
    }
    public function getFirstName():string
    {
        return $this->firstName;
    }
    public function getLastName():string
    {
        return $this->lastName ?? "";
    }
    public function getPhoneNumber():string
    {
        return $this->phone;
    }
    public function getEmail():string
    {
        return $this->email ?? "";
    }
    public function getTitle():string
    {
        return $this->title ?? "";
    }
    public function getOrganization():string
    {
        return $this->organization ?? "";
    }
    public function getNotes():string
    {
        return $this->notes ?? "";
    }
}
