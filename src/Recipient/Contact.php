<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\ProcessableComponentInterface;

/**
* Contact class that represents the JSON that is sent to the API when adding a new Contact
*/
class Contact implements ProcessableComponentInterface
{
    /**
    * The contacts first name.
    * @var string $firstName
    */
    private $firstName;
    /**
    * The contacts last name.
    * @var string $lastName
    */
    private $lastName;
    /**
    * The contacts title.
    * @var string $title
    */
    private $title;
    /**
    * The contacts company or other organization.
    * @var string $organization
    */
    private $organization;
    /**
    * The contacts phone number.
    * @var string $phone
    */
    private $phone;
    /**
    * The contacts email adress.
    * @var string $email
    */
    private $email;
    /**
    * The contacts notes.
    * @var string $notes
    */
    private $notes;
    /**
    * The Contact constructor
    *
    * @param string $firstName    The first name of the contact in question.
    * @param string $phoneNumber  Contact phone number: with country code and without spaces and dashes.
    * @param string $lastName     Contact last name.
    * @param string $title        Contacts title Eg. CEO.
    * @param string $organization Contact company or other organization.
    * @param string $email        Contact email address.
    * @param string $notes        Contact notes.
    * @throws \InvalidArgumentException Thrown when $firstName or $phoneNumber is empty.
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
       * Serializes the object to a value that can be serialized natively by json_encode().
       * @return array Associative.
       * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
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
    * Returns the object as a JSON string.
    * @return string
    */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
    /**
    * @param string $firstName Sets the first name of the contact.
    * @return self
    */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
    * @param ?string $lastName Sets the last name of the contact.
    * @return self
    */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
    * @param string $phoneNumber Sets the phone number of the contact.
    * @return self
    */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phone = $phoneNumber;
        return $this;
    }

    /**
    * @param ?string $title Sets the title of the contact.
    * @return self
    */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
    * @param ?string $organization Sets the contact company or other organization the contact belongs to.
    * @return self
    */
    public function setOrganization(?string $organization): self
    {
        $this->organization = $organization;
        return $this;
    }

    /**
    * @param ?string $email Sets the email adress of the contact.
    * @return self
    */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
    * @param ?string $notes Sets the notes of the contact.
    * @return self
    */
    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }
    /**
    * @return string The contacts first name.
    */
    public function getFirstName():string
    {
        return $this->firstName;
    }
    /**
    * @return string The contacts last name.
    */
    public function getLastName():string
    {
        return $this->lastName ?? "";
    }
    /**
    * @return string  The contacts phone number.
    */
    public function getPhoneNumber():string
    {
        return $this->phone;
    }
    /**
    * @return string  The contacts email.
    */
    public function getEmail():string
    {
        return $this->email ?? "";
    }

    /**
    * @return string  The contacts title.
    */
    public function getTitle():string
    {
        return $this->title ?? "";
    }

    /**
    * @return string  The contacts company or other organization.
    */
    public function getOrganization():string
    {
        return $this->organization ?? "";
    }
    /**
    * @return string  The contact notes.
    */
    public function getNotes():string
    {
        return $this->notes ?? "";
    }
}
