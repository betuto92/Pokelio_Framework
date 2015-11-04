<?php

class Pokelio_WebResources{
    public static function deployModuleResources($moduleName){
        $deployed=false;
        $webRscPath=  realpath(_::getConfig("WEB_RSC_PATH"));

        if(in_array($moduleName,  Pokelio_Module::listAppModules())){
            if(file_exists(APP_MODULES_PATH.'/'.$moduleName.'/rsc')){
                Pokelio_File::makedir($webRscPath.'/App');
                Pokelio_File::copyDir(APP_MODULES_PATH.'/'.$moduleName.'/rsc', $webRscPath.'/App/'.$moduleName, true);
                $deployed=true;
            }    
        }
        if(in_array($moduleName,  Pokelio_Module::listPokelioModules())){
            if(file_exists(POKELIO_MODULES_PATH.'/'.$moduleName.'/rsc')){
                Pokelio_File::makedir($webRscPath.'/Pokelio');
                Pokelio_File::copyDir(POKELIO_MODULES_PATH.'/'.$moduleName.'/rsc', $webRscPath.'/Pokelio/'.$moduleName, true);
                $deployed=true;
            }
        }
    }
    public static function deployAllAppModuleResources(){
        foreach(Pokelio_Module::listAppModules() as $moduleName){
            self::deployModuleResources($moduleName);
        }
    }
    public static function deployAllPokelioModuleResources(){
        foreach(Pokelio_Module::listPokelioModules() as $moduleName){
            self::deployModuleResources($moduleName);
        }
    }
    public static function deployAllModuleResources(){
        self::deployAllAppModuleResources();
        self::deployAllPokelioModuleResources();
    }
}
