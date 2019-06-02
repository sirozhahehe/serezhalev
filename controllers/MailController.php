<?php

include_once ROOT.'/models/Mail.php';

class MailController
{

    public function __construct(){
    }

    public static function actionMailtome($name,$email){
        $mail_obj = new Mail('thisisdaijas@gmail.com');
        $result = $mail_obj->mailToMe($name,$email);
        if (is_array($result) || $result === false){
            return 'Sorry, try later.';
        } else {
            return 'Message sent!';
        }
    }
}