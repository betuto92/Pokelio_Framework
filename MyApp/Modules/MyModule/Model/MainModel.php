<?php

class MyModule_MainModel extends Pokelio_MySql_Connector{
    public function __construct() {
        parent::__construct('DB1');
    }
    public function books(){
        $sql="select * from books";
        return $this->executeAndFetchAll($sql);
    }    
}