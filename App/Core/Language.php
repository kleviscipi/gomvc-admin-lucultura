<?php
namespace Go;
use Go\Session as Session;
use Go\Config as Config;
class Language
{

    private $array;
    public $language;
    
    public function __construct($name, $code = LANGUAGE_CODE){
	
        $this->load($name,$code = LANGUAGE_CODE);
    }

    public function load($name, $code = LANGUAGE_CODE)
    {
        $code = $this->langs($code);
        $file = $_SERVER['DOCUMENT_ROOT']."/App/Languages/$code/$name.php";
     
        $this->array[$code] = include $file;
    }

    public function get($value, $code = LANGUAGE_CODE)
    {
        $code = $this->langs($code);
        if (!empty($this->array[$code][$value])) {
            return $this->array[$code][$value];
        } elseif(!empty($this->array[$code][$value])) {
            return $this->array[$code][$value];
        } else {
            return $value;
        }
    }

    public static function show($value, $name, $code = LANGUAGE_CODE)
    {   
        $obj = new Language();
        $code = $obj->langs($code);
        $file = $_SERVER['DOCUMENT_ROOT']."/App/Languages/$code/$name.php";

        if (is_readable($file)) {
            $array = include($file);
        } else {
            echo Error::display("Could not load language file --- '$code/$name.php'");
            die;
        }

        if (!empty($array[$value])) {
            return $array[$value];
        } else {
            return $value;
        }
    }
    public  function langs($code){

        $this->language = Session::get('language');
        if(!empty( $this->language ) ){
            $code = $this->language;
            return $code;
        }else{
            $code = $code;
            return $code;
        }
    }
}
