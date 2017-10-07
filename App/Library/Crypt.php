<?php
namespace Go;
class Crypt
{

    public static function cryptFile( $file )
    {

        if( !empty( $file ) ):
            $setfile = md5($file.md5(KEY));
        endif;
        return $setfile;
    }

    public static function decrypt( $gofile,$callfile )
    {
		if (hash_equals($callfile, crypt($gofile, $callfile))) {
		    return true;
		}else return false;
    }

    public static function crypt( $file )
    {
    	$hashed= crypt($file,$salt = '');
    	return $hashed;
    }

    public static function Tokenid($id){
        $date = date('Y-m-d');
        $id = base64_encode($id);
        $key = KEY_TOKEN.":".$id.":".$date;
        return base64_encode($key);

    }

    public static function deTokenid($token){
         $date = date('Y-m-d');
         $deToken = explode(":",base64_decode($token));
         if($deToken[0] == KEY_TOKEN && $date == $deToken[2]){
            return base64_decode($deToken[1]);
         }
        

    }
}

