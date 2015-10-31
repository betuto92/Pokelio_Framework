<?php
/*
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Exception
 * A class to manage sessions
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Session{
    /**
     * Starts a new session
     * Name of the session is specified in config file by SESSION_ID
     */
    public static function start(){
        //Get the session identifier from config file
        $sessionId = Pokelio_Global::getConfig('SESSION_ID', 'Pokelio');
        //Start session
        session_name($sessionId);
        @session_start();  
    }
    /**
     * Sets the value of a session variable
     * 
     * @param string $name  Name of the variable
     * @param mixed  $value Value to be assigned to the variable
     */
    public static function setVariable($name, $value){
        if(self::isSessionStarted()==true){
            $_SESSION[$name]=$value;
        }
    }
    /**
     * Returns the value of the specified variable
     * 
     * @param string $name  Name of the variable
     * @return mixed
     */
    public static function getVariable($name){
        $ret=null;
        if(self::isSessionStarted()==true){
            if(isset($_SESSION[$name])){
                $ret=$_SESSION[$name];
            }
        }
        return $ret;
    }    
    /**
     * Finalizes (destroyes) the current session
     */
    public static function end(){
        if(self::isSessionStarted()==true){
            session_destroy();
        }    
    }

    /**
     * Returns the status of the session (active or not)
     * @return boolean
     */
    private static function isSessionStarted(){
        $status=true;
        if(phpversion()<'5.4.0'){
            if(session_id()==''){
                $status=false;
            }
        }else{
            if(session_status()==PHP_SESSION_NONE){
                $status=false;
            }
        }
        return $status;
    }    
}

