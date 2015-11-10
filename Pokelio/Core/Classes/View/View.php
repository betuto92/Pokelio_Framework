<?php
define("POKELIO_RSC_LOCAL",0);
define("POKELIO_RSC_EXTERNAL",1);

class Pokelio_View{
    private $vars=array();
    private $jsVars=array();
    private $pageTitle="";
    public function __construct(){
        $this->vars['rscUrl'] = _::getConfig("WEB_RSC_URL");
        $this->vars['htmlCss']=array();
        $this->vars['htmlJs']=array();
        $this->vars['htmlLang']=_::getConfig('HTML')->lang;
        $this->vars['htmlCharset']=_::getConfig('HTML')->charset;
    }
    public function __set($name, $value) {
        $this->vars[$name]=$value;
    }
    public function setJSVar($name, $value){
        $this->jsVars[$name] = json_encode($value);
    }
    public function copyVarsToJSVars(){
        foreach($this->vars as $key => $value){
            $this->jsVars[$key] = json_encode($value);
        }
    }
    public function getVars(){
        return $this->vars;
    }
    public function getJSVars(){
        return $this->jsVars;
    }    
    public function setPageTitle($title){
        $this->vars['pageTitle']=$title;
    }
    public function setHtmlLang($lang){
        $this->vars['htmlLang']=$lang;
    }
    public function setHtmlCharset($charset){
        $this->vars['htmlCharset']=$lang;
    } 
    public function includeCss($css, $resourceType=POKELIO_RSC_LOCAL){
        if($resourceType==POKELIO_RSC_LOCAL){
            $css=$this->vars['rscUrl'].'/'.$css;
        }
        $this->vars['htmlCss'][]=$css;
    }  
    public function includeJs($js, $resourceType=POKELIO_RSC_LOCAL){
        if($resourceType==POKELIO_RSC_LOCAL){
            $js=$this->vars['rscUrl'].'/'.$js;
        }        
        $this->vars['htmlJs'][]=$js;
    }      
}
