<?php

class MySQLManager_ExploreController{
    public static function listTables(){
        $om=new MySQLManager_ObjectsModel();
        return $om->books();
    }    
}