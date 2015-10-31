<?php

class MyModule_MainController{
    public static function hello(){
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
        /*
        $user=new Bsm_BsmUserModel();
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
        
        $MyM=new CodeGen_ModelGen();
        $modelCode=$MyM->generateModel('Bsm', 'BsmUser');

        //echo "<pre>$modelCode</pre>";
    }    
    
}