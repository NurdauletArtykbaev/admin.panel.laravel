<?php


namespace App\SBlog\Core;


class Registry
{
    use TSingletone;

    protected static $properties = [];

    // хранения состояние

    public static function setProperty($name, $value)
    {
         self::$properties[$name] = $value;
    }

    public static function getProperty($name)
    {
        if (isset(self::$properties[$name])){
            return self::$properties[$name];
        }
        return null;
    }

    public static function getProperties()
    {
        return self::$properties;
    }



}
