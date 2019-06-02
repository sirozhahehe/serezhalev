<?php

include_once ROOT.'/models/Layouts.php';

class LayoutController
{
    private $layout_obj;
    public function __construct()
    {
        $this->layout_obj = new Layouts();
    }
    public function actionIndex($layout){
        $result = $this->layout_obj->getLayout($layout);
        require_once (ROOT.$result[0]);
        return true;
    }
}