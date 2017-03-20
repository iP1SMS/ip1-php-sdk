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

namespace IP1\RESTClient\Test\Core;

use PHPUnit\Framework\TestCase;
use IP1\RESTClient\Core\ClassValidationArray;
use \DateTime;
use \stdClass;
use \InvalidArgumentException;
use \ArrayObject;

class ClassValidationArrayTest extends TestCase
{

    /**
    * @dataProvider getValidNonArrayInputs
    * @covers ClassValidationArray::__construct
    */
    public function testConstructorNonArrayInputs($input)
    {
        $this->assertEquals([$input], (new ClassValidationArray($input))->getArrayCopy());
    }
    /**
    * @dataProvider getValidArrayInputs
    * @covers ClassValidationArray::__construct
    */
    public function testConstructorArrayInputs($inputs)
    {
        $this->assertEquals($inputs, (new ClassValidationArray($inputs))->getArrayCopy());
    }
    /**
    * @dataProvider getInValidArrays
    * @covers ClassValidationArray::__construct
    */
    public function testInvalidArrayInput($invalidArray)
    {
        $this->expectException(InvalidArgumentException::class);
        new ClassValidationArray($invalidArray);
    }
    /**
    * @dataProvider getScalarTypes
    * @covers ClassValidationArray::__construct
    */
    public function testScalarVariables($scalarVariable)
    {
        $this->expectException(\InvalidArgumentException::class);
        $array = new ClassValidationArray($scalarVariable);
    }
    /**
    * @dataProvider getNonEmptyValidArrays
    * @covers ClassValidationArray::offsetSet
    */
    public function testAddWrongObjectClass($validArray)
    {
        $this->expectException(InvalidArgumentException::class);
        $array = new ClassValidationArray($validArray);
        $array[] = new ArrayObject();
    }

    /**
     * @dataProvider getScalarTypes
     * @covers ClassValidationArray::offsetSet
     */
    public function testAddScalarTypes($scalarVariable)
    {
        $this->expectException(InvalidArgumentException::class);
        $array = new ClassValidationArray([]);
        $array[] = $scalarVariable;
    }
    public function getNonEmptyValidArrays()
    {
        return [
            [
                [new stdClass,new stdClass,new stdClass,new stdClass,],
                [new DateTime(),new DateTime(),new DateTime(),new DateTime(),],
                [new stdClass],
            ]
        ];
    }
    public function getValidArrayInputs()
    {
        return [[
            [],
            [new stdClass,new stdClass,new stdClass,new stdClass,],
            [new DateTime(),new DateTime(),new DateTime(),new DateTime(),],
            [new stdClass],
            ]];
    }
    public function getInValidArrays()
    {
        return [
            [
                [new stdClass, new DateTime],
                [new stdClass, new stdClass, 1],
                [new stdClass, new stdClass, true],
                ['Jack', new stdClass],
                [1,2,1,2,3,5,6,3,1,32],
                ["","1231", "Jack",],
                [false, false, false, false,],
                [true, true, true, true],
                [false, true, true, false],
            ]
        ];
    }
    public function getValidNonArrayInputs()
    {
        return [
            [new DateTime(), new stdClass(), new ClassValidationArray()]
        ];
    }
    public function getScalarTypes()
    {
        return [
            [0,1,1.1, "", "filledString", false, true,],
        ];
    }
}
