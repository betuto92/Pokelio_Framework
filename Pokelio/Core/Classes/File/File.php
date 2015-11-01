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
}
