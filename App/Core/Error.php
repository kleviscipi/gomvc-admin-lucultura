<?php
namespace Go;
use Go\Template as Template;

class Error 
{
    private $error = null;


    public function __construct($error = null)
    {
        $this->error = $error;
    }

    public function index($error = null)
    {
        header("HTTP/1.0 404 Not Found");
 
        $data['title'] = '404';
        $data['error'] = $error ? $error : $this->error;

        Template::View('Error','index',$data);
    }
    public function block($error = null)
    {
        header("HTTP/1.0 404 Not Found");
 
        $data['title'] = '505';
        $data['error'] = $error ? $error : $this->error;

        Template::View('Error','Blocket',$data);
    }
    public static function display($error, $class = 'alert alert-danger')
    {
        if (is_array($error)) {
            foreach ($error as $error) {
                $row.= "<div class='$class'>$error</div>";
            }
            return $row;
        } else {
            if (isset($error)) {
                return "<div class='$class'>$error</div>";
            }
        }
    }
}
