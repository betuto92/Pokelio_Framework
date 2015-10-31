<?php
/*
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Module
 * A db connector for MySql (or MariaDB) Database Server
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_MySql_Connector{
    protected $connection=null;
    /**
     * Construct method where configuration is applied
     * @param string $dbIdent  Identifier of connection parameters section in config file
     */    
    public function __construct($dbIdent){  
        $connData=  Pokelio_Global::getConfig('DATABASES', 'Pokelio')->$dbIdent;
        try{   
            $this->connection=new PDO("mysql:host=".$connData->HOST.";port=".$connData->PORT.";dbname=".$connData->SCHEMA, $connData->USER, $connData->PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //}elseif(DBTYPE=="mssql"){
            //    parent::__construct("mssql:host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME, DBUSR, DBPWD);
            //    parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
        }catch(PDOException $e){
            trigger_error("Error connecting to database. (".$e->getMessage().")");
        } 
    }         
    /**
     * Returns the result (affected rows) of executing a NON SELECT SQL 
     * 
     * @param string $sql         SQL to be executed
     * @param string $parameters  Array of values to be inserted in ? places
     * @return integer
     */
    public function execute($sql,$parameters=array()){
        try{
            $sth=$this->connection->prepare($sql);
            $result=$sth->execute($parameters);         
            return $result;
        }catch(Exception $e){
            trigger_error("Error executing SQL sentence. (".$e->getMessage().")");
            //echo "SQL: ".$sql.NL;
            //var_dump($parameters);
        }
    }
    /**
     * Returns the result (data set of rows) of executing a SELECT SQL 
     * 
     * @param string  $sql         SQL to be executed
     * @param string  $parameters  Array of values to be inserted in ? places
     * @param integer $resType     PDO constant specifying the type of array returned
     * @return array
     */
    public function executeAndFetchAll($sql,$parameters=array(),$restype=PDO::FETCH_BOTH){
        try{
            $sth=$this->connection->prepare($sql);
            $sth->execute($parameters);
            $result=$sth->fetchAll($restype);
            return $result;
        }catch(Exception $e){
            trigger_error("Error executing SQL sentence. (".$e->getMessage().")");
            //echo "SQL: ".$sql.NL;
            //var_dump($parameters);
        }
    }    
}

