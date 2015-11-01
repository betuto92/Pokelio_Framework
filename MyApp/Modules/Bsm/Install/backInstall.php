<?php

class BaSeMa_Install{
    public static function execute(){
        $success=false;
        _::echoWriteInfo("Bsm installation started...");
        $dbm=new MyMangr_ObjectsModel();
        //Create user table
        if($dbm->tableExists('BsmUser')){
            _::echoWriteInfo("Dropping BsmUser table");
            $dbm->execute("DROP TABLE BsmUser");
        }
        _::echoWriteInfo("Creating BsmUser table");
        $sql="CREATE TABLE BsmUser
              (
                     id_user         VARCHAR    (12)  NOT NULL COMMENT 'User id, like u001, 88124, ...',
                     name            VARCHAR    (60)  NOT NULL COMMENT 'Name of the user',
                     surname         VARCHAR   (120)  NOT NULL COMMENT 'Surname of the user',
                     email           VARCHAR   (120)           COMMENT 'Email account',
                     password        CHAR       (40)           COMMENT 'Password hash',
                     status          CHAR      (100)  NOT NULL COMMENT 'Status: A-Active, D-Deactivated',
                     auth_class      CHAR      (100)  NOT NULL COMMENT 'Class for authentication',
                     auth_method     CHAR        (1)  NOT NULL COMMENT 'Method of Class for authentication',
                     cli_allowed     TINYINT     (1)  NOT NULL COMMENT 'Is the user allowed to use CLI?',
                     web_allowed     TINYINT     (1)  NOT NULL COMMENT 'Is the user allowed to use WEB?',
                     ts_created      TIMESTAMP        NOT NULL COMMENT 'Timestamp of user creation',     
                     ts_last_access  TIMESTAMP                 COMMENT 'Timestamp of user last access',
                     PRIMARY KEY(
                        id_user
                     )
              )";
        $dbm->execute($sql);
        if($dbm->tableExists('BsmUser')==false){
            _::echoWriteInfo("Unable to create BsmUser table. Exiting Bsm install.");
            return $success;
        }else{
            _::echoWriteInfo("Table BsmUser succesfullly created");
        }        
        //Create profile table
        if($dbm->tableExists('BsmProfile')){
            _::echoWriteInfo("Dropping BsmProfile table");
            $dbm->execute("DROP TABLE BsmProfile");
        }
        _::echoWriteInfo("Creating BsmProfile table");
        $sql="CREATE TABLE BsmProfile
              (
                     id_profile      INT        (11)  NOT NULL COMMENT 'Profile identificator',
                     profile         VARCHAR    (60)  NOT NULL COMMENT 'Profile name',
                     status          CHAR        (1)  NOT NULL COMMENT 'Status: A-Active, D-Deactivated',
                     PRIMARY KEY(
                        id_profile
                     )
              )";
        $dbm->execute($sql);
        if($dbm->tableExists('BsmProfile')==false){
            _::echoWriteInfo("Unable to create BsmProfile table. Exiting Bsm install.");
            return $success;
        }else{
            _::echoWriteInfo("Table BsmProfile succesfullly created");
        }        
        
        $success=true;
        return $success;
    }
}

