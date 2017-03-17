<?php
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
}
