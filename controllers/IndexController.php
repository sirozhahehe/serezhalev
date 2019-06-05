<?php

include_once ROOT.'/models/Layouts.php';
include_once ROOT.'/controllers/MailController.php';

class IndexController
{
    private $index_obj;
    public function __construct()
    {
        $this->index_obj = new Layouts();
    }
    public function actionView(){

        $msg = MailController::actionMailtome($_POST['name'],$_POST['email']);
        $result = $this->index_obj->getLayouts();
        require_once (ROOT.'/views/index/index.php');
        return true;
    }
}