<?php
/**
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */

/**
 * Pokelio_Pokelio
 * The main class of Pokelio Framework
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Pokelio{
    private $version;
    /**
     * Set up the environment according to configuration file specifications
     * 
     * @param string  $configPath   The path of the folder containing Pokelio.json configuration file
     * @param string  $appRealPath  Where the consumer app is
     */
    public function __construct($configPath, $appRealPath){
        //Config
        define('APP_CONFIG_PATH',$configPath);         
        //Check if config file exists
        $configFile=APP_CONFIG_PATH.'/Pokelio.json';
        if(!file_exists($configFile)){
            //Can´t use Pokelio_Error class to raise error here
            die("Pokelio config file [$configFile] not found. Can´t continue.");
        }
        //Set Pokelio path constants
        $this->setPokelioPaths();

        //Set loader function for Pokelio classes
        require POKELIO_CLASSES_PATH.'/Loader/Loader.php';
        Pokelio_Loader::setLoader();
        
        //Load special classes
        require POKELIO_CLASSES_PATH.'/ShortCuts.php';
        
        //Register Pokelio Modules
        //Pokelio_Module::registerModules(POKELIO_MODULES_PATH);
          
        //Set consumer application path constants
        $this->setAppPaths($appRealPath);
        
        //Register App Modules
        //Pokelio_Module::registerModules(APP_MODULES_PATH,true);
        
        //Load configuration file
        Pokelio_Global::loadConfigFile($configFile, 'Pokelio');

        //Set error manager
        Pokelio_Error::setErrorHandler();

        //Set fatal error manager
        Pokelio_Error::setFatalErrorHandler();        
        
        //Disable error reporting as we are managing that
        $phpErrorReport = Pokelio_Global::getConfig('PHP_ERROR_REPORTING', 'Pokelio');
        ini_set('error_reporting', $phpErrorReport);
        
        //Set exception manager
        Pokelio_Exception::setExceptionHandler();
        
        //Set timezone
        date_default_timezone_set(Pokelio_Global::getConfig('TIMEZONE'));
        
        //CallBack
        //Pokelio_Callback::invokeCallback('Pokelio', 'Application', 'endConfiguration');
        
        $this->cliManager();
    }
    /**
     * Stops execution
     * It is a common point to be invoked when we want to stop app
     * 
     * @param string $msg Message to show before terminating
     */
    public static function abort($msg=null){
        if($msg==null){
            $msg='Pokelio Framework has stopped.';
        }
        die($msg.NL);
    }
    /**
     * Pokelio has been initiated from a cli interface (shell, dos), 
     * so let's set up everything for this environment.
     */    
    private function cliManager(){
        //Define a global value to identify cli type session
        define('SESSION_TYPE','CLI');     
        //Define string to make a new line (CR or <br />)
        define('NL', "\r\n");     
        //Define url paths
        define("APP_URL_PATH", null);
        //Start APP
        $this->start();
    }
    /**
     * Invokes App starting point
     */
    private function start(){
        $startClass=_::getParamValue('controller');
        $startMethod=_::getParamValue('action');
        if($startClass==""){
            echo (NL.'Please, specify a controller name controller=MyController'.NL);
            exit;
        }if($startMethod==""){
            echo (NL.'Please, specify an action name action=MyController'.NL);
            exit;
        }else{
            $startClass=$startClass.'Controller';
            $class=new $startClass();
            $class->$startMethod();
        }    
    }
    /**
     * Defines the set of constants for Pokelio file locations
     */
    private function setPokelioPaths(){
        //Pokelio's root folder
        define('POKELIO_ROOT_PATH',realpath(__DIR__.'/../../../'));
        //Core
        define('POKELIO_CORE_PATH',POKELIO_ROOT_PATH.'/Core');
        //DBConnector
        define('POKELIO_DBCONNECTOR_PATH',POKELIO_ROOT_PATH.'/DBConnector');
        //Classes
        define('POKELIO_CLASSES_PATH',POKELIO_CORE_PATH.'/Classes');
        //Modules
        define('POKELIO_MODULES_PATH',POKELIO_ROOT_PATH.'/Modules');
    }
    /**
     * Defines the set of constants for the consumer app file locations
     */
    private function setAppPaths($appRealPath){
        //Apps's root folder
        define('APP_ROOT_PATH',null);
        //Classes
        define('APP_CLASSES_PATH',null);
        //Modules
        define('APP_MODULES_PATH',null);     
        //Templates (header, footer, ... not the module ones)
        define('APP_TEMPLATE_PATH',null);     
        //CallBack
        //Pokelio_Callback::invokeCallback('Pokelio', 'Application', 'endAppPaths');
    }   
}

