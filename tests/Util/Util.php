<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.2.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Test\Util;

class Util
{
    public static function getRandomDateTime()
    {
        $randomTimeStamp = rand(0, 1489655402);
        $date = new \DateTime(null, new \DateTimeZone("UTC"));
        $date->setTimestamp($randomTimeStamp);
        return $date;
    }
    public static function getRandomAlphaString(int $length = 30)
    {
        $characters = 'abcdfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characterLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $characterLength - 1)];
        }
        return $randomString;
    }
    public static function getRandomHex()
    {
        $chars = 'ABCDEF0123456789';
        $color = "#";
        for ($i = 0; $i < 6; $i++) {
            $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
    }
    public static function getRandomAccountID(): string
    {
        return "ip1-".random_int(10000, 99999);
    }
    public static function getRandomPhoneNumber(): string
    {
        $retval = '';
        for ($i=0; $i < 11; $i++) {
            $retval.=random_int(0, 9);
        }
        return $retval;
    }
}
