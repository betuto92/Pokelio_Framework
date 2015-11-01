<?php
/*
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Exception
 * A class to define and set the main framework class loader
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Loader{
    /**
     * Sets the class loader function
     */     
    public static function setLoader(){
        spl_autoload_register('Pokelio_Loader::PokelioAutoloader');
    }  
    /**
     * Class loader
     * Based on $class determines where the file containing the class is 
     * and loads it
     * 
     * @param string $class Name of the class being instantiated
     * 
     * This function is not invoked by the app. Instead of that, PHP interpreter 
     * invokes it each time a non previously loaded class is instantiated
     */     
    public static function PokelioAutoloader($class){
        if(strpos($class,'_')!==false){
            $parts=explode('_',$class);
            $collection=$parts[0];
            $className=$parts[1];
            $type="";
            if(isset($parts[2])){
                $type=$parts[2];
            }
            switch ($collection){
                //Pokelio Class
                case 'Pokelio':
                    if($type==""){
                        $classFilename=POKELIO_CLASSES_PATH.'/'.$className.'/'.$className.'.php';
                    }else{
                        switch($type){
                            case 'Connector':
                                $classFilename=POKELIO_DBCONNECTOR_PATH.'/'.$className.'/'.$className.'.php';
                                break;
                            default:
                                $classFilename=POKELIO_CLASSES_PATH.'/'.$className.'/'.$className.'.php';
                                break;
                        }
                    }    
                    break;
                //Application Class
                case 'App':
                    $classFilename=APP_CLASSES_PATH.'/'.$className.'/'.$className.'.php';
                    break;
                default:
                    //Module elements
                    //Look for the module folder (Pokelio or App module?)
                    if(file_exists(APP_MODULES_PATH.'/'.$collection)){
                        $modulePath=APP_MODULES_PATH.'/'.$collection;
                    }elseif(file_exists(POKELIO_MODULES_PATH.'/'.$collection)){
                        $modulePath=POKELIO_MODULES_PATH.'/'.$collection;
                    }else{
                        trigger_error("Can't find $collection");
                    }
                    //Determine if its a Model, a Controller, a Class or a installer script
                    if(substr($className,-5)=='Model'){
                        $classFilename=$modulePath.'/Model/'.$className.'.php';
                    }elseif(substr($className,-6)=='Entity'){
                        $classFilename=$modulePath.'/Model/'.substr($className,0,-6).'Entity.php';    
                    }elseif(substr($className,-10)=='Controller'){
                        $classFilename=$modulePath.'/Controller/'.$className.'.php';
                    }elseif(substr($className,-7)=='Install'){
                        $classFilename=$modulePath.'/Install/'.$className.'.php';
                    }else{
                        $classFilename=$modulePath.'/Classes/'.$className.'/'.$className.'.php';
                    }
                    break;
            }
            //Load the class file or trigger an error
            if(file_exists($classFilename)){
                require $classFilename;
            }else{
                trigger_error("Unable to find file for required class at $classFilename ($class)");
            }
        }
    }  
}

