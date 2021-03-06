<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.2.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Test\Recipient;

use PHPUnit\Framework\TestCase;
use IP1\RESTClient\Recipient\Group;

class GroupTest extends TestCase
{
  /**
  * @dataProvider getValidGroupInputs
  */
    public function testValidInputs($name, $color)
    {
        $group = new Group($name, $color);
        $this->addToAssertionCount(1);
    }
  /**
  * @dataProvider getInValidGroupInputs
  */
    public function testInvalidInputs($name, $color)
    {
        $this->expectException(\InvalidArgumentException::class);
        $group = new Group($name, $color);
    }
    /**
    * @dataProvider getValidGroupInputs
    */
    public function testGettersAndSetters($name, $color)
    {
        $group = new Group("Jack", "#ffddff");
        $group->setName($name);
        $group->setColor($color);

        $this->assertEquals($name, $group->getName());

        $this->assertEquals($color, $group->getColor());
    }
    /**
    * @dataProvider getValidGroupInputs
    */
    public function testMethodChaining($name, $color)
    {
        $group = new Group("Jack", "#ffddff");
        $group->setName($name)
              ->setColor($color)
              ->setName($name);

        $this->assertEquals($name, $group->getName());

        $this->assertEquals($color, $group->getColor());
    }
    public function getValidGroupInputs(): array
    {
        return [
            ['Jack', '#930ba8'],
            ['Sparrow', '#b0bf65'],
            ['Elizabeth', '#d42049'],
            ['Swann', '#a584b9'],
            ['Davy', '#29d75b'],
            ['Jones','#a7a385'],
        ];
    }

    public function getInValidGroupInputs(): array
    {
        return [
            ['', '#930ba8'],
            ['Sparrow', 'b0bf65'],
            ['Elizabeth', '#d4209'],
            ['Swann', '#'],
            ['Davy', '#2'],
            ['Jones','#a7'],
        ];
    }
}
