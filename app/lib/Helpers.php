<?php

namespace app\lib;

class Helpers
{
    public static function getClassShortName(object|string $class)
    {
        $reflect = new \ReflectionClass($class);
        
        return $reflect->getShortName();
    }
}
