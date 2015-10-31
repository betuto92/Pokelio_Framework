<?php

class MySQLManager_ObjectsModel extends Pokelio_MySql_Connector{
    private $schema=null;
    public function __construct() {
        $connName=Pokelio_Global::getConfig('CONNECTION_ID', 'MySQLManager');
        parent::__construct($connName);
        $this->schema=Pokelio_Global::getConfig('DATABASES', 'Pokelio')->$connName->SCHEMA;
    }
    public function listSchemaTables(){
        $sql="SELECT *
                FROM information_schema.tables 
                WHERE table_schema = ?";
        $parameters=array($this->schema);
        return $this->executeAndFetchAll($sql,$parameters);
    } 
    public function listTableColumns($tableName){
        $sql="SELECT *
                FROM information_schema.columns 
                WHERE table_schema = ?
                  AND table_name = ?
                  ORDER BY ORDINAL_POSITION";
        $parameters=array($this->schema, $tableName);
        return $this->executeAndFetchAll($sql,$parameters);
    }     
    public function tableExists($tableName){
        $existe = false;
        $sql="SELECT count(*) AS table_exists
                FROM information_schema.tables 
                WHERE table_schema = ?
                AND table_name = ?";
        $parameters=array($this->schema, $tableName);
        $res = $this->executeAndFetchAll($sql, $parameters);
        if($res[0]['table_exists']>0){
            $existe = true;
        }
        return $existe;
    }     
}