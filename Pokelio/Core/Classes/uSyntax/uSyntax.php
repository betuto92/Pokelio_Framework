<?php
/**
 * Pokelio_uSyntax (microSyntax)
 * 
 * A class to parse templates and replace {{ }} entries with PHP code
 */
class Pokelio_uSyntax{
    public static function view($templateSrc, $templateName, $moduleName){
        $viewPath=_::getConfig("APP_VIEW_PATH");
        $cache = _::getConfig('USYNTAX_CACHE');
        $viewFile=$templateSrc;
        Pokelio_File::makedir($viewPath.'/'.$moduleName);
        $procViewFile=$viewPath.'/'.$moduleName.'/'.$templateName.'Template.php';
        if(file_exists($procViewFile)){
            if(filemtime($viewFile)>filemtime($procViewFile) || $cache==false){
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
        //$pattern = "/{{(.*?)}}/";
        $pattern = "@<m>(.*?)</m>@";
        
        preg_match_all($pattern, $viewContent, $matches);
        foreach($matches[1] as $match){
            $target=self::parse($match);
            //$viewContent=str_replace("{{".$match."}}",$target,$viewContent);
            $viewContent=str_replace("<m>".$match."</m>",$target,$viewContent);
        }
        //Save the processed view with replaced MicroSyntax elements
        Pokelio_File::writeFile($procViewFile, $viewContent);      
    }
    private static function parse($token){
        if(substr($token,0,1)!="*"){
            if(substr($token, 0, 5) == 'echo('){
                $res=self::parseDisplay($token);
            }elseif(substr($token, 0, 4) == 'for('){
                $res=self::parseFor($token);
            }elseif(substr($token, 0, 5) == 'bend('){
                $res=self::parseEnd($token);
            }elseif(substr($token, 0, 1) == '}'){
                $res=self::parseEnd($token);                
            }elseif(substr($token, 0, 4) == 'php('){
                $res=self::parsePHP($token);
            }elseif(substr($token, 0, 7) == 'webrsc('){
                $res=self::parseRsc($token);  
            }else{
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
    private static function parseEnd($token){
        $res="<?php } ?>";
        return $res;
    } 
    private static function parseRsc($token){
        $res="<?php echo \$rscUrl; ?>";
        return $res;
    }     
}
