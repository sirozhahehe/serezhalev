<?php

class Encrypter
{
    /** Encrypts password, returns result as String
     *@param $password string - password
     *@return string - encrypted password
     */
    public static function enCrypt($password){
        $result = $password.'lev';
        $result = md5($result);
        $result = substr($result,0,16);
        return $result;
    }
}