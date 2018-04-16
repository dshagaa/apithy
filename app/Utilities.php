<?php

namespace App;


class Utilities
{
    public static function between($var, $min, $max){
        if ($var>$min && $var<$max){
            return true;
        }
        return false;
    }
}