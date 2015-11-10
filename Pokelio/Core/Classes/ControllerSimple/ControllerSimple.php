<?php

class Pokelio_ControllerSimple extends Pokelio_ControllerBase{
    /**
     *
     * @var Pokelio_View $view
     */
    public $view=null;
    public function __construct($child) {
        parent::__construct($child);
        $this->view=new Pokelio_View();
    }
    protected function renderTemplate($templateName, $header=null, $footer=null){
        //Get, if necessary, the default header and/or footer 
        if($header==null){
            $header = _::getConfig('DEFAULT_HEADER_TEMPLATE_NAME');
        }
        if($footer==null){
            $footer = _::getConfig('DEFAULT_FOOTER_TEMPLATE_NAME');
        }
        //Import variables from varStore
        extract($this->view->getVars());
        //Initialize ouput buffer
        ob_start();
        //Require header file if specified
        if($header!=""){
            $templateSrc=APP_TEMPLATE_PATH.'/'.$header.'Template.php';
            if(_::getConfig('USE_USYNTAX')){
                $view = Pokelio_uSyntax::view($templateSrc,$header, 'App');
            }
            require $view;
        }    
        //Require JSEnabler if JSVar array contains variables
        $jsVars=$this->view->getJSVars();
        if(sizeof($jsVars)>0){
            $JSEnabler = APP_TEMPLATE_PATH.'/JSEnablerTemplate.php';
            require $JSEnabler;
        }
        //Require template file
        $template=_::getConfig('APP_VIEW_PATH').'/'.$templateName.'Template.php';
        $templateSrc=$this->modulePath.'/'.$this->moduleName.'/Template/'.$templateName.'Template.php';
        if(_::getConfig('USE_USYNTAX')){
            $view = Pokelio_uSyntax::view($templateSrc,$templateName, $this->moduleName);
        }
        require $view;

        //Require footer file if specified
        if($footer!=""){
            $templateSrc=APP_TEMPLATE_PATH.'/'.$footer.'Template.php';
            if(_::getConfig('USE_USYNTAX')){
                $view = Pokelio_uSyntax::view($templateSrc,$footer, 'App');
            }
            require $view;        
        }    
        
        //Display buffered content and clean buffer
        $output = ob_get_clean();
        echo $output;
    }
}

