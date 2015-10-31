<?php

class Codegen_ModelGen{
    public static function generateModel($module, $table){
        if(!file_exists(APP_MODULES_PATH.'/'.$module)){
            trigger_error("Module $module not found under ".APP_MODULES_PATH);
        }
        if(!is_writable(APP_MODULES_PATH.'/'.$module)){
            trigger_error("Unable to write into module folder [".APP_MODULES_PATH.'/'.$module."]");
        }      
        if(!file_exists(APP_MODULES_PATH.'/'.$module.'/Model')){
            mkdir(APP_MODULES_PATH.'/'.$module.'/Model');
        }
        $modelCode="<?php\n";
        $maxNameLength=0;
        $priKey=array();
        $myModel=new MySQLManager_ObjectsModel();
        $columns=$myModel->listTableColumns($table);
        if(sizeof($columns)==0){
            trigger_error("No table $table found or the table has no column. No code generated.");
        }
        foreach($columns as $column){
            if(strlen($column['COLUMN_NAME'])>$maxNameLength){
                $maxNameLength = strlen($column['COLUMN_NAME']);
            }
            if($column['COLUMN_KEY']=='PRI'){
                $priKey[]=array('name'=>$column['COLUMN_NAME'], 
                                'type'=>self::getPhpType($column['DATA_TYPE']),
                                'desc'=>$column['COLUMN_COMMENT']);
            }
        }
        if(sizeof($priKey)==0){
            trigger_error("There's no primary key defined for table $table. No code generated.");
        }
        $introCode = self::generateIntro($module, $table);
        $readCode = self::generateReadCode($module, $table, $columns, $maxNameLength, $priKey);
        $constructCode = self::generateConstructCode($module, $table, $columns, $maxNameLength, $priKey);
        $listCode = self::generateListCode($module, $table, $columns, $maxNameLength, $priKey);
        $createCode = self::generateCreateCode($module, $table, $columns, $maxNameLength, $priKey);
        $updateCode = self::generateUpdateCode($module, $table, $columns, $maxNameLength, $priKey);
        $deleteCode = self::generateDeleteCode($module, $table, $columns, $maxNameLength, $priKey);   
        $functionCode = self::generateFunctionCode($module, $table, $columns, $maxNameLength, $priKey);
        $entityCode = self::generateEntityClass($module, $table, $columns, $maxNameLength);
        
        $modelCode.=$introCode;
        $modelCode.="class ".$module."_".$table."Model extends Pokelio_MySql_Connector{ \n";
        $modelCode.=$constructCode;
        $modelCode.=$readCode;
        $modelCode.=$listCode;
        $modelCode.=$createCode;
        $modelCode.=$updateCode;
        $modelCode.=$deleteCode;
        $modelCode.=$functionCode;        
        $modelCode.="} \n\n";
        $modelCode.=$entityCode;
        file_put_contents(APP_MODULES_PATH.'/'.$module.'/Model/'.$table.'Model.php',$modelCode);
    } 
    private static function generateIntro($module, $table){
        $intro="";
        $intro.="/** \n";
        $intro.=" *  ".$module."_".$table."Model\n";
        $intro.=" *  A class with basic data manipulation methods for table $table\n";
        $intro.=" *  \n";
        $intro.=" *  Code generated by Pokelio Codegen Module on ".date('r')."\n";
        $intro.=" *  \n";
        $intro.=" */ \n";
        return $intro;
    }    
    private static function generateConstructCode($module, $table, $columns, $maxNameLength, $priKey){
        $code="";
        $code.="    /** \n";
        $code.="     * Invokes the parent __construct method passing connection id \n";
        $code.="     *  \n";
        $code.="     */ \n";
        $code.="     public function __construct() {\n";
        $code.='         $connName=Pokelio_Global::getConfig("CONNECTION_ID", "'.$module.'");'."\n";
        $code.='         parent::__construct($connName);'."\n";
        $code.='     }'."\n";
        
        return $code;
    }
    private static function generateReadCode($module, $table, $columns, $maxNameLength, $priKey){
        $priKeyVars = self::getPrimaryKeyVars($priKey);
        $code="";
        $code.="    /** \n";
        $code.="     * Reads a record identified by ".$priKeyVars." \n";
        $code.="     *  \n";
        foreach($priKey as $column){
            $code.="     * @param ".$column['type']." \$".$column['name']." <i>".$column['desc']."</i>\n";
        }
        $code.="     *  \n";
        $code.="     * @return ".$module."_".$table."_Entity \n";
        $code.="     *  \n";
        $code.="     */ \n";
        $code.="     public function read(".$priKeyVars."){\n";
        $code.='         $sql = "SELECT * '."\n";
        $code.='                 FROM '.$table."\n";
        $i=0;
        foreach($priKey as $column){
            $i++;
            if($i==1){
                $code.='                 WHERE '.$column['name']." = ?";
            }else{
                $code.='                   AND '.$column['name']." = ?";
            }
            if($i < sizeof($priKey)){
                $code.="\n";
            }else{
                $code.="\";\n";
            }
        }
        $code.='         $parameters = array('.$priKeyVars.');'."\n";        
        $code.='         $result = $this->executeAndFetchAll($sql, $parameters);'."\n";        
        $code.='         if(sizeof($result)>0){'."\n";        
        $code.='             $result = $this->arrayToEntity($result[0]);'."\n";        
        $code.='         }else{'."\n";        
        $code.='             $result = false;'."\n";        
        $code.='         }'."\n";        
        $code.='         return $result;'."\n";        
        $code.="     }\n";
        return $code;
    }    
    private static function generateListCode($module, $table, $columns, $maxNameLength, $priKey){
        $code="";
        $code.="    /** \n";
        $code.="     * Lists records that match fields with value of the entity passed \n";
        $code.="     *  \n";
        $code.="     * @param ".$module."_".$table."_Entity \$entity <i>Instance of entity with values</i>\n";
        $code.="     * @param boolean \$rowsResult <i>Result is an array of rows, not an array of entities</i>\n";
        $code.="     *  \n";
        $code.="     * @return array \n";     
        $code.="     */ \n";
        $code.="     public function listRecords(".$module."_".$table."_Entity \$entity, \$rowsResult=false){\n";
        $code.='         $parameters = array();'."\n";         
        $code.='         $sql = "SELECT * '."\n";
        $code.='                 FROM '.$table."\";\n";
        $code.='         $i=0;'."\n";
        $code.='         foreach(get_object_vars($entity) as $key=>$var){'."\n";        
        $code.='             if($var !== null){'."\n";
        $code.='                 $i++;'."\n";
        $code.='                 if($i==1){'."\n";
        $code.='                     $sql.=" WHERE ".$key." = ?"'.";\n";
        $code.='                 }else{'."\n";
        $code.='                     $sql.=" AND ".$key." = ?"'.";\n";
        $code.='                 }'."\n";
        $code.='                 $parameters[] = $var;'."\n";        
        $code.='             }'."\n";
        $code.='         }'."\n";
        $code.='         '."\n";      
        $code.='         $result = $this->executeAndFetchAll($sql, $parameters);'."\n";        
        $code.='         if($rowsResult==false){'."\n";        
        $code.='             foreach($result as $key=>$row){'."\n";        
        $code.='                 $result[$key] = $this->arrayToEntity($row);'."\n";        
        $code.='             }'."\n";        
        $code.='         }'."\n";        
        $code.='         return $result;'."\n";        
        $code.="     }\n";
        return $code;
    }    
    private static function generateCreateCode($module, $table, $columns, $maxNameLength, $priKey){
        $cols="";
        $vals="";
        foreach($columns as $column){
            $cols.=$column['COLUMN_NAME'].", ";
            $vals.="?, ";
        }
        $cols=substr($cols,0,-2);
        $vals=substr($vals,0,-2);

        $code="";
        $code.="    /** \n";
        $code.="     * Creates a new record with values of the entity passed \n";
        $code.="     *  \n";
        $code.="     * @param ".$module."_".$table."_Entity \$entity <i>Instance of entity with values</i>\n";
        $code.="     *  \n";
        $code.="     */ \n";
        $code.="     public function create(".$module."_".$table."_Entity \$entity){\n";
        $code.='         $parameters = array();'."\n";         
        $code.='         $sql = "INSERT INTO '.$table."\";\n";
        $code.='         $sql.= " ('.$cols.')";'."\n";
        $code.='         $sql.= " VALUES ('.$vals.')";'."\n";
        foreach($columns as $column){
            $code.='         $parameters[]= $entity->'.$column['COLUMN_NAME'].';'."\n";
        }   
        $code.='         $result = $this->execute($sql, $parameters);'."\n";               
        $code.='         return $result;'."\n";        
        $code.="     }\n";
        return $code;
    }    
    private static function generateUpdateCode($module, $table, $columns, $maxNameLength, $priKey){
        $code="";
        $code.="    /** \n";
        $code.="     * Updates the record identified by values of the entity passed \n";
        $code.="     *  \n";
        $code.="     * @param ".$module."_".$table."_Entity \$entity <i>Instance of entity with values</i>\n";
        $code.="     *  \n";
        $code.="     */ \n";
        $code.="     public function update(".$module."_".$table."_Entity \$entity){\n";
        $code.='         $parameters = array();'."\n";         
        $code.='         $sql = "UPDATE '.$table." SET \";\n";
        $codeWhere="";
        $codeParam1="";
        $codeParam2="";        
        $i=0;
        $j=0;
        foreach($columns as $column){
            if($column['COLUMN_KEY']!='PRI'){
                $j++;
                //if($j < sizeof($columns)){
                    $code.='         $sql.= "  '.$column['COLUMN_NAME'].' = ?, ";'."\n";
                //}else{
                //    $code.='         $sql.= "  '.$column['COLUMN_NAME'].' = ? ";'."\n";
                //}
                $codeParam1.='         $parameters[] = $entity->'.$column['COLUMN_NAME'].';'."\n";
            }else{
                $i++;
                if($i==1){
                    $codeWhere.='         $sql.= "WHERE '.$column['COLUMN_NAME'].' = ? ";'."\n";
                }else{
                    $codeWhere.='         $sql.= "  AND '.$column['COLUMN_NAME'].' = ? ";'."\n";
                }
                $codeParam2.='         $parameters[] = $entity->'.$column['COLUMN_NAME'].';'."\n";
            }     
        }
        //Remove trailing , from $code
        $code=substr($code,0,-5)." \";\n";

        $code.=$codeWhere;
        $code.=$codeParam1;
        $code.=$codeParam2;
        $code.='         $result = $this->execute($sql, $parameters);'."\n";               
        $code.='         return $result;'."\n";        
        $code.="     }\n";
        return $code;
    }    
    private static function generateDeleteCode($module, $table, $columns, $maxNameLength, $priKey){
        $priKeyVars = self::getPrimaryKeyVars($priKey);
        $code="";
        $code.="    /** \n";
        $code.="     * Deletes the record identified by ".$priKeyVars." \n";
        $code.="     *  \n";
        foreach($priKey as $column){
            $code.="     * @param ".$column['type']." \$".$column['name']." <i>".$column['desc']."</i>\n";
        }
        $code.="     *  \n";
        $code.="     */ \n";
        $code.="     public function delete(".$priKeyVars."){\n";
        $code.='         $sql = "DELETE '."\n";
        $code.='                 FROM '.$table."\n";
        $i=0;
        foreach($priKey as $column){
            $i++;
            if($i==1){
                $code.='                 WHERE '.$column['name']." = ?";
            }else{
                $code.='                   AND '.$column['name']." = ?";
            }
            if($i < sizeof($priKey)){
                $code.="\n";
            }else{
                $code.="\";\n";
            }
        }
        $code.='         $parameters = array('.$priKeyVars.');'."\n";        
        $code.='         $result = $this->execute($sql, $parameters);'."\n";              
        $code.='         return $result;'."\n";        
        $code.="     }\n";
        return $code;
    }  
    private static function generateFunctionCode($module, $table, $columns, $maxNameLength, $priKey){
        $code="";
        $code.="    /** \n";
        $code.="     * Converts a PDO array into a ".$module."_".$table."_Entity instance \n";
        $code.="     *  \n";
        $code.="     * @param array \$array <i>PDO array</i>\n";
        $code.="     *  \n";
        $code.="     * @return ".$module."_".$table."_Entity \n";
        $code.="     *  \n";
        $code.="     */ \n";
        $code.="     public function arrayToEntity(\$array){\n";
        $code.='         $instance = new '.$module.'_'.$table.'_Entity();'."\n";
        $code.='         foreach($array as $key=>$value){ '."\n";
        $code.='             $instance->$key = $value;'."\n";
        $code.='         }'."\n";
        $code.='         return $instance;'."\n";
        $code.="     }\n";
        return $code;
    }    
    private static function generateEntityClass($module, $table, $columns, $maxNameLength){
        $entity="";
        $entity.="class ".$module."_".$table."_Entity { \n";
        foreach($columns as $column){
            $entity.="    /** \n";
            $phpType=self::getPhpType($column['DATA_TYPE']);
            $entity.="     * @var ".str_pad($phpType,8)." ".$column['COLUMN_COMMENT']."<br />"."\n";
            $entity.="     * <b>Column Type:</b> ".$column['COLUMN_TYPE']."<br />"."\n";
            $entity.="     * <b>Nullable:</b> ".$column['IS_NULLABLE']."<br />"."\n";
            $entity.="     * <b>Column Key:</b> ".$column['COLUMN_KEY']."<br />"."\n";
            $entity.="     */ \n";
            $entity.="    public \$".$column['COLUMN_NAME']."; \n";
        }
        $entity.="} \n";  
        return $entity;
    }
    private static function getPhpType($mysqlType){
        $types=array();
        $types['bigint']='integer';
        $types['binary']='integer';
        $types['bit']='boolean';
        $types['blob']='string';
        $types['bool']='boolean';
        $types['boolean']='boolean';
        $types['char']='string';
        $types['date']='date';
        $types['datetime']='date';
        $types['decimal']='double';
        $types['double']='double';
        $types['enum']='enum';
        $types['float']='double';
        $types['int']='integer';
        $types['longblob']='string';
        $types['longtext']='string';
        $types['mediumblob']='string';
        $types['mediumint']='integer';
        $types['mediumint']='integer';
        $types['mediumtext']='string';
        $types['numeric']='double';
        $types['real']='double';
        $types['set']='string';
        $types['smallint']='integer';
        $types['text']='string';
        $types['time']='time';
        $types['timestamp']='datetime';
        $types['tinyblob']='string';
        $types['tinyint']='integer';
        $types['tinytext']='string';
        $types['varbinary']='string';
        $types['varchar']='string';
        $types['year']='integer';         
        return $types[$mysqlType];
    }
    private static function getPrimaryKeyVars($priKey){
        $priKeyVars="";
        foreach($priKey as $column){
            $priKeyVars.='$'.$column['name'].", ";
        }
        $priKeyVars=substr($priKeyVars,0,-2);
        return $priKeyVars; 
    }
}
