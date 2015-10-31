<?php
/**
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Exception
 * A class to manage code exceptions
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Exception{  
    /**
     * Sets the exception handler function to catch exceptions
     */    
    public static function setExceptionHandler(){
        //Set the Pokelio exception handler
        set_exception_handler('Pokelio_Exception::PokelioExceptionHandler');
    }    
    /**
     * Exception manager 
     * It manages exceptions and decides what to do based on rules defined in the config file
     * 
     * @param Exception $exception Instance of Exception
     * 
     * This function is not invoked by the app. Instead of that, PHP interpreter invokes it
     * each time an exception occurs
     */    
    public static function PokelioExceptionHandler(Exception $exception){
        //Get the error handling rules from configuration array
        $exceptionRule = Pokelio_Global::getConfig('EXCEPTION_HANDLING_RULE', 'Pokelio');
        //Should we Inform to user?
        if($exceptionRule->I==true){
            $text = self::getExceptionPage($exception);
            if(SESSION_TYPE=='WEB'){
                echo "<pre>".htmlentities($text)."</pre>";
            }else{
                echo $text;
            }
        }
        //Should we write to log file?
        if($exceptionRule->L==true){
            Pokelio_Log::write("Exception: ".$exception->getMessage()." - ".$exception->getFile()." (".$exception->getLine().")","Excep");
        }        
    }
    /**
     * Returns a formatted string with the explanatory elements of the exception
     * 
     * @param Exception $exception Instance of Exception
     *    
     */    
    private static function getExceptionPage(Exception $exception){
        $text="";
        $text.= "An exception has ocurred"."\n";
        $text.= "  Message  : ".$exception->getMessage()."\n";
        $text.= "  File     : ".$exception->getFile()."\n";
        $text.= "  Line     : ".$exception->getLine()."\n";            
        $text.= self::showCodeLines($exception->getFile(), $exception->getLine());
        //Backtrace
        $bTrace = $exception->getTrace();
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
     * Based on a file and a line number, it gets the code before and after
     * and returns a formatted string with the surrounding code of the exception
     * line
     * 
     * @param string  $file    File where the exception happened
     * @param integer $line    Line of file where the exception happened
     */    
    private static function showCodeLines($file, $line){
        $text="";
        $fileContent = file_get_contents($file);
        $lines = explode("\n",$fileContent);
        $nLines = Pokelio_Global::getConfig("EXCEPTION_SHOW_CODE_LINES", 'Pokelio');
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
}
