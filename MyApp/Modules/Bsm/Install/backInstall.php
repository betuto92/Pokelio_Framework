<?php

class BaSeMa_Install{
    public static function execute(){
        $success=false;
        _::echoWriteInfo("BaSeMa installation started...");
        $dbm=new MyMangr_ObjectsModel();
        //Create user table
        if($dbm->tableExists('SPR_BSM_USER')){
            _::echoWriteInfo("Dropping SPR_BSM_USER table");
            $dbm->execute("DROP TABLE SPR_BSM_USER");
        }
        _::echoWriteInfo("Creating SPR_BSM_USER table");
        $sql="CREATE TABLE SPR_BSM_USER
              (
                     id_user         VARCHAR    (12)  NOT NULL COMMENT 'User id, like u001, 88124, ...',
                     name            VARCHAR    (60)  NOT NULL COMMENT 'Name of the user',
                     surname         VARCHAR   (120)  NOT NULL COMMENT 'Surname of the user',
                     email           VARCHAR   (120)           COMMENT 'Email account',
                     password        CHAR       (40)           COMMENT 'Password hash',
                     status          CHAR        (1)  NOT NULL COMMENT 'Status: A-Active, D-Deactivated',
                     ts_created      TIMESTAMP        NOT NULL COMMENT 'Timestamp of user creation',     
                     ts_last_access  TIMESTAMP                 COMMENT 'Timestamp of user last access',
                     PRIMARY KEY(
                        id_user
                     )
              )";
        $dbm->execute($sql);
        if($dbm->tableExists('SPR_BSM_USER')==false){
            _::echoWriteInfo("Unable to create SPR_BSM_USER table. Exiting BaSeMa install.");
            return $success;
        }else{
            _::echoWriteInfo("Table SPR_BSM_USER succesfullly created");
        }        
        
        
        $success=true;
        return $success;
    }
}

