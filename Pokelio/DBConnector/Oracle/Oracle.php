<?php
/*
 * Pokelio PHP Framework (2015)
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * Pokelio_Module
 * A db connector for Oracle Database Server
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
class Pokelio_Oracle_Connector{
    protected $connection=null;
    /**
     * Construct method where configuration is applied
     * @param string $dbIdent  Identifier of connection parameters section in config file
     */    
    public function __construct($dbIdent){  
        $connData=  Pokelio_Global::getConfig('DATABASES', 'Pokelio')->$dbIdent;
        $this->connection = oci_connect($connData->USER, $connData->PASSWORD, $connData->DSN); 
        if (!$this->connection) {
            $e = oci_error();
            trigger_error("Error connecting to database.".NL.htmlentities($e['message'], ENT_QUOTES).NL);
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
            $sth=oci_parse($this->connection,$sql);
            oci_execute($sth);         
        }catch(Exception $e){
            trigger_error("Error executing SQL sentence.".NL.$e->getMessage());
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
            $sth=oci_parse($this->connection,$sql);
            oci_execute($sth);  
            while ($row = oci_fetch_array($sth, OCI_ASSOC+OCI_RETURN_NULLS)) {
                $result[]=$row;
            }
            return $result;
        }catch(Exception $e){
            trigger_error("Error executing SQL sentence.".NL.$e->getMessage());
            //echo "SQL: ".$sql.NL;
            //var_dump($parameters);
        }
    } 
}

