<?php
/*
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Module
 * A class to register framework or application modules during application startup
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Module{
    /**
     * Register all modules contained in the specified path
     * 
     * @param string  $modulesPath Path to folder containing modules
     * @param boolean $callback    Specify where to notify when the module has been registered or not 
     */
    public static function registerModules($modulesPath, $callback=false){
        //Get the list of modules at specified path
        $modules = self::listPathModules($modulesPath);
        foreach($modules as $module){
            self::registerModule($modulesPath, $module, $callback);
        }
    }  
    /**
     * Installs a new downloaded or deployed model under POKELIO_MODULES_PATH
     * 
     * @param string $moduleName Name of the module to be installed
     */
    public static function installModule($moduleName){
        //Are installations allowed?
        if(_::getConfig('ALLOW_INSTALLATIONS')===true){
            //Do the module folder exists?
            if(file_exists(POKELIO_MODULES_PATH.'/'.$moduleName)){
                //Do Install.php file exists?
                if(file_exists(POKELIO_MODULES_PATH.'/'.$moduleName.'/Install/Install.php')){
                    //Invoke installation script for module
                    if(is_callable($moduleName."_Install::execute")){
                        $success=call_user_func($moduleName."_Install::execute");
                        if($success==true){
                            self::successInstall($moduleName);
                        }else{
                            self::failedInstall($moduleName);
                        }
                    }else{
                        _::abort("Corrupted Install class of module ".$moduleName);
                    }
                }else{
                    _::abort("Corrupted (or already deployed) module. (Install.php does not exist)");
                }
            }else{
                _::abort("Module folder ".$moduleName." does not exist under ".POKELIO_MODULES_PATH);
            }
        }else{    
            _::abort("Installations are not allowed. Check Pokelio configuration file.");
        }        
    }
    /**
     * Show information once the module has been successfully installed
     * 
     * @param string $moduleName Name of the installed module
     */
    private static function successInstall($moduleName){
        _::echoWriteInfo(NL."Module ".$moduleName." has been succesfully installed.");
        if(is_writable(POKELIO_MODULES_PATH.'/'.$moduleName.'/Install/Install.php')){
            rename(POKELIO_MODULES_PATH.'/'.$moduleName.'/Install/Install.php',POKELIO_MODULES_PATH.'/'.$moduleName.'/Install/backInstall.php');
        }else{
            _::echoWriteInfo("Please, remove or rename Install.php script in order to avoid accidental unwanted reinstallations.");
        }    
    }
    /**
     * Show message of failed installation
     * 
     * @param string $moduleName Name of the installed module
     */    
    private static function failedInstall($moduleName){
        _::echoWriteInfo(NL."Module ".$moduleName." installation failed.");
    }
    /**
     * TODO: Review and decide what we want to register appart from config files
     */
    /**
     * 
     * 
     * @param string   $modulesPath  Path to folder containing the module
     * @param string   $module         
     * @param boolean  $callback       
     * 
     */
    private static function registerModule($modulePath, $module, $callback=false){
        //Load configuration of the module and callBack to notify
        $configFile=APP_CONFIG_PATH.'/'.$module.'.json';
        Pokelio_Global::loadConfigFile($configFile, $module);
        //Does the module contain a class loader?
        $loaderClassFile=$modulePath.'/'.$module.'/Classes/Loader/Loader.php';
        if(file_exists($loaderClassFile)){
            require $loaderClassFile;
            if(is_callable($module.'_Loader::setLoader')){
                call_user_func($module.'_Loader::setLoader');
            }
        }
        //CallBack
        if($callback==true){
            Pokelio_Callback::invokeCallback($module, 'Module', 'moduleRegistered');        
        }
    }
    
    public static function listPathModules($path){
        //Get the list of directory modules
        $modules=array();
        $items = scandir($path);
        foreach($items as $module){
            if(substr($module,0,1)!=='.'){
               $modules[]=$module;
            }
        }
        return $modules;
    }
    public static function listAppModules(){
        //Get the list of Application modules
        $modules=self::listPathModules(APP_MODULES_PATH);
        return $modules;
    }
    public static function listPokelioModules(){
        //Get the list of Pokelio modules
        $modules=self::listPathModules(POKELIO_MODULES_PATH);
        return $modules;
    }
}

