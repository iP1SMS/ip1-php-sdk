<?php

namespace \IP1\RESTClient\SMS;

class OutGoingSMS extends SMS
{
    private $numbers = [];
    private $contacts = [];
    private $groups = [];
    private $email = false;

    public function addNumber(string $number): void
    {
        $this->numbers[] = $number;
    }
    public function addContact(Contact $contact): void
    {
        $this->contacts[] = $contact;
    }
    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }

    public function toJson(int $styleArg = 0): string
    {
        $returnObject = new \stdClass();
        if (count($this->numbers) > 0) {
            $returnObject->Numbers = $this->numbers;
        }
        if (count($this-contacts) > 0) {
            $returnObject->Contacts = [];
            foreach ($this->contacts as $contact) {
                $returnObject->Contacts[] = $contact->getID();
            }
        }
        if (count($this->groups) > 0) {
            $returnObject->Groups = [];
            foreach ($this->groups as $group) {
                $returnObject->Groups[] = $group->getID();
            }
        }
        return json_encode($returnObject, $styleArg);
    }
}
