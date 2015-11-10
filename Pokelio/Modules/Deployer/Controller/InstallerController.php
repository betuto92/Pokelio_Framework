<?php

class Deployer_InstallerController{
    public function Install(){
        $appPath = _::getParamValue('appPath');
        if($appPath==""){
            echo "Pleasy specify an absolute path for the new application \"appPath=/xxx/xxx/xxx\"".NL;
            die();
        }
        $appName = _::getParamValue('appName');
        if($appName==""){
            echo "Pleasy specify a valid name for the new application \"appName=MyNewApp\"".NL;
            die();
        }
        $fullPath=$appPath.'/'.$appName;
        if(!file_exists($appPath)){
            echo "The specified app path ($appPath) doesn't exist. Can't continue.".NL;
            die();
        }
        if(!file_exists($appPath)){
            echo "The specified app path ($appPath) doesn't exist. Can't continue.".NL;
            die();
        }
        if(file_exists($fullPath)){
            echo "The app folder ($appName) exists below app path ($appPath). Please, remove it or create an app with a different name.".NL;
            die();
        }
        if(!is_writable($appPath)){
            echo "Can't write into specified folder ($appPath).".NL;
            die();
        }
        //Installation begins here
        //Create folder for application
        Pokelio_file::makedir($fullPath);
        //Create CLTV folder
        //...
    }
}

