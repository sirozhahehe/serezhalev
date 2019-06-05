<?php

include_once ROOT.'/models/Mail.php';

class MailController
{
    public function __construct(){

    }

    public function actionMailtome(){
        $mail_obj = new Mail('thisisdaijas@gmail.com');

        if ($_POST['name'] && $_POST['email']){
        $mail_obj->mailToMe($_POST['name'],$_POST['email']);
        header('Location: '.$_SERVER['REQUEST_URI']);
        die();
        }
    }
}