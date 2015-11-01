<?php

class Pokelio_uSyntax{
    public static function view($view, $templateName){
        $viewFile=$view;
        $procViewFile=_::getConfig('APP_VIEW_PATH').'/'.$templateName.'Template.php';
        if(file_exists($procViewFile)){
            if(filemtime($viewFile)>filemtime($procViewFile)){
                self::processView($viewFile, $procViewFile);
            }
        }else{
            self::processView($viewFile, $procViewFile);
        }
        return $procViewFile;
    }
    private static function processView($viewFile,$procViewFile){
        $viewContent= file_get_contents($viewFile);
        //$pattern = "/{{(.*)}}/"; Error, no procesa varios en una linea
        $pattern = "/{{(.*?)}}/";
        
        preg_match_all($pattern, $viewContent, $matches);
        foreach($matches[1] as $match){
            $target=self::parse($match);
            $viewContent=str_replace("{{".$match."}}",$target,$viewContent);
        }
        //Save the processed view with replaced MicroSyntax elements
        Pokelio_File::writeFile($procViewFile, $viewContent);      
    }
    private static function parse($token){
        if(substr($token,0,1)!="*"){
            switch(substr($token,0,4)){
                case 'DSP(':
                    $res=self::parseDisplay($token);
                    break;
                case 'FOR(':
                    $res=self::parseFor($token);
                    break;
                case 'LOC(':
                    $res=self::parseLoc($token);
                    break;
                case 'END(':
                    $res=self::parseEnd($token);
                    break;
                case 'PHP(':
                    $res=self::parsePHP($token);
                    break;
                case 'HOM(':
                    $res=self::parseHome($token);
                    break;                
                default:
                    $res=self::parseDisplay($token);
            }
        }else{
            $res="";
        }
        return $res;
    }
    private static function cleanToken($token){
        $res=substr($token,4);
        if(substr($res,-1,1)==")"){
            $res=substr($res,0,-1);
        }
        return $res;
    }
    private static function parseDisplay($token){
        if(substr($token,0,4)=="DSP"){
            $ctoken=self::cleanToken($token);
        }else{
            $ctoken=$token;
        }
        $res="<?php echo ".$ctoken."; ?>";
        return $res;
    }
    private static function parsePHP($token){
        $ctoken=self::cleanToken($token);
        $res="<?php ".$ctoken." ?>";
        return $res;
    }
    private static function parseLoc($token){
        $ctoken=self::cleanToken($token);
        $res="<?php echo cccLang::gI()->_str('".$ctoken."') ?>";
        return $res;
    }
    private static function parseFor($token){
        $ctoken=self::cleanToken($token);
        $subtokens=explode(",",$ctoken);
        $ss=sizeof($subtokens);
        if($ss==2){
            $res="<?php foreach(".$subtokens[0]." as ".$subtokens[1]."){ ?>";
        }elseif($ss==3){
            $res="<?php foreach(".$subtokens[0]." as ".$subtokens[1]."=>".$subtokens[2]."){ ?>";
        }else{
            $res="MicroSyntax parsing error!!!";
        }
        return $res;
    }    
    private static function parseHome($token){
        $res="<?php echo str_replace('/index.php','',\$_SERVER['PHP_SELF']); ?>";
        return $res;
    }
    private static function parseEnd($token){
        $res="<?php } ?>";
        return $res;
    }    
}
