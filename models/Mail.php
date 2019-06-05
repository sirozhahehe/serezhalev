<?php
require_once ROOT.'/components/InputCleaner.php';
class Mail
{
    private $myemail;

    public function __construct($myemail)
    {
        $this->myemail = $myemail;
    }

    public function mailToMe($name,$email,$message = 'Call back.'){
        $msg = $this->mailValidator($name,$email,$message);
        if (is_array($msg)){
            return $msg;
        }
        $var_array = array('name','email','message');
        foreach ($var_array as $var){
            $$var = InputCleaner::inClean($$var);
        }
        if (mail(
            $this->myemail,
            "Letter from " . $name,
            $message . "<br/>" . $email,
            $headers ="Content-type: text/html; charset=utf-8\r\n" .
                "MIME-Version: 1.0\r\n"
        ) ) {
            return true;
        } else {
            return false;
        }
    }

    private function mailValidator($name,$email,$message){
        $count = 0;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = "Wrong E-mail";
            $count+=1;
        }
        if (strlen($name) < 3) {
            $errors['name'] = "Too short name";
            $count+=1;
        }
        if (strlen($message) < 4) {
            $errors['msg'] = "Leave your message, please";
            $count+=1;
        }
        if ($count == 0) {
            return true;
        } else {
            return $errors;
        }
    }
}