<?php

class Pokelio_ControllerBase{
    private $child=null;
    protected $moduleName=null;
    protected $modulePath=null;
    protected $isPokelioModule=null;
    protected $rscUrl=null;
    
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
        if($this->modulePath==POKELIO_MODULES_PATH){
            $this->isPokelioModule==true;
            $this->rscUrl=_::getConfig("WEB_RSC_URL").'/Pokelio/'.$this->moduleName;
        }else{
            $this->isPokelioModule==false;
            $this->rscUrl=_::getConfig("WEB_RSC_URL").'/App/'.$this->moduleName;
        }               
    }
}

