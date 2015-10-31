<?php
/*
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Log
 * A class to write the log file
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Log{
    /**
     * Writes a new line in log file
     * 
     * @param string $msg    Message to be writen
     * @param mixed  $level  Severity or identifying tag
     */
    public static function write($msg, $level){
        $level=substr("00000".$level,-5);
        $msg=date('Y-m-d H:i:s')." ($level): ".$msg."\n";
        file_put_contents(Pokelio_Global::getConfig('LOG_FILE'), $msg,FILE_APPEND);
    }
    /**
     * Writes a new line in log file with specified message
     * If requested, the source file and code line number is informed
     * 
     * @param string   $msg     Message to be writen
     * @param boolean  $source  Indicate the invoking file/line 
     */    
    public static function writeInfo($msg, $source=false){
        if(Pokelio_Global::getConfig('LOG_INFO')){
            $dbt = debug_backtrace();
            $dbt=$dbt[0];
            $level="Info.";
            $msg=date('Y-m-d H:i:s')." ($level): ".$msg;
            if($source===true){
                $msg.="(from file ".$dbt['file']." at line ".$dbt['line'].")";
            }        
            $msg.="\n";
            file_put_contents(Pokelio_Global::getConfig('LOG_FILE'), $msg,FILE_APPEND);
        }    
    }    
    /**
     * Echo the specified message and then invokes Pokelio_Log::writeInfo() 
     * If requested, the source file and code line number is informed in log
     * entry, but not displayed
     * 
     * @param string   $msg     Message to be echoed
     * @param boolean  $source  Indicate the invoking file/line 
     */    
    public static function echoWriteInfo($msg, $source=false){
        echo $msg.NL;
        self::WriteInfo($msg, $source);
    }    
}

