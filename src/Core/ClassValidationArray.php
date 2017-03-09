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
    * @throws InvalidArgumentException
    */
    public function __construct($input = [])
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                if (!is_object($value)) {
                    throw new \InvalidArgumentException(
                        get_class($value).
                        " is not the same class as ".
                        $this->class .
                        " given in the first index of argument array."
                    );
                }
                if (!isset($this->class)) {
                    $this->class = get_class($value);
                }
                if ($this->class === get_class($value)) {
                    parent::offsetSet(null, $value);
                } else {
                    throw new \InvalidArgumentException($this->class. " expected as set by the first index in given array. " . get_class($value) . " given in index $key of given array.");
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
    *  Sets the value at the specified index to value if
    * @throws InvalidArgumentException
    */
    public function offsetSet($index, $value): void
    {
        if (!is_object($value)) {
            throw new \InvalidArgumentException("Excepcted object, ". gettype($value) ." given.");
        }
        if (!isset($this->class)) {
            $this->class = get_class($value);
        }
        if (get_class($value) === $this->class) {
            parent::offsetSet($index, $value);
        } else {
            throw new \InvalidArgumentException("Excepcted $this->class, ". get_class($value) ." given.");
        }
    }
    public function getContainedClass(): string
    {
        return $this->class;
    }
     /**
      * {@inheritDoc}
      */
    public function JsonSerialize(): array
    {
        $returnArray = [];
        foreach ($this->getArrayCopy() as $value) {
            $returnArray[] = $value->JsonSerialize();
        }
        return $returnArray;
    }
}
