<?php
/**
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Error
 * A class to manage php errors stuff
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Error{
    /**
     * Sets the error handler function to catch errors
     */
    public static function setErrorHandler(){
        //Set the Pokelio error handler
        set_error_handler('Pokelio_Error::PokelioErrorHandler',E_ALL);
    }
    /**
     * Sets the error handler function to catch fatal errors
     */    
    public static function setFatalErrorHandler(){
        //Set the Pokelio fatal error handler
        register_shutdown_function( "Pokelio_Error::PokelioFatalErrorHandler" );
    }
    /**
     * Resets the error handler and restores the php default one
     */    
    public static function restoreErrorHandler(){
        //Restore the php engine error handler
        set_error_handler(null);
    }    
    /**
     * Error manager (non fatal errors)
     * It manages errors and decides what to do based on rules defined in the config file
     * 
     * @param integer $errno      Severity of error
     * @param string  $errstr     Description of error
     * @param string  $errfile    File where the error happened
     * @param integer $errline    Line of file where the error happened
     * @param array   $errcontext Context of error. Additional info.
     * 
     * This function is not invoked by the app. Instead of that, PHP interpreter invokes it
     * each time an error occurs
     */
    public static function PokelioErrorHandler($errno, $errstr, $errfile, $errline, $errcontext){
        //Get the error handling rules from configuration array
        $errorRules = Pokelio_Global::getConfig('ERROR_HANDLING_RULES', 'Pokelio');
        //Should we Inform to user?
        if($errorRules->$errno->I && $errorRules->all->I){
            $text = self::getErrorPage($errno, $errstr, $errfile, $errline, $errcontext);
            if(SESSION_TYPE=='WEB'){
                ob_clean();
                echo "<pre>".htmlentities($text)."</pre>";
            }else{
                echo $text;
            }
        }
        //Should we write to log file?
        if($errorRules->$errno->L && $errorRules->all->L){
            Pokelio_Log::write($errno." ".$errstr." ".$errfile." ".$errline, $errno);
        }        
        //Should we Stop execution?
        if($errorRules->$errno->S && $errorRules->all->S){
            Pokelio_Application::abort();
        }
        //Send error to App just in case we need to process it there
        $errorData=array();
        $errorData['errno']=$errno;
        $errorData['errstr']=$errstr;
        $errorData['errfile']=$errfile;
        $errorData['errline']=$errline;
        $errorData['errcontext']=$errcontext;        
        Pokelio_Callback::invokeCallback('Pokelio', 'Error', 'ErrorCaptured', $errorData);
    }
    /**
     * Error manager for fatal errors
     * It manages fatal errors 
     * 
     * This function is not invoked by the app. Instead of that, PHP interpreter invokes it
     * each time a fatal error occurs
     */    
    public static function PokelioFatalErrorHandler(){
        //Get the error handling rules from configuration array
        $errorRules = Pokelio_Global::getConfig('ERROR_HANDLING_RULES', 'Pokelio');        
        $error=null;
        $error=error_get_last();
        //Handle error only in case it exists
        if( $error !== NULL) {
            $errno   = $error["type"];
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr  = $error["message"];

            //Inform to user
           if($errorRules->{1}->I && $errorRules->all->I){
                $text = self::getFatalErrorPage($errno, $errstr, $errfile, $errline);
                if(SESSION_TYPE=='WEB'){
                    ob_clean();
                    echo "<pre>".htmlentities($text)."</pre>";
                }else{
                    echo $text;
                }
            }
            if($errorRules->{1}->I && $errorRules->all->L){
                //Write to log file
                Pokelio_Log::write($errno." ".$errstr." ".$errfile." ".$errline, $errno);
            }
            if($errorRules->{1}->I && $errorRules->all->S){
                //Stop execution?
                Pokelio_Application::abort();
            }
        }    
    }    
    /**
     * Returns a string with the explanatory elements of the error
     * 
     * @param integer $errno      Severity of error
     * @param string  $errstr     Description of error
     * @param string  $errfile    File where the error happened
     * @param integer $errline    Line of file where the error happened
     * @param array   $errcontext Context of error. Additional info.  
     *    
     */
    private static function getErrorPage($errno, $errstr, $errfile, $errline, $errcontext){
        //Compose a page to give extra information about error
        $text="";
        $text.= "An error has ocurred"."\n";
        $text.= "  Severity : ".self::getSeverityTag($errno)." (".$errno.")"."\n";
        $text.= "  Error    : ".$errstr."\n";
        $text.= "  File     : ".$errfile."\n";
        $text.= "  Line     : ".$errline."\n";            
        $text.= self::showCodeLines($errfile, $errline);
        //Backtrace
        $bTrace = debug_backtrace();
        for($i=2;$i<sizeof($bTrace);$i++){
            if(isset($bTrace[$i]['file']) && isset($bTrace[$i]['line'])){
                $text.= "\n";
                $text.= "Invoked by"."\n";
                $text.= "  File     : ".$bTrace[$i]['file']."\n";
                $text.= "  Line     : ".$bTrace[$i]['line']."\n";
                $text.=self::showCodeLines($bTrace[$i]['file'], $bTrace[$i]['line']);
                $text.= "\n";
            }
        }        
        return $text;
    }
    /**
     * Returns a string with the explanatory elements of the error
     * 
     * @param integer $errno      Severity of error
     * @param string  $errstr     Description of error
     * @param string  $errfile    File where the error happened
     * @param integer $errline    Line of file where the error happened  
     *    
     */    
    private static function getFatalErrorPage($errno, $errstr, $errfile, $errline){
        //Compose a page to give extra information about error
        $text="";
        $text.= "A fatal error has ocurred"."\n";
        $text.= "  Type     : ".self::getSeverityTag($errno)." (".$errno.")"."\n";
        $text.= "  Error    : ".$errstr."\n";
        $text.= "  File     : ".$errfile."\n";
        $text.= "  Line     : ".$errline."\n";            
        $text.= self::showCodeLines($errfile, $errline);
        return $text;
    }
    /**
     * Based on a file and a line number, it gets the code before and after
     * and returns a formatted string with the surrounding code of the error line
     * 
     * @param string  $file    File where the error happened
     * @param integer $line    Line of file where the error happened
     */
    private static function showCodeLines($file, $line){
        //Get a partial list of code where the error has ocurred
        $text="";
        $fileContent = file_get_contents($file);
        $lines = explode("\n",$fileContent);
        $nLines = Pokelio_Global::getConfig("ERROR_SHOW_CODE_LINES", 'Pokelio');
        $startLine=$line-$nLines;
        if($startLine<1){
            $startLine=1;
        }
        $endLine=$line+$nLines;
        if($endLine>sizeof($lines)){
            $endLine=sizeof($lines);
        }
        $text.= "  Code:"."\n";
        for($iLine=$startLine;$iLine<=$endLine;$iLine++){
            if($iLine==$line){
                $text.= "  !!!----> ";
            }else{
                $text.= "           ";
            }
            $text.= substr("    ".$iLine,-4);
            $text.= "  ";
            $text.= str_replace("\n","",$lines[$iLine-1])."\n";
        }
        return $text;
    }
    /**
     * Returns the tag corresponding to a severity level
     * 
     * @param integer $severity Severity of error
     */
    public static function getSeverityTag($severity){
        $tag="Unknown";
        $tags=array();
        $tags[1]='E_ERROR';
        $tags[2]='E_WARNING';
        $tags[4]='E_PARSE';
        $tags[8]='E_NOTICE';
        $tags[16]='E_CORE_ERROR';
        $tags[32]='E_CORE_WARNING';
        $tags[64]='E_COMPILE_ERROR';
        $tags[128]='E_COMPILE_WARNING';
        $tags[256]='E_USER_ERROR';
        $tags[512]='E_USER_WARNING';
        $tags[1024]='E_USER_NOTICE';
        $tags[2048]='E_STRICT';
        $tags[4096]='E_RECOVERABLE_ERROR';
        $tags[8192]='E_DEPRECATED';
        $tags[16384]='E_USER_DEPRECATED';
        if(isset($tags[$severity])){
            $tag = $tags[$severity];
        }
        return $tag;
    }
}
