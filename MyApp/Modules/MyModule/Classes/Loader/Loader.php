<?php

class MyModule_Loader{
    public static function setLoader(){
        spl_autoload_register('MyModule_Loader::MyModuleLoaderFunction');
    }
    public static function MyModuleLoaderFunction($class){
        echo "Ha llegado al loader con $class";
        die();
    }
}

