<?php

class Pokelio_ControllerBase{
    private $child=null;
    protected $moduleName=null;
    protected $modulePath=null;
    public function __construct($child) {
        $this->child=$child;
        $this->extractParts();
    }
    
    private function extractParts(){
        $path=str_replace('\\','/',$this->child);
        $parts=explode("/",$path);
        $trailPart=strlen($parts[sizeof($parts)-1])
                  +strlen($parts[sizeof($parts)-2])
                  +strlen($parts[sizeof($parts)-3])+3;
        $this->modulePath=substr($this->child,0,-$trailPart);
        $this->moduleName=$parts[sizeof($parts)-3];
    }
}

