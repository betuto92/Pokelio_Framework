<?php 
/** 
 *  Bsm_BsmProfileEntity
 *  A class containing mappings of BsmProfile table.
 *  
 *  Code generated by Pokelio Codegen Module on Sun, 01 Nov 2015 10:07:20 +0100
 *  
 */ 
class Bsm_BsmProfileEntity { 
    /** 
     * @var integer  Profile identificator<br />
     * <b>Column Type:</b> int(11)<br />
     * <b>Nullable:</b> NO<br />
     * <b>Column Key:</b> PRI<br />
     * <b>Extra info:</b> <br />
     */ 
    public $id_profile; 
    /** 
     * @var string   Profile name<br />
     * <b>Column Type:</b> varchar(80)<br />
     * <b>Nullable:</b> YES<br />
     * <b>Column Key:</b> <br />
     * <b>Extra info:</b> <br />
     */ 
    public $profile; 
    /** 
     * @var string   Status: A-Active, D-Deactivated<br />
     * <b>Column Type:</b> char(1)<br />
     * <b>Nullable:</b> YES<br />
     * <b>Column Key:</b> <br />
     * <b>Extra info:</b> <br />
     */ 
    public $status; 
} 
