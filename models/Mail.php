<?php

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
        $result = $this->mailCleaner($name,$email,$message);
        if (mail(
            $this->myemail,
            "Letter from " . $result['name'],
            $result['msg'] . "<br/>" . $result['email'],
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

    private function mailCleaner($name,$email,$message){
        $email = urldecode($email);
        $message = urldecode($message);
        $name = urldecode($name);

        $email = htmlspecialchars($email);
        $message = htmlspecialchars($message);
        $name = htmlspecialchars($name);

        $result['email'] = trim($email);
        $result['msg'] = trim($message);
        $result['name'] = trim($name);
        return $result;
    }
}