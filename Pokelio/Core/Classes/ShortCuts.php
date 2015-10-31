<?php

class _{
    public static function logWriteInfo($msg){
        Pokelio_Log::writeInfo($msg);
    }
    public static function echoWriteInfo($msg, $source=false){
        Pokelio_Log::echoWriteInfo($msg, $source);
    }    
    public static function getConfig($param){
        return Pokelio_Global::getConfig($param);
    }    
    public static function getVar($var){
        return Pokelio_Global::getVar($var);
    }    
    public static function setVar($var, $value){
        Pokelio_Global::setVar($var, $value);
    }    
    public static function getParamValue($name){
        return Pokelio_Parameter::getValue($name);
    }   
    public static function isParamSet($name){
        return Pokelio_Parameter::isParamSet($name);
    }   
    public static function abort($msg=null){
        Pokelio_Application::abort($msg);
    }
}

