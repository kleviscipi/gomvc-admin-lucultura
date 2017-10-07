<?php


namespace Go;


class PhpMailerException extends \Exception
{

    public function errorMessage()
    {
        $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        echo $errorMsg;
    }
}
