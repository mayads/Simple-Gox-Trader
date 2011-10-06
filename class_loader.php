<?php

function &loadSingleton($classname, $parameter = array())
{
        static $objects = array();

        // is there an existing object from this class, return it
        if (isset($objects[$classname]))
        {
                return $objects[$classname];
        }
        else
        {
		$newObject;
                if (empty($parameter))
                { // object without params
                         $newObject = new $classname();
                }
                else
                { // object with params
                        $ref = new ReflectionClass($classname);
                        $newObject =  $ref->newInstanceArgs($parameter);
                }

                $objects[$classname] = &$newObject;

                return $objects[$classname];
        }
}

?>
