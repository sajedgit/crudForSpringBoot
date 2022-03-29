<?php


function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
{

    $str = str_replace('_', '', ucwords($string, '_'));

    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }

    return $str;
}
