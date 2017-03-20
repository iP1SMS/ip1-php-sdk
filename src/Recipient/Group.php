<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\ProcessableComponentInterface;

/**
* Used to group contacts together with the Membership class.
*/
class Group implements ProcessableComponentInterface
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
    * @return self
    * @throws \InvalidArgumentException When $name is empty.
    */
    public function setName(string $name): self
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Group name can not be empty");
        }
        $this->name = $name;
        return $this;
    }
    /**
    * Sets the groups color.
    * @param string $color A hexadecimal color code.
    * @example #5E5E5E
    * @return self
    * @throws \InvalidArgumentException When $color isn't a valid hexadecimal color.
    */
    public function setColor(string $color): self
    {
        if (!preg_match("/^#([A-Fa-f0-9]{6})$/", $color)) {
            throw new \InvalidArgumentException($color. " is not a valid hexadecimal color");
        }
        $this->color = $color;
        return $this;
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
