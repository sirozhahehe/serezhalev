<?php

class InputCleaner
{
    /** Cleaning input from user, return result as String
     * @param $input string - expected some input data from user
     * @return string - result of cleaning
     */
    public static function inClean($input){
        $result = htmlspecialchars(urldecode(trim($input)));
        return $result;
    }
}