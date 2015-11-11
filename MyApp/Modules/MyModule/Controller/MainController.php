<?php

class MyModule_MainController extends Pokelio_ControllerSimple{
    public function __construct() {
        parent::__construct(__FILE__);
    }
    public function hello(){
        //TESTING  
       
        //BaSeMa_Install::execute();
        //var_dump(_::isParamSet('prueba'));
        //Pokelio_Module::installModule('BaSeMa');
        
        //echo BaSeMa_Hash::getUserPasswordHash("aia", "xxxx");
        //var_dump(BaSeMa_Hash::isValidUserPassword("aia","xxxx", "c094f40680135dedeba09b1b4dfd51de8b189ab7"));
        /*
        $m= new BaSeMa_UserModel();
        $res=$m->readUser('aia');
        $user=new BaSeMa_UserEntity();
        $user->id_user='aia';
        $user->email='betuto92@gmail.com';
        */
        
        //$user=new BaSeMa_SPR_BSM_USER_Entity();
        
        //$user=new Bsm_BsmUserModel();
        //$auth=new Bsm_Authentication();
        //var_dump($auth->login('aia', 'passtest01'));
        //$auth->setPassword('aia', 'passtest01');
        /*
        $userData=new Bsm_BsmUser_Entity();
        $userData->id_user='aisa';
        $userData->email='kasjdhkjadsh';
        $userData->name='Hola';
        $userData->password="tachan";
        $userData->status='A';
        $userData->surname="hhhuuu";
        $user->create($userData);
         */
        //$res=$user->listRecords($userCond, true);

        //var_dump($res);
        /*
        $MyM=new CodeGen_ModelGen();
        $modelCode=$MyM->generateModel('Bsm', 'BsmProfile');

        $prof=new Bsm_BsmProfileModel();
        $dat=new Bsm_BsmProfileEntity();
        $dat->profile="test01";
        $dat->status="A";
        $prof->create($dat);
        */
        //echo $this->modulePath;
        //echo "<br />";
        //echo $this->moduleName;
        
        //echo "<pre>$modelCode</pre>";
        $this->view->setPageTitle("This is the title of MyApp");
        //$this->view->nombre="My name";
        //$this->view->setJSVar('nombre', "My name");
        //$this->view->includeJs('Vendors/jQuery/jquery-2.1.4.min.js');
        $this->view->includeCss('Vendors/Google/Fonts/YanoneKaffeesatz/YanoneKaffeesatz.css');
        $this->view->includeCss('Vendors/Google/Fonts/SourceCodePro/SourceCodePro.css');
        $this->view->copyVarsToJSVars();
        
        $this->renderTemplate('Sample');
        //Pokelio_RscServer::serveFile('/var/www/html/Pokelio_Framework/CLTV/Config/Pokelio.json');
        //Pokelio_File::copyDir('/var/www/html/Pokelio_Framework', '/var/www/html/webrsc', true);
        //Pokelio_File::rmDir('/var/www/html/webrsc');
        //echo "kkk";
        //Pokelio_WebResources::deployAllModuleResources();
        Pokelio_WebResources::deployVendors();
        //echo _::getParamValue('prueba');
    }    
    
}