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
    /**
    * @param string $firstName
    * @param string $phoneNumber
    * @param string $lastName
    * @param string $title
    * @param string $organization
    * @param string $email
    * @param string $notes
    *
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
