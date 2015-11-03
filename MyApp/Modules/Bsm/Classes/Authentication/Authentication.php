<?php

class Bsm_Authentication{
    public static function login($userId, $password){
        $correct=false;
        $userMod=new Bsm_BsmUserModel();
        $user=$userMod->read($userId);
        $authFunction=$user->auth_class."::".$user->auth_method;
        if(is_callable($authFunction)){
            $correct = call_user_func($authFunction, array('userId'=>$userId, 'password'=>$password));
        }else{
            trigger_error('Authentication method '.$authFunction.' is not callable.');
        }
        return $correct;
    }
    public static function authenticate($credentials){
        $correct=false;
        $userId = $credentials['userId'];
        $password = $credentials['password'];
        $userMod=new Bsm_BsmUserModel();
        $user=$userMod->read($userId);
        $hash=$user->password;
        
        if(Bsm_Hash::isValidUserPassword($userId, $password, $hash)){
            $correct=true;
        }
        return $correct;
    }
    public static function setPassword($userId, $password){
        $userMod=new Bsm_BsmUserModel();
        $hash=  Bsm_Hash::getUserPasswordHash($userId, $password);
        $userMod->updatePassword($userId, $hash);
    }
}

