<?php
/** 
 *  Bsm_BsmUserModel
 *  A class with basic data manipulation methods for table BsmUser
 *  
 *  Code generated by Spark Codegen Module on Sat, 31 Oct 2015 20:19:21 +0100
 *  
 */ 
class Bsm_BsmUserModel extends Spark_MySql_Connector{ 
    /** 
     * Invokes the parent __construct method passing connection id 
     *  
     */ 
     public function __construct() {
         $connName=Spark_Global::getConfig("CONNECTION_ID", "Bsm");
         parent::__construct($connName);
     }
    /** 
     * Reads a record identified by $id_user, $name 
     *  
     * @param string $id_user <i>User id, like u001, 88124, ...</i>
     * @param string $name <i>Name of the user</i>
     *  
     * @return Bsm_BsmUser_Entity 
     *  
     */ 
     public function read($id_user, $name){
         $sql = "SELECT * 
                 FROM BsmUser
                 WHERE id_user = ?
                   AND name = ?";
         $parameters = array($id_user, $name);
         $result = $this->executeAndFetchAll($sql, $parameters);
         if(sizeof($result)>0){
             $result = $this->arrayToEntity($result[0]);
         }else{
             $result = false;
         }
         return $result;
     }
    /** 
     * Lists records that match fields with value of the entity passed 
     *  
     * @param Bsm_BsmUser_Entity $entity <i>Instance of entity with values</i>
     * @param boolean $rowsResult <i>Result is an array of rows, not an array of entities</i>
     *  
     * @return array 
     */ 
     public function listRecords(Bsm_BsmUser_Entity $entity, $rowsResult=false){
         $parameters = array();
         $sql = "SELECT * 
                 FROM BsmUser";
         $i=0;
         foreach(get_object_vars($entity) as $key=>$var){
             if($var !== null){
                 $i++;
                 if($i==1){
                     $sql.=" WHERE ".$key." = ?";
                 }else{
                     $sql.=" AND ".$key." = ?";
                 }
                 $parameters[] = $var;
             }
         }
         
         $result = $this->executeAndFetchAll($sql, $parameters);
         if($rowsResult==false){
             foreach($result as $key=>$row){
                 $result[$key] = $this->arrayToEntity($row);
             }
         }
         return $result;
     }
    /** 
     * Creates a new record with values of the entity passed 
     *  
     * @param Bsm_BsmUser_Entity $entity <i>Instance of entity with values</i>
     *  
     */ 
     public function create(Bsm_BsmUser_Entity $entity){
         $parameters = array();
         $sql = "INSERT INTO BsmUser";
         $sql.= " (id_user, name, surname, email, password, status, ts_created, ts_last_access)";
         $sql.= " VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         $parameters[]= $entity->id_user;
         $parameters[]= $entity->name;
         $parameters[]= $entity->surname;
         $parameters[]= $entity->email;
         $parameters[]= $entity->password;
         $parameters[]= $entity->status;
         $parameters[]= $entity->ts_created;
         $parameters[]= $entity->ts_last_access;
         $result = $this->execute($sql, $parameters);
         return $result;
     }
    /** 
     * Updates the record identified by values of the entity passed 
     *  
     * @param Bsm_BsmUser_Entity $entity <i>Instance of entity with values</i>
     *  
     */ 
     public function update(Bsm_BsmUser_Entity $entity){
         $parameters = array();
         $sql = "UPDATE BsmUser SET ";
         $sql.= "  surname = ?, ";
         $sql.= "  email = ?, ";
         $sql.= "  password = ?, ";
         $sql.= "  status = ?, ";
         $sql.= "  ts_created = ?, ";
         $sql.= "  ts_last_access = ? ";
         $sql.= "WHERE id_user = ? ";
         $sql.= "  AND name = ? ";
         $parameters[] = $entity->surname;
         $parameters[] = $entity->email;
         $parameters[] = $entity->password;
         $parameters[] = $entity->status;
         $parameters[] = $entity->ts_created;
         $parameters[] = $entity->ts_last_access;
         $parameters[] = $entity->id_user;
         $parameters[] = $entity->name;
         $result = $this->execute($sql, $parameters);
         return $result;
     }
    /** 
     * Deletes the record identified by $id_user, $name 
     *  
     * @param string $id_user <i>User id, like u001, 88124, ...</i>
     * @param string $name <i>Name of the user</i>
     *  
     */ 
     public function delete($id_user, $name){
         $sql = "DELETE 
                 FROM BsmUser
                 WHERE id_user = ?
                   AND name = ?";
         $parameters = array($id_user, $name);
         $result = $this->execute($sql, $parameters);
         return $result;
     }
    /** 
     * Converts a PDO array into a Bsm_BsmUser_Entity instance 
     *  
     * @param array $array <i>PDO array</i>
     *  
     * @return Bsm_BsmUser_Entity 
     *  
     */ 
     public function arrayToEntity($array){
         $instance = new Bsm_BsmUser_Entity();
         foreach($array as $key=>$value){ 
             $instance->$key = $value;
         }
         return $instance;
     }
} 

class Bsm_BsmUser_Entity { 
    /** 
     * @var string   User id, like u001, 88124, ...<br />
     * <b>Column Type:</b> varchar(12)<br />
     * <b>Nullable:</b> NO<br />
     * <b>Column Key:</b> PRI<br />
     */ 
    public $id_user; 
    /** 
     * @var string   Name of the user<br />
     * <b>Column Type:</b> varchar(60)<br />
     * <b>Nullable:</b> NO<br />
     * <b>Column Key:</b> PRI<br />
     */ 
    public $name; 
    /** 
     * @var string   Surname of the user<br />
     * <b>Column Type:</b> varchar(120)<br />
     * <b>Nullable:</b> NO<br />
     * <b>Column Key:</b> <br />
     */ 
    public $surname; 
    /** 
     * @var string   Email account<br />
     * <b>Column Type:</b> varchar(120)<br />
     * <b>Nullable:</b> YES<br />
     * <b>Column Key:</b> <br />
     */ 
    public $email; 
    /** 
     * @var string   Password hash<br />
     * <b>Column Type:</b> char(40)<br />
     * <b>Nullable:</b> YES<br />
     * <b>Column Key:</b> <br />
     */ 
    public $password; 
    /** 
     * @var string   Status: A-Active, D-Deactivated<br />
     * <b>Column Type:</b> char(1)<br />
     * <b>Nullable:</b> NO<br />
     * <b>Column Key:</b> <br />
     */ 
    public $status; 
    /** 
     * @var datetime Timestamp of user creation<br />
     * <b>Column Type:</b> timestamp<br />
     * <b>Nullable:</b> NO<br />
     * <b>Column Key:</b> <br />
     */ 
    public $ts_created; 
    /** 
     * @var datetime Timestamp of user last access<br />
     * <b>Column Type:</b> timestamp<br />
     * <b>Nullable:</b> NO<br />
     * <b>Column Key:</b> <br />
     */ 
    public $ts_last_access; 
} 