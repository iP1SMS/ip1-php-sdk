<?php
/**
* Contains the Group class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
use IP1\RESTClient\Core\UpdatableComponent;

namespace IP1\RESTClient\Recipient;

class Group implements \JsonSerializable
{
   /**
    * Name of Group
    * @var string $name
    */
    protected $name;
    /**
    * Contact group color, hexadecimal
    * @example #5E5E5E
    * @var string $color
    */
    protected $color;
    /**
    * An array of Membership
    * @var array Membership
    */
    protected $memberships = [];

    /**
    * Group constructor
    * @param string $name Name of Group.
    * @param string $color Hexadecimal color code.
    */
    public function __construct(string $name, string $color)
    {
        $this->setName($name);
        $this->setColor($color);
    }
    /**
    * Returns the name of the group.
    * @return string Name of Group.
    */
    public function getName(): string
    {
        return $this->name;
    }
    /**
    * Returns the groups color in hexadecimal
    * @return string hexadecimal color
    */
    public function getColor(): string
    {
        return $this->color;
    }
    /**
    * Sets the Group's name to the given string
    * @param string $name
    */
    public function setName(string $name):void
    {
        if (empty($name)) {
            //TODO: Throw EmptyStringException
        }
        $this->name = $name;
    }
    /**
    * Sets the groups color.
    * @param $color A hexadecimal color code.
    */
    public function setColor(string $color): void
    {
        if (!preg_match("/^#([A-Fa-f0-9]{6})$/", $color)) {
            //TODO Throw non hexadecimal color exception
            throw new Exception($color. " is not a valid hexadecimal color");
        }
        $this->color = $color;
    }
    /** {@inheritDoc} */
    public function jsonSerialize()
    {
        $returnArray = [
            'Name' => $this->name,
            'Color' => $this->Color,
        ];
        return $returnArray;
    }
}
