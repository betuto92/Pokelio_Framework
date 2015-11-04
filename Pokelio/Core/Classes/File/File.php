<?php
/**
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_File
 * A class with methods and utilities to handle files
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_File{
    /**
     * Wrapper for file_put_contents() which includes a chmod() to set file permissions
     * @param type $filename
     * @param type $data
     * @param type $flags
     * @param type $context
     */
    public static function writeFile($filename, $data, $flags=0, $context=null){
        file_put_contents($filename, $data, $flags, $context);
        $permissions=  Pokelio_Global::getConfig('CREATED_FILE_PERMISSIONS', 'Pokelio');
        $permissions=intval($permissions,8);
        chmod($filename, $permissions);
    }
    /**
     * Wrapper for file_get_contents() just to 
     * @param type $filename
     * @param type $use_include_path
     * @param type $context
     * @param type $offset
     * @param type $maxlen
     */    
    public static function readFile($filename, $use_include_path=false, $context=null, $offset=-1, $maxlen=null){
        $content = file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
        return $content;
    }    
    public static function getFileExtension($filename){
        $ext=false;
        if(strpos($filename,".")!==false){
            $ext = strtolower(end(explode('.', $filename)));
        }
        return $ext;
    }
    public static function makedir($dir){
        $permissions=  Pokelio_Global::getConfig('CREATED_FILE_PERMISSIONS', 'Pokelio');
        $permissions=intval($permissions,8);
        
        if(!file_exists($dir)){
            mkdir($dir);
        }        
    }
    public static function copyDir($srcDir, $trgDir, $cleanFirst=false){
        $permissions=  Pokelio_Global::getConfig('CREATED_FILE_PERMISSIONS', 'Pokelio');
        $permissions=intval($permissions,8);
        if($cleanFirst==true && file_exists($trgDir)){
            self::rmDir($trgDir);
        }
        Pokelio_File::makedir($trgDir);
        
        $entries = scandir($srcDir);
        foreach($entries as $entry){
            if(substr($entry,0,1)!='.'){
                $pathEntry=$srcDir.'/'.$entry;
                if(is_file($pathEntry)){
                    copy($pathEntry, $trgDir.'/'.$entry);
                }
                if(is_dir($pathEntry)){
                    Pokelio_File::copyDir($pathEntry, $trgDir.'/'.$entry);
                }
                chmod($trgDir.'/'.$entry, $permissions);
            }
        }
    }
    public static function rmDir($dir){
        $entries = scandir($dir);
        foreach($entries as $entry){
            if(substr($entry,0,1)!='.'){
                $pathEntry=$dir.'/'.$entry;
                if(is_file($pathEntry)){
                    unlink($pathEntry);
                }
                if(is_dir($pathEntry)){
                    Pokelio_File::rmDir($pathEntry);
                    rmdir($pathEntry);
                }
            }
        }
    }
}
