<?php
/**
* Contains the Group class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @package IP1\RESTClient\Recipient
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\ProcessableComponent;

/**
* Used to group contacts together with the Membership class.
*/
class Group implements ProcessableComponent
{
   /**
    * Name of Group.
    * @var string $name
    */
    protected $name;
    /**
    * Contact group color, hexadecimal.
    * @var string $color
    */
    protected $color;
    /**
    * An array of Membership.
    * @var array Membership.
    */
    protected $memberships = [];

    /**
    * Group constructor
    * @param string $name  Name of Group.
    * @param string $color Hexadecimal color code.
    * @example #5E5E5E
    */
    public function __construct(string $name, string $color)
    {
        $this->setName($name);
        $this->setColor($color);
    }
    /**
    * Returns the name of the Group.
    * @return string Name of Group.
    */
    public function getName(): string
    {
        return $this->name;
    }
    /**
    * Returns the groups color in hexadecimal.
    * @return string hexadecimal color.
    */
    public function getColor(): string
    {
        return $this->color;
    }
    /**
    * Sets the Group's name to the given string.
    * @param string $name Name that the Group should have.
    * @throws InvalidArgumentException When $name is empty.
    * @return void
    */
    public function setName(string $name):void
    {
        if (empty($name)) {
            throw new InvalidArgumentException("Group name can not be empty");
        }
        $this->name = $name;
    }
    /**
    * Sets the groups color.
    * @param string $color A hexadecimal color code.
    * @example #5E5E5E
    * @return void
    * @throws InvalidArgumentException When $color isn't a valid hexadecimal color.
    */
    public function setColor(string $color): void
    {
        if (!preg_match("/^#([A-Fa-f0-9]{6})$/", $color)) {
            throw new InvalidArgumentException($color. " is not a valid hexadecimal color");
        }
        $this->color = $color;
    }
    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative.
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        $returnArray = [
            'Name' => $this->name,
            'Color' => $this->color,
        ];
        return $returnArray;
    }
    /**
    * Returns the object as a JSON string.
    * @return string
    */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
}
