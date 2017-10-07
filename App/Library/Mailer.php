<?php
namespace Go;

use Go\PhpMailer\PhpMailer AS PhpMailer;

class Mailer extends PhpMailer
{

    public $From     = 'noreply@domain.com';

    public $FromName = SITETITLE;

    /**
     * Host
     *
     * @var string $Host set sender SMTP Route
     */
    //public $Host     = 'smtp.gmail.com';

    /**
     * Mailer
     *
     * @var string $Mailer set type default is SMTP
     */
    //public $Mailer   = 'smtp';

    /**
     * SMTPAuth
     *
     * @var string $SMTPAuth use authenticated
     */
    //public $SMTPAuth = true;

    /**
     * Username
     *
     * @var string $Username set username
     */
    //public $Username = 'email';

    /**
     * Password
     *
     * @var string $Password set password
     */
    //public $Password = 'password';

    /**
     * SMTPSecure
     *
     * @var string $SMTPSecure set Secure SMTP
     */
    //public $SMTPSecure = 'tls';

    /**
     * WordWrap
     * @var integer $WordWrap set word wrap
     */
    public $WordWrap = 75;

    public function subject($subject)
    {
        $this->Subject = $subject;
    }

    public function body($body)
    {
        $this->Body = $body;
    }

    public function send()
    {
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);

        return parent::send();
    }

    public function cleanMessage($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");

        return str_replace($bad, "", $string);
    }
}
