<?php

class Pokelio_CB_Error{
    public static function ErrorCaptured($errorData){
        //$errorData is an array of this elements:
        //['errno']         Severity
        //['errstr']        Description
        //['errfile']       File
        //['errline']       Line
        //['errcontext']    Context

    }    
}