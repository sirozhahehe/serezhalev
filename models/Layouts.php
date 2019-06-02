<?php

class Layouts
{
    private $dir_array;
    private $req_uri;
    public function __construct(){
        $this->dir_array = scandir(ROOT.'/views/layouts/');
        $this->req_uri = $_SERVER['REQUEST_URI'];
    }

    public function getLayout($layout){
        $final_arr = array();
        foreach($this->dir_array as $dir){
            if(strpos($dir,'lay') !== false){
                $pos = strpos($dir,'lay');
                $dir = mb_substr($dir,0,$pos-1);
                $final_arr[] = $dir;
            }
        }
        foreach ($final_arr as $item) {
            if ($item == $layout){
                $layout_path[] = '/views/layouts/'.$item.'_lay/index.php';
                $layout_path[] = $final_arr;
                return $layout_path;
            }
        }
        $else_path[] = '/views/index/index.php';
        $else_path[] = $final_arr;
        return $else_path;
    }
}