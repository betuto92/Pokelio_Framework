<?php
/**
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Parameter
 * A class to centralize collections of parameters ($_POST, $_GET, $_SERVER)
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Parameter{
    public static function getValue($name, $mandatory=false, $default=null){
        $value=null;
        if(SESSION_TYPE=='WEB'){
            //check first POST parameters
            if(isset($_POST[$name])){
                $value=$_POST[$name];
            }elseif(isset($_GET[$name])){
                $value=$_GET[$name];
            }elseif(Pokelio_Global::getConfig('ALLOW_URL_PARAMS', 'Pokelio')){ 
                $value=self::getUrlParamValue($name);
            }
        }else{
            $value=self::getCliParamValue($name);
        }
        if($value===null){
            if($mandatory==false){
                $value=$default;
            }else{
                trigger_error("Mandatory parameter ".$name." is missing.");
            }
        }
        return $value;
    }
    public static function isParamSet($name){
        $isset=false;
        if(self::getValue($name)!==null){
            $isset=true;
        }
        return $isset;
    }
    public static function getUrlParamValue($name){
        $value=null;
        if(Pokelio_Global::issetVar('URL_PARAMS')==false){
            self::setUrlParams();
        }
        $urlParams=Pokelio_Global::getVar('URL_PARAMS');
        if(isset($urlParams[$name])){
            $value=$urlParams[$name];
        }
        return $value;
    }
    public static function setUrlParams(){
        /*
         * Typical format of $_SERVER['REDIRECT_URL'] is
         * /PokelioFramework/MyApp/Controller/Action/
         */
        $url=$_SERVER['REDIRECT_URL'];
        if(substr($url,-1)=="/"){
            $url=substr($url,-1);
        }
        /*
         * Typical format of $_SERVER['PHP_SELF'] is
         * /PokelioFramework/MyApp/App.php
         */
        $self=$_SERVER['PHP_SELF'];
        //Remove the last element of $self
        $self=substr($self,0,-strpos(strrev($self),"/"));
        //Now we can extract the interesting part of url
        $xUrl=substr($url,strlen($self));
        //Disect url
        $parts=explode("/",$xUrl);
        //0 and 1 elements are controller and action, so if the size of $parts
        //is less than 3 then nothing to do
        $params=array();
        if(sizeof($parts>=3)){
            for($i=2;$i<sizeof($parts);$i=$i+2){
                if(isset($parts[$i+1])){
                    $params[$parts[$i]]=$parts[$i+1];
                }else{
                    $params[$parts[$i]]='';
                }
            }
        }
        //Initialize the global array to store params/values
        Pokelio_Global::setVar('URL_PARAMS', $params);  
    }
    public static function getCliParamValue($name){
        $value=null;
        if(Pokelio_Global::issetVar('CLI_PARAMS')==false){
            self::setCliParams();
        }
        $urlParams=Pokelio_Global::getVar('CLI_PARAMS');
        if(isset($urlParams[$name])){
            $value=$urlParams[$name];
        }
        return $value;
    }    
    public static function setCliParams(){
        //Process $_SERVER['argv'] array
        $parts=$_SERVER['argv'];
        
        //0 element is the name of the script itself, so we start at 1
        $params=array();
        for($i=1;$i<sizeof($parts);$i++){
            $subParts=explode("=",$parts[$i]);
            if(isset($subParts[1])){
                $params[$subParts[0]]=$subParts[1];
            }else{
                $params[$subParts[0]]='';
            }
        }
        //Initialize the global array to store params/values
        Pokelio_Global::setVar('CLI_PARAMS', $params);  
    }    
}
