<?php
/**
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Callback
 * A class that supports the callbacks performed by Pokelio at certain points
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Callback{
    /**
     * Invokes an static method of a class of the consumer App
     * 
     * @param string $module The folder inside CallBacks containing the class
     * @param string $class  The class containing the method to be invoked
     * @param string $event  The method that will be invoked
     * @param mixed  $data   Data that can be set to the method
     * 
     */
    public static function invokeCallback($module, $class, $event, $data=null){
        if(file_exists(APP_ROOT_PATH.'/CallBacks/'.$module.'/'.$class.'.php')){
            include_once APP_ROOT_PATH.'/CallBacks/'.$module.'/'.$class.'.php';
            $className=$module.'_CB_'.$class;
            if(method_exists($className,$event)){
                $className::$event($data);
            }
        }
    }
}
