<?php

namespace IP1\RESTClient\Core;

/**
*
* An extension of ArrayObject that ensures that there's only one type of object in the array.
* @package IP1\RESTClient\Core
*/
class ClassValidationArray extends \ArrayObject implements \JsonSerializable
{

    /**
    * Stores the only allowed class that is allowed in the array.
    * @var string $class
    */
    private $class;
    /**
    * Takes the input and puts it in the contained array.
    *
    * If the input is an object it will add the object to the array and set the object's class to the only allowed class
    * If the input is an array it will verify that all the objects inside the array are of the same class if not it will
    *   throw an InvalidArgumentException. If all the indexes are of the same class it will  add them to the array.
    *
    * @param $input array|object If array it must only contain a single type of class.
    * @throws InvalidArgumentException
    */
    public function __construct($input = [])
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                if (!is_object($value)) {
                    throw new \InvalidArgumentException("Non object found at index $key. Not allowed.");
                }
                if (!isset($this->class)) {
                    $this->class = get_class($value);
                }
                if ($this->class === get_class($value)) {
                    parent::offsetSet(null, $value);
                } else {
                    throw new \InvalidArgumentException(
                        $this->class.
                        " expected in array. Got" .
                        get_class($value) .
                        " at index $key"
                    );
                }
            }
        } elseif (is_object($input)) {
            $this->class = get_class($input);
            parent::offsetSet(null, $input);
        } else {
            throw new \InvalidArgumentException(gettype($input). " given argument was not an array or an object.");
        }
    }

    /**
    *  Sets the value at the specified index to value if value's class matches the one set.
    *       If a class has not been set it will set the given object's class as the only allowed class.
    * @throws InvalidArgumentException
    */
    public function offsetSet($index, $value): void
    {
        if (!is_object($value)) {
            throw new \InvalidArgumentException("Excepcted object, got ". gettype($value));
        }
        if (!isset($this->class)) {
            $this->class = get_class($value);
        }
        if (get_class($value) === $this->class) {
            parent::offsetSet($index, $value);
        } else {
            throw new \InvalidArgumentException("Excepcted $this->class, got ". get_class($value));
        }
    }
    /**
    * Returns the only class that is allowed to be added.
    * @return string
    */
    public function getContainedClass(): string
    {
        return $this->class;
    }
     /**
      * {@inheritDoc}
      */
    public function jsonSerialize(): array
    {
        $returnArray = [];
        foreach ($this->getArrayCopy() as $value) {
            $returnArray[] = $value->JsonSerialize();
        }
        return $returnArray;
    }
}
