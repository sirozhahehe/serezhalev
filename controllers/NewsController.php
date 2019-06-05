<?php
require_once ROOT.'/models/News.php';

class NewsController{
    private $news_obj;
    public function __construct()
    {
        $this->news_obj = new News('%',5,1);
    }

    /** actionIndex -  responsible for NewsData output.
     * @param $page int - page number
     * @return bool
     */
    public function actionIndex($page = 1){
        $result_arr = $this->news_obj->getAllPosts($page);
        $result = $result_arr[0];
        $count = $result_arr[1];
        $post_count = $result_arr[2];
        require_once (ROOT.'/views/news/index.php');
        return true;
    }
    /** actionView - responsible for the output of one post
     * @param $id int - post id
     * @return bool
     */
    public function actionView($id){
        $result_id = $this->news_obj->getPostById($id);
        if ($result_id === false) {
            header('Location: /news');
        } else {
            require_once (ROOT.'/views/news/view.php');
        }
        return true;
    }
    /** actionUpdate - handles update request from the update view
     * @param $id int - post id
     * @return bool
     */
    public function actionUpdate($id){
        $result = $this->news_obj->getPostById($id);
        if ($id && $_POST['head'] && $_POST['division'] && $_POST['post_text']) {
            $update_result = $this->news_obj->updatePost($id,$_POST['head'], $_POST['division'], $_POST['post_text']);
        }
        require_once (ROOT.'/views/news/update.php');
        return true;
    }
    /** actionAdd - handles add request from the add view
     * @return bool
     */
    public function actionAdd(){
        if ($_POST['head'] && $_POST['division'] && $_POST['post_text']) {
            $update_result = $this->news_obj->addPost($_POST['head'], $_POST['division'], $_POST['post_text']);
        }
        require_once (ROOT.'/views/news/addpost.php');
        return true;
    }
}