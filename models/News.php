<?php

include_once(ROOT.'/components/Db.php');

class  News{

    private $post_count;
    private $category;
    private $page;

    private $select_query = "SELECT id, head, division, post_text FROM news ";
    private $keyword_query = "WHERE (post_text LIKE :keyword OR head LIKE :keyword2)";
    private $division_query = "(division LIKE :division)";
    private $limit_query = " LIMIT :limit OFFSET :offset ";

    public function __construct($default_category,$default_post_count,$default_page)
    {
        $this->post_count = $default_post_count;
        $this->category = $default_category;
        $this->page = 'page'.$default_page;
    }

    public function addPost($post_head, $post_category, $post_text){
        $result = $this->inputCleaner($post_head,$post_category,$post_text);
        $msg = $this->queryCreatorAddPost($result['post_head'],$result['category'],$result['post_text']);
        if ($msg){
            return "Post successfully added";
        } else {
            return "Something went wrong. Try later.";
        }
    }
    public function getAllPosts($post_count = false, $page = false)
    {
        if ($post_count === false || $page === false) {
            $post_count = $this->post_count;
            $page = $this->page;
        }
        $msg = $this->queryCreatorAllNews($post_count, $page);
        return $msg;

    }
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
        //var_dump($post_category,$keyword,$post_count,$page);
        $msg = $this->queryCreatorByFilter($post_category,$keyword,$post_count,$page);
        return $msg;

    }

    public function updatePost($post_id,$post_head, $post_category, $post_text){
        $result = $this->inputCleaner($post_head,$post_category,$post_text);
        $msg = $this->queryCreatorUpdatePost($post_id,$result['post_head'], $result['category'], $result['post_text']);
        if ($msg){
            return "Update Successful";
        } else {
            return "Something went wrong";
        }

    }

    public function getPostById($post_id){

        $msg = $this->queryCreatorOpenById($post_id);
        if ($msg){
            return $msg;
        } else {
            return false;
        }
    }

    public function getCount(){
        $msg = $this->queryCreatorCount();
        if ($msg){
            return $msg;
        } else {
            return 40;
        }
    }

    private function inputCleaner($post_head, $category, $post_text){
        $result['post_head'] = htmlspecialchars(urldecode(trim($post_head)));
        $result['category'] = htmlspecialchars(urldecode(trim($category)));
        $result['post_text'] = htmlspecialchars(urldecode(trim($post_text)));
        return $result;
    }
    private function queryCreatorAllNews($post_count,$page){
        $sql_id = Db::sqlConnection();
        $sql_query = $this->select_query ." ORDER BY post_date DESC ". $this->limit_query;
        $offset = ($page-1) * $post_count;
        $sql_prepared = $sql_id->prepare($sql_query);
        $sql_prepared->bindValue(':limit', $post_count, PDO::PARAM_INT);
        $sql_prepared->bindValue(':offset', $offset, PDO::PARAM_INT);
        $sql_prepared->execute();
        $result = $sql_prepared->fetchAll();
        return $result;
    }

    private function queryCreatorByFilter($post_category,$keyword,$post_count,$page){
        $sql_id = Db::sqlConnection();
        $sql_query = $this->select_query . $this->keyword_query . " AND " . $this->division_query . $this->limit_query;
        $sql_prepared = $sql_id->prepare($sql_query);
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
        $sql_id = Db::sqlConnection();
        $sql_prepared = $sql_id->prepare("INSERT INTO news (head, division, post_text, post_date) VALUES (?,?,?,now())");
        $values = array($post_head, $post_category, $post_text);
        $result = $sql_prepared->execute($values);
        return $result;
    }

    private function queryCreatorUpdatePost($post_id,$post_head, $post_category, $post_text){
        $sql_id = Db::sqlConnection();
        $sql_prepared = $sql_id->prepare("UPDATE news SET head=?, division=?, post_text=? WHERE id = ?");
        $values = array($post_head, $post_category, $post_text,$post_id);
        $result = $sql_prepared->execute($values);
        return $result;
    }

    private function queryCreatorOpenById($post_id){
        $sql_id = Db::sqlConnection();
        $sql_prepared = $sql_id->prepare("SELECT id, head, division, post_text, post_date FROM news WHERE id = ?");
        $sql_prepared->bindValue(1, $post_id, PDO::PARAM_INT);
        $sql_prepared->execute();
        $result = $sql_prepared->fetch();
        return $result;
    }

    private function queryCreatorRemoveById($post_id){
        $sql_id = Db::sqlConnection();
        $sql_prepared = $sql_id->prepare("DELETE FROM news WHERE id = ?");
        $sql_prepared->bindValue(1, $post_id, PDO::PARAM_INT);
        $result = $sql_prepared->execute();
        return $result;
    }

    private function queryCreatorCount(){
        $sql_id = Db::sqlConnection();
        $sql_prepared = $sql_id->prepare("SELECT COUNT(id) FROM news");
        $sql_prepared->execute();
        $result = $sql_prepared->fetch();
        $result = $result['COUNT(id)'];
        return $result;
    }
}