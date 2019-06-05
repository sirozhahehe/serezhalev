<?php

class  News{

    private $post_count;
    private $category;
    private $page;

    private $pdo;
    private $select_query = "SELECT id, head, division, post_text FROM news ";
    private $keyword_query = "WHERE (post_text LIKE :keyword OR head LIKE :keyword2)";
    private $division_query = "(division LIKE :division)";
    private $limit_query = " LIMIT :limit OFFSET :offset ";

    public function __construct($default_category,$default_post_count,$default_page)
    {
        $this->post_count = $default_post_count;
        $this->category = $default_category;
        $this->page = $default_page;
        $this->pdo = Db::sqlConnection();
    }

    /** addPost - creates new post in DataBase
     * @param $post_head string
     * @param $post_category string
     * @param $post_text string
     * @return string - returng positive or negative result of Add request
     */
    public function addPost($post_head, $post_category, $post_text){
        $var_array = array('post_head','post_category','post_text');
        foreach ($var_array as $var){
            $$var = InputCleaner::inClean($$var);
        }
        if ($_SESSION['started']=='yes') {
            $update_result = 'Sorry, but we already have your changes. Try later.';
        }
        else {
            $_SESSION['started'] = 'yes';
            $this->queryCreatorAddPost($post_head, $post_category, $post_text);
            $update_result = 'Successful update';
        }
        return $update_result;
    }
    /** getAllPosts - returns Array with NewsData as Array, NewsCount as int and PostCountPerPage as int
     * @param $page int
     * @param $post_count int
     * @return array
     */
    public function getAllPosts($page = 0, $post_count = 0)
    {
        if ($post_count == 0){
            $post_count = $this->post_count;
        }
        $result[0] = $this->queryCreatorAllNews($post_count, $page); // NewsData
        $result[1] = $this->queryCreatorCount(); //NewsCount
        $result[2] = $post_count; //PostCountPerPage
        return $result;

    }

    /** getPostsByFilter - returns filtered Array with NewsData
     * @param $post_category string
     * @param $keyword string
     * @param $post_count int
     * @param $page int
     * @return array
     */
    public function getPostsByFilter($post_category = false,$keyword = false,$post_count = false,$page = false){
        if ($post_count === false || $page === false) {
            $post_count = $this->post_count;
            $page = $this->page;
        }
        if (!$post_category){
            $post_category = $this->category;
        }
        if ($keyword !== false){
            $keyword = mb_substr($keyword, 0, 20);
        }
        $msg = $this->queryCreatorByFilter($post_category,$keyword,$post_count,$page);
        return $msg;

    }
    /** updatePost - updates Data in selected post
     * @param $post_id int
     * @param $post_head string
     * @param $post_category string
     * @param $post_text string
     * @return string - positive or negative result of Update request
     */
    public function updatePost($post_id,$post_head, $post_category, $post_text){
        $var_array = array('post_head','post_category','post_text');
        foreach ($var_array as $var){
            $$var = InputCleaner::inClean($$var);
        }
        if ($_SESSION['started']=='yes') {
            $update_result = 'Sorry, but we already have your changes. Try later.';
        }
        else {
            $_SESSION['started'] = 'yes';
            $this->queryCreatorUpdatePost($post_id,$post_head, $post_category, $post_text);
            $update_result = 'Successful update';
        }
        return $update_result;
    }
    /** getPostById - returns One Post Data as Array
     * @param $post_id int
     * @return Array/bool
     */
    public function getPostById($post_id){

        $msg = $this->queryCreatorOpenById($post_id);
        if ($msg){
            return $msg;
        } else {
            return false;
        }
    }

    private function queryCreatorAllNews($post_count,$page){
        $sql_query = $this->select_query ." ORDER BY post_date DESC ". $this->limit_query;
        $offset = ($page-1) * $post_count;
        $sql_prepared = $this->pdo->prepare($sql_query);
        $sql_prepared->bindValue(':limit', $post_count, PDO::PARAM_INT);
        $sql_prepared->bindValue(':offset', $offset, PDO::PARAM_INT);
        $sql_prepared->execute();
        $result = $sql_prepared->fetchAll();
        return $result;
    }

    private function queryCreatorByFilter($post_category,$keyword,$post_count,$page){
        $sql_query = $this->select_query . $this->keyword_query . " AND " . $this->division_query . $this->limit_query;
        $sql_prepared = $this->pdo->prepare($sql_query);
        $offset = ($page-1) * $post_count;
        $keyword = "%".$keyword."%";
        $post_category = "%".$post_category."%";
        $sql_prepared->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        $sql_prepared->bindValue(':keyword2', $keyword, PDO::PARAM_STR);
        $sql_prepared->bindValue(':division', $post_category, PDO::PARAM_STR);
        $sql_prepared->bindValue(':limit', $post_count, PDO::PARAM_INT);
        $sql_prepared->bindValue(':offset', $offset, PDO::PARAM_INT);
        $sql_prepared->execute();
        $result = $sql_prepared->fetchAll();
        return $result;
    }

    private function queryCreatorAddPost($post_head, $post_category, $post_text){
        $sql_prepared = $this->pdo->prepare("INSERT INTO news (head, division, post_text, post_date) VALUES (?,?,?,now())");
        $values = array($post_head, $post_category, $post_text);
        $result = $sql_prepared->execute($values);
        return $result;
    }

    private function queryCreatorUpdatePost($post_id,$post_head, $post_category, $post_text){
        $sql_prepared = $this->pdo->prepare("UPDATE news SET head=?, division=?, post_text=? WHERE id = ?");
        $values = array($post_head, $post_category, $post_text,$post_id);
        $result = $sql_prepared->execute($values);
        return $result;
    }

    private function queryCreatorOpenById($post_id){
        $sql_prepared = $this->pdo->prepare("SELECT id, head, division, post_text, post_date FROM news WHERE id = ?");
        $sql_prepared->bindValue(1, $post_id, PDO::PARAM_INT);
        $sql_prepared->execute();
        $result = $sql_prepared->fetch();
        return $result;
    }

    private function queryCreatorRemoveById($post_id){
        $sql_prepared = $this->pdo->prepare("DELETE FROM news WHERE id = ?");
        $sql_prepared->bindValue(1, $post_id, PDO::PARAM_INT);
        $result = $sql_prepared->execute();
        return $result;
    }

    private function queryCreatorCount(){
        $sql_prepared = $this->pdo->prepare("SELECT COUNT(id) FROM news");
        $sql_prepared->execute();
        $result = $sql_prepared->fetch();
        $result = $result['COUNT(id)'];
        return $result;
    }
}