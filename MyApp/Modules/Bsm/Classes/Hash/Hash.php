<?php

class BaSeMa_Hash{
    public static function getUserPasswordHash($user, $password){
        $userPassword=$user.$password;
        return self::generateHash($userPassword);
    }
    public static function isValidUserPassword($user, $password, $hash){
        $userPassword=$user.$password;
        return self::isValidHash($userPassword, $hash);
    }
    public static function generateHash($plain){
        //Generate a random seed
        $seed=substr(md5(microtime()),0,8);
        //Append plain to seed
        $total=$seed.$plain;
        //Calculate hash
        $hash=md5($total);
        //Return applied seed + hash
        return $seed.$hash;
    }
    public static function isValidHash($plain, $hash){
        $valid=false;
        //Extract seed from hash
        $seed=substr($hash,0,8);
        //Append plain to seed
        $total=$seed.$plain;
        //Calculate hash
        $cHash=md5($total);
        //Compare them
        if($seed.$cHash == $hash){
            $valid=true;
        }
        return $valid;
    }
}
