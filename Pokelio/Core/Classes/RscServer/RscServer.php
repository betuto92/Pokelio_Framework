<?php

class Pokelio_RscServer{
    public static function serveFile($filename){
        $extension = Pokelio_File::getFileExtension($filename);
        $mimeType = self::getMimeType($extension);
        if($mimeType!=false){
            ob_clean();
            header("Content-Type: " . $mimeType);
            $bytes = readfile($filename);
            exit;
        }else{
            trigger_error("Extension ".$extension." not found.");
        }
    }
    private static function getMimeType($extension){
        // MIME types array
        $mimeTypes = array(
            "ai"        => "application/postscript",
            "avi"       => "video/x-msvideo",
            "bmp"       => "image/bmp",
            "css"       => "text/css",
            "doc"       => "application/msword",
            "docx"      => "application/msword",
            "eps"       => "application/postscript",
            "gif"       => "image/gif",
            "gtar"      => "application/x-gtar",
            "gz"        => "application/x-gzip",
            "htm"       => "text/html",
            "html"      => "text/html",
            "ico"       => "image/x-icon",
            "jpe"       => "image/jpeg",
            "jpeg"      => "image/jpeg",
            "jpg"       => "image/jpeg",
            "js"        => "text/javascript",
            "json"      => "text/json",
            "mov"       => "video/quicktime",
            "mp2"       => "video/mpeg",
            "mp3"       => "audio/mpeg",
            "mp4"       => "audio/mpeg",
            "mpeg"      => "video/mpeg",
            "mpg"       => "video/mpeg",
            "pdf"       => "application/pdf",
            "png"       => "image/png",
            "pps"       => "application/vnd.ms-powerpoint",
            "ppt"       => "application/vnd.ms-powerpoint",
            "rtf"       => "application/rtf",
            "svg"       => "image/svg+xml",
            "tar"       => "application/x-tar",
            "tgz"       => "application/x-compressed",
            "tif"       => "image/tiff",
            "tiff"      => "image/tiff",
            "txt"       => "text/plain",
            "vcf"       => "text/x-vcard",
            "wav"       => "audio/x-wav",
            "wri"       => "application/x-mswrite",
            "xls"       => "application/vnd.ms-excel",
            "xlsx"      => "vnd.ms-excel",
            "zip"       => "application/zip");
        $mimeType=false;
        if(isset($mimeTypes[$extension])){
            $mimeType = $mimeTypes[$extension];
        }
        return $mimeType; // return the array value
        
    }
}
