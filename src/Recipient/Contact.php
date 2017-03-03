<?php
/**
* Contains the Contact class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Recipient;

/**
* Contact class that represents the JSON that is sent to the API when adding a new Contact
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\Recipient;
*/
class Contact implements \JsonSerializable
{
    private $firstName;
    private $lastName;
    private $title;
    private $organization;
    private $phone;
    private $email;
    private $notes;
    /**
    * The Contact constructor
    *
    * @param string $firstName               The first name of the contact in question
    * @param string $phoneNumber             Contact phone number: with country code and without spaces and dashes
    * @param string $lastName (optional)     Contact last name
    * @param string $organization (optional) Contact company or other organization
    * @param string $email (optional)        Contact email address
    * @param string $notes (optional)        Contact notes
    */
    public function __construct(
        string $firstName,
        string $phoneNumber,
        string $lastName = null,
        string $title = null,
        string $organization = null,
        string $email = null,
        string $notes = null
    ) {
        if (empty($firstName)) {
            throw new \InvalidArgumentException("\$firstName cannot be empty.");
        }
        if (empty($phoneNumber)) {
            throw new \InvalidArgumentException("\$phoneNumber cannot be empty.");
        }
        $this->firstName =  $firstName;
        $this->phone = $phoneNumber;
        $this->lastName = $lastName;
        $this->title = $title;
        $this->organization = $organization;
        $this->email = $email;
        $this->notes = $notes;
    }
    /**
    * @return array
    */
    public function jsonSerialize(): array
    {
        $returnArray = [
            'FirstName' => $this->firstName,
            'LastName' => $this->lastName,
            'Organization' => $this->organization,
            'Phone' => $this->phone,
            'Email' => $this->email,
            'Title' => $this->title,
            'Notes' => $this->notes,
        ];
        return array_filter($returnArray);
    }
    /**
    * @param string $firstName Sets the first name of the contact
    */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
    * @param string $lastName|null Sets the last name of the contact
    */
    public function setLastName(?string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
    * @param string $phoneNumber Sets the phone number of the contact
    */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phone = $phoneNumber;
    }

    /**
    * @param string $title|null Sets the title of the contact
    */
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }

    /**
    * @param string $organization|null Sets the contact company or other organization the contact belongs to
    */
    public function setOrganization(?string $organization)
    {
        $this->organization = $organization;
    }

    /**
    * @param string $email|null Sets the email adress of the contact
    */
    public function setEmail(?string $email)
    {
        $this->email = $email;
    }

    /**
    * @param string $firstName Sets the first name of the contact
    */
    public function setNotes(?string $notes)
    {
        $this->notes = $notes;
    }
    /**
    * @return string The contacts first name
    */
    public function getFirstName():string
    {
        return $this->firstName;
    }
    /**
    * @return string The contacts last name
    */
    public function getLastName():string
    {
        return $this->lastName ?? "";
    }
    /**
    * @return string  The contacts phone number
    */
    public function getPhoneNumber():string
    {
        return $this->phone;
    }
    /**
    * @return string  The contacts email
    */
    public function getEmail():string
    {
        return $this->email ?? "";
    }

    /**
    * @return string  The contacts title
    */
    public function getTitle():string
    {
        return $this->title ?? "";
    }

    /**
    * @return string  The contacts company or other organization
    */
    public function getOrganization():string
    {
        return $this->organization ?? "";
    }
    /**
    * @return string  The contact notes
    */
    public function getNotes():string
    {
        return $this->notes ?? "";
    }
}
