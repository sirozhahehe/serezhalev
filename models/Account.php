<?php

class Account
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Db::sqlConnection();
    }
    /** getAccounts - handles request from AccountController, cleans input through inClean method
     * calls queryGetAllAcc that returns Array with data that matches the request.
     * Array returns to AccountController
     * @param $keyword string
     * @param $birth_date string - exp. date YYYY-MM-DD
     * @param $gender int- exp. 1(male), 2(female), 0(All), 3(Not selected)
     * @param $order string - exp. column name which use for sorting
     * @param $order_type int - exp. type of sorting
     * @param $page int -  exp. number of page
     * @return array where result[0] - Array with data, result[1] - Data Count
     */

    public function getAccounts($page = 1, $keyword = '',$birth_date = '',$gender = 3,$order = 'birth_date',$order_type = 2){
        $var_array = array('page','keyword','birth_date','gender','order','order_type');
        foreach ($var_array as $var){
            $$var = InputCleaner::inClean($$var);
        }

        if ($keyword == '' && $birth_date == '' && $gender == '' && $order == '' && $order_type == '') {
            $result[] = $this->queryGetAllAcc($_SESSION['keyword'],$_SESSION['birth_date'],$_SESSION['gender'],$_SESSION['order'],$_SESSION['order_type'],$page);
            $result[] = $this->queryCounter($_SESSION['keyword'],$_SESSION['birth_date'],$_SESSION['gender']);
        } else {
            $_SESSION['keyword'] = $keyword; $_SESSION['birth_date'] = $birth_date; $_SESSION['gender'] = $gender;
            $_SESSION['order'] = $order; $_SESSION['order_type'] = $order_type;
            $result[] = $this->queryGetAllAcc($_SESSION['keyword'],$_SESSION['birth_date'],$_SESSION['gender'],$_SESSION['order'],$_SESSION['order_type'],$page);
            $result[] = $this->queryCounter($_SESSION['keyword'],$_SESSION['birth_date'],$_SESSION['gender']);
        }

        if ($result[1] != 0 && $page > ceil($result[1]/5)){ header('Location: /account');}
        return $result;
    }

    /** getOneAcc - -//-
     * calls queryGetOneAcc that returns Array with User($login) data. Array returns to AccountController.
     * @param string $login
     * @return bool/array
     */
    public function getOneAcc($login){
        $login = InputCleaner::inClean($login);
        $result = $this->queryGetOneAcc($login);

        if($_SESSION['login'] == $result['login'] || $_SESSION['login'] == 'root'){
            return $result;
        } else {
            $_SESSION['msg'] = 'You have not enough permissions'; //needs to show to user his incorrect action
            return false;
        }

    }

    /** getLightAcc - light version of getOneAcc. Needs for sign in and sign up actions.
     * Returns Array with login&password.
     * @param $login string
     * @return bool/array
     */
    public function signIn($login){
        $login = InputCleaner::inClean($login);

        if (isset($login)){
            $result = $this->queryGetOneAccLight($login);
            $pw = Encrypter::enCrypt($_POST['password']);  //encrypting password
            if ($result) {
                if ($pw == $result['password']) {
                    $_SESSION['login'] = $result['login'];
                    return true;
                } else {
                    return $msg = 'Incorrect data';
                }
            } else {
                return $msg = 'Incorrect data';
            }
        }
    }

    /** newAcc - handles request from AccountController, cleans input through inClean method
     * creates new record in DataBase through queryNewAcc. returns result of action
     * @param $login string
     * @param $password string
     * @param $firstname string
     * @param $surname string
     * @param $gender int
     * @param $birth_date string
     * @return string/bool
     */
    public function newAcc($login,$password,$firstname,$surname,$gender, $birth_date){
        $var_array = array('login','password','firstname','surname','gender','birth_date');
        foreach ($var_array as $var){
            $$var = InputCleaner::inClean($$var);
        }
        if ($birth_date == 0){$birth_date = '1970-01-01';}
        $gender = $gender * 1;
        $result = $this->queryGetOneAccLight($login);
        if ($result) {
                return $msg = 'This login already exist';
        } elseif (preg_match('~^[A-Za-z0-9]{3,15}$~', $login) == 0){
                return $msg = 'Incorrect login';
        } elseif (!$result) {
                $this->queryNewAcc($login, $password,$firstname,$surname,$gender,$birth_date);
                $_SESSION['login'] = $login;
                return true;
            }
    }

    /** editAcc -//-
     * callse queryEditAcc that Updates data in DataBase according to request
     * @param $login string
     * @param $firstname string
     * @param $surname string
     * @param $gender int
     * @param $birth_date string
     * @return bool
     */
    public function editAcc($login,$firstname = ' ',$surname = ' ',$gender = 0, $birth_date = '0000-00-00'){
        $var_array = array('login','firstname','surname','gender','birth_date');
        foreach ($var_array as $var){
            $$var = InputCleaner::inClean($$var);
        }
        $result = $this->queryEditAcc($login,$firstname,$surname,$gender,$birth_date);

        if ($result){
            $_SESSION['edit_msg'] = 'Edit successful'; // needs to show to user status of his action
        } else {
            $_SESSION['edit_msg'] = 'Something went wrong, try later';
        }
        return $result;
    }

    /** editPassword -//-
     * calls queryEditPassword that Updates password in DataBase according to request
     * @param $login string
     * @param $password string
     * @return bool
     */
    public function editPassword($login,$password){
        $password = InputCleaner::inClean($password);
        $login = InputCleaner::inClean($login);
        $result = $this->queryEditPassword($login,$password);
        if ($result){
                $_SESSION['edit_msg'] = 'Edit successful'; // needs to show to user status of his action
        } else {
                $_SESSION['edit_msg'] = 'Something went wront, try later';
            }


        return $result;
    }

    /** removeAcc -//-
     * calls queryRemoveAcc that Removes Account($login) data from DataBase
     * @param $login string
     * @return bool
     */
    public function removeAcc($login){
        $login = InputCleaner::inClean($login);
        $result = $this->queryRemoveAcc($login);
        if ($result){
            $_SESSION['msg'] = 'Remove successful';
        } else {
            $_SESSION['msg'] = 'Something went wrong, try later';
        }
        if($_SESSION['login'] == $login){unset($_SESSION['login']);}
        return $result;
    }

    /** queryGetAllAcc creates query to DataBase through PDO and returns result as AssocArray
     * according to options below
     * @param $keyword string - expected some order of characters
     * @param $birth_date string - exp. date YYYY-MM-DD
     * @param $gender string - exp. 'male' or 'female'
     * @param $order string - exp. column name which use for sorting
     * @param $order_type int - exp. type of sorting
     * @param $string_count int - exp. number of strings to return (default = 10)
     * @param $page int -  exp. number of page
     * @return array associative  - result of query
     */
    private function queryGetAllAcc($keyword = '%',$birth_date = '%',$gender = 3,$order = 'birth_date',$order_type = 2,$page,$string_count = 5){
        if ($order == ''){$order='birth_date';}
        $order_up = "ORDER BY $order ASC";
        $order_down = "ORDER BY $order DESC";
        $limit = "LIMIT :limit OFFSET :offset";
        if ($order_type == '1') {
            $order_type = $order_up;
        } else {
            $order_type = $order_down;
        }
        if ($keyword){ $keyword = '%'.$keyword.'%'; }
        else { $keyword = '%';}
        if ($birth_date != 0){ $birth_date = '%'.$birth_date.'%'; }
        else {$birth_date = '%';}
        if ($gender == 3 || $gender == NULL) {$gender = '%';}
        $offset = ($page - 1) * $string_count;
        $sql_query = "SELECT a.login, a.firstname, a.surname, g.g_name, a.birth_date FROM accounts a
                      INNER JOIN gender g ON a.gender = g.g_id
                      WHERE (a.login LIKE :keyword0 OR a.firstname LIKE :keyword1 OR a.surname LIKE :keyword2)
                              AND (a.birth_date LIKE :birth_date AND a.gender LIKE :gender) ".$order_type.' '.$limit;
        $sql_prepared = $this->pdo->prepare($sql_query);
        for($i=0;$i<3;$i++) {
            $sql_prepared->bindValue(":keyword$i", $keyword,  PDO::PARAM_STR);
        }
        $sql_prepared->bindValue(':birth_date',$birth_date, PDO::PARAM_STR);
        $sql_prepared->bindValue(':gender',$gender,PDO::PARAM_INT);
        $sql_prepared->bindValue(':limit', $string_count, PDO::PARAM_INT);
        $sql_prepared->bindValue(':offset', $offset, PDO::PARAM_INT);
        $sql_prepared->execute();
        $result = $sql_prepared->fetchAll();
        return $result;
    }

    /** queryGetOneAcc creates query for return all user info from DataBase through PDO and returns result as ArrayAssoc
     * @param $login string - expected user login
     * @return array associative - returns all information about user
     */
    private function queryGetOneAcc($login){
        $sql_query = "SELECT a.login, a.firstname, a.surname, g.g_name, a.birth_date FROM accounts a INNER JOIN gender g ON a.gender = g.g_id 
                      WHERE login = :login";
        $sql_prepared = $this->pdo->prepare($sql_query);
        $sql_prepared->bindValue(':login',$login,PDO::PARAM_STR);
        $sql_prepared->execute();
        $result = $sql_prepared->fetch();
        return $result;
    }

    /** queryGetOneAcc creates query for return login&password from DataBase through PDO and returns result as ArrayAssoc
     * @param $login string - expected user login
     * @return array associative - returns login&password
     */
    private function queryGetOneAccLight($login){
        $sql_query = "SELECT login, password FROM accounts WHERE login = :login";
        $sql_prepared = $this->pdo->prepare($sql_query);
        $sql_prepared->bindValue(':login',$login,PDO::PARAM_STR);
        $sql_prepared->execute();
        $result = $sql_prepared->fetch();
        return $result;
    }

    /** queryNewAcc creates query for creating new Account to Database through PDO and returns result as Bool
     * @param $login string - login
     * @param $password string - password
     * @param $firstname string - firstname
     * @param $surname string - surname
     * @param $gender int - gender
     * @param $birth_date string - birth date
     * @return bool
     */
    private function queryNewAcc($login,$password,$firstname,$surname,$gender, $birth_date){
        $password = Encrypter::enCrypt($password);
        $values = array($login, $password, $firstname, $surname, $gender, $birth_date);
        $sql_query = "INSERT INTO accounts(login, password, firstname, surname, gender, birth_date) VALUES(?,?,?,?,?,?)";
        $sql_prepared = $this->pdo->prepare($sql_query);
        $result = $sql_prepared->execute($values);
        return $result;
    }

    /** queryNewAcc creates query for editing Account to Database through PDO and returns result as Bool
     * @param $login string - login
     * @param $firstname string - firstname
     * @param $surname string - surname
     * @param $gender int - gender
     * @param $birth_date string - birth date
     * @return bool
     */
    private function queryEditAcc($login,$firstname,$surname,$gender, $birth_date){
        $values = array($firstname, $surname, $gender, $birth_date,$login);
        $sql_query = "UPDATE accounts SET firstname=?, surname=?, gender=?, birth_date=? WHERE login = ?";
        $sql_prepared = $this->pdo->prepare($sql_query);
        $result = $sql_prepared->execute($values);
        return $result;
    }

    /** queryEditPassword creates query for editing password to DataBase throught PDO and returns result as Bool
     * @param $login string - login
     * @param $password string - password
     * @return bool
     */
    private function queryEditPassword($login,$password){
        $password = Encrypter::enCrypt($password);
        $sql_query = "UPDATE accounts SET password = :password WHERE login = :login";
        $sql_prepared = $this->pdo->prepare($sql_query);
        $sql_prepared->bindValue(':password', $password, PDO::PARAM_STR);
        $sql_prepared->bindValue(':login', $login, PDO::PARAM_STR);
        $result = $sql_prepared->execute();
        return $result;
    }

    /** queryRemoveAcc creates query for removing one user from Database through PDO and returns result as Bool
     * @param $login string - login
     * @return bool
     */
    private function queryRemoveAcc($login){
        $sql_query = "DELETE FROM accounts WHERE login = :login";
        $sql_prepared = $this->pdo->prepare($sql_query);
        $sql_prepared->bindValue(':login', $login, PDO::PARAM_STR);
        $result = $sql_prepared->execute();
        return $result;
    }

    /** queryCounter creates query for DataBase through PDO and returns count of records
     * according to options below
     * @param $keyword string
     * @param $birth_date string
     * @param $gender string
     * @return int count
     *
     */
    private function queryCounter($keyword,$birth_date,$gender){
        if ($keyword){ $keyword = '%'.$keyword.'%'; }
        else { $keyword = '%';}
        if ($birth_date){ $birth_date = '%'.$birth_date.'%'; }
        else {$birth_date = '%';}
        if ($gender == 3 || $gender == NULL) {$gender = '%';}
        $sql_query = "SELECT COUNT(login) FROM accounts
                      WHERE (login LIKE :keyword0 OR firstname LIKE :keyword1 OR surname LIKE :keyword2)
                              AND (birth_date LIKE :birth_date AND gender LIKE :gender)";
        $sql_prepared = $this->pdo->prepare($sql_query);
        for($i=0;$i<3;$i++) {
            $sql_prepared->bindValue(":keyword$i", $keyword,  PDO::PARAM_STR);
        }
        $sql_prepared->bindValue(':birth_date',$birth_date, PDO::PARAM_STR);
        $sql_prepared->bindValue(':gender',$gender,PDO::PARAM_INT);
        $sql_prepared->execute();
        $result = $sql_prepared->fetch();
        $result = $result['COUNT(login)'];
        return $result;
    }
}