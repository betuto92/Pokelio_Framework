<?php
/**
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Global
 * A class to manipulate $GLOBALS array and configuration files
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Global{
    /**
     * Loads the specified json config file and assigns values to $GLOBALS array
     * 
     * @param string $confFile Configuration file to be loaded
     * @param string $module   Module to which configurations refers to
     */
    public static function loadConfigFile($confFile, $module='Pokelio'){
        if(!file_exists($confFile)){
            die("Config file $confFile not found");
        }
        $confContent=file_get_contents($confFile);
        $config=  json_decode($confContent);
        $GLOBALS[$module]=$config;
    } 
    /**
     * It returns the value of the config specified parameter
     * 
     * @param string $param   Name of the parameter
     * @param string $module  Name of the parameter's module
     * @return mixed     
     */
    public static function getConfig($param, $module='Pokelio'){
        if(!isset($GLOBALS[$module]->$param)){
            trigger_error("Config parameter $param not defined in module $module.");
        } 
        return $GLOBALS[$module]->$param;
    }
    /**
     * Sets the value of the config specified parameter
     * 
     * @param string $param   Name of the parameter
     * @param string $module  Name of the parameter's module
     */    
    public static function setConfig($param,$value, $module='Pokelio'){
        $GLOBALS[$module]->$param=$value;
    }
    /**
     * It returns the value of the specified variable
     * This is not a value contained in a config file but a value previously 
     * assigned in runtime by Pokelio_Global::setVar
     * 
     * @param string $param   Name of the variable
     * @param string $module  Name of the variable's module
     * @return mixed     
     */    
    public static function getVar($var, $module='Pokelio'){
        if(!isset($GLOBALS['vars'.$module][$var])){
            Pokelio_Error::triggerError("Global var $var not defined in module $module.");
        } 
        return $GLOBALS['vars'.$module][$var];
    }
    /**
     * Checks if a variable is set
     * 
     * @param string $param   Name of the variable
     * @param string $module  Name of the variable's module
     * @return boolean     
     */    
    public static function issetVar($var, $module='Pokelio'){
        return isset($GLOBALS['vars'.$module][$var]);
    }    
    /**
     * It sets the value of the specified variable
     * This value will be available through Pokelio_Global::getVar function
     * 
     * @param string $param   Name of the variable
     * @param string $module  Name of the variable's module   
     */      
    public static function setVar($var,$value, $module='Pokelio'){
        if(!isset($GLOBALS['vars'.$module])){
            $GLOBALS['vars'.$module]=array();
        }
        $GLOBALS['vars'.$module][$var]=$value;
    }    
}
