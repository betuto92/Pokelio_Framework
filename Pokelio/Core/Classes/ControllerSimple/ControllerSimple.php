<?php

class Pokelio_ControllerSimple extends Pokelio_ControllerBase{
    private $varStore=null;
    public function __construct($child) {
        parent::__construct($child);
        $this->varStore=array();
    }
    public function __set($name, $value){
        $this->varStore[$name]=$value;
    }
    protected function renderTemplate($templateName){
        //Import variables from varStore
        extract($this->varStore);
        //Initialize ouput buffer
        ob_start();
        //Require template file
        $view=$this->modulePath.'/'.$this->moduleName.'/Template/'.$templateName.'Template.php';
        if(_::getConfig('USE_USYNTAX')){
            $view = Pokelio_uSyntax::view($view,$templateName);
        }
        require $view;
        //Display buffered content and clean buffer
        $output = ob_get_clean();
        echo $output;
    }
}
