<?php

include_once ROOT.'/models/News.php';
include_once ROOT.'/controllers/MailController.php';

class NewsController{
    private $news_obj;
    public function __construct()
    {
        $this->news_obj = new News('%',5,1);
        $msg = MailController::actionMailtome($_POST['name'],$_POST['email']);
    }
    public function actionIndex($page){
        if (!($page)){$page = 1;}
        $post_count = 5;
        $result = $this->news_obj->getAllPosts($post_count, $page);
        $count = $this->news_obj->getCount();
        require_once (ROOT.'/views/news/index.php');
        return true;
    }
    public function actionView($id){
        $result_id = $this->news_obj->getPostById($id);
        if ($result_id === false) {
            $result = $this->news_obj->getAllPosts($post_count = 5, $page = 1);
            $count = $this->news_obj->getCount();
            require_once  (ROOT.'/views/news/index.php');
        } else {
            require_once (ROOT.'/views/news/view.php');
        }
        return true;
    }
    public function actionUpdate($id){
        if ($id && $_POST['head'] && $_POST['division'] && $_POST['post_text']) {
            if ($_SESSION['started']=='yes') {
                $update_result = 'Sorry, but we already have your changes. Try later.';
            }
            else {
                $_SESSION['started'] = 'yes';
                $update_result = $this->news_obj->updatePost($id, $_POST['head'], $_POST['division'], $_POST['post_text']);
            }
            $result = $this->news_obj->getPostById($id);
            require_once (ROOT.'/views/news/update.php');
        }
        else{
            $result = $this->news_obj->getPostById($id);
            require_once (ROOT.'/views/news/update.php');
        }
        return true;
    }
    public function actionAdd(){
        if ($_POST['head'] && $_POST['division'] && $_POST['post_text']){
            if ($_SESSION['started']=='yes') {
                $result = 'Sorry, but we already have your post. Try later.';
            }
            else{
                $_SESSION['started'] = 'yes';
            $result = $this->news_obj->addPost($_POST['head'], $_POST['division'], $_POST['post_text']);
                }
            }
        require_once (ROOT.'/views/news/addpost.php');
        return true;
    }
}