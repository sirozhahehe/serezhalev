<?php

include_once ROOT.'/models/Account.php'; // include model
include_once ROOT.'/controllers/MailController.php'; // needs to correct working of mail form located in footer

class AccountController{
    private $acc_obj;
    public function __construct()
    {
        $this->acc_obj = new Account();
        MailController::actionMailtome($_POST['name'],$_POST['email']);
    }
    /** actionIndex - needs to transfer data(Array with existing accounts) from Model(Account.php) to View
     * @param $page int - number of page. that needs to be displayed
     * @return true - needs for correct Router.php working
     */
    public function actionIndex($page = 1){
        if (isset($_POST['keyword'])){
            $_SESSION['keyword'] = $_POST['keyword']; }
        if (isset($_POST['birth_date'])) {
            $_SESSION['birth_date'] = $_POST['birth_date']; }
        if (isset($_POST['gender'])) {
            $_SESSION['gender'] = $_POST['gender']; }
        if (isset($_POST['order'])) {
            $_SESSION['order'] = $_POST['order']; }
        if (isset($_POST['order_type'])) {
            $_SESSION['order_type'] = $_POST['order_type']; }
        $count = $this->acc_obj->getCount($_SESSION['keyword'],$_SESSION['birth_date'],$_SESSION['gender']);
        $result = $this->acc_obj->getAccounts($page,$_SESSION['keyword'],$_SESSION['birth_date'],$_SESSION['gender'],$_SESSION['order'],$_SESSION['order_type']);
        if ($count != 0 && $page > ceil($count/5)){ header('Location: /account');}
        require_once ROOT.'/views/account/index.php';
        unset($_SESSION['msg']); // unset var, that needs to show to user his incorrect action
        unset($_SESSION['edit_msg']); // unset var, that needs to show how successful was Edit
        return true;
    }

    /** actionLogin - handles login's view, takes login&password from view and model, compares it and
     * displays result to User
     * @return true -//-
     */
    public function actionLogin(){
        if (isset($_POST['login'])){
            $result = $this->acc_obj->getLightAcc($_POST['login']);
            $pw = $this->pwEncrypt($_POST['password']);  //encrypting password
            if ($result) {
                if ($pw == $result['password']) {
                    $_SESSION['login'] = $result['login'];
                    header('Location: /account');
                } else {
                    $msg = 'Incorrect data.';
                    require_once ROOT.'/views/account/login.php';
                }
            } else {
                $msg = 'Incorrect data.';
                require_once ROOT.'/views/account/login.php';
            }
        } else {
            require_once ROOT.'/views/account/login.php';
        }
        return true;
    }

    public function actionLogout(){
        unset($_SESSION['login']);
        header('Location: /account');
        return true;
    }

    /** actionRegistration - handles registration's view, takes login from View, trying to find match in DataBase
     * if login from View is unique and between 3 and 15 characters - login&password from View transfer to Model
     * and record in DataBase
     * @return true -//-
     */
    public function actionRegistration(){
        if (isset($_POST['login'])) {
            $result = $this->acc_obj->getLightAcc($_POST['login']);
            if ($result) {
                $msg = 'This login already exists';
                require_once ROOT . '/views/account/registration.php';
            } elseif (preg_match('~^[A-Za-z0-9]{3,15}$~', $_POST['login']) == 0){
                $msg = 'Incorrect login';
                require_once ROOT . '/views/account/registration.php';
            } else {
                $msg = $this->acc_obj->newAcc($_POST['login'], $_POST['password'],$_POST['firstname'],$_POST['surname'],$_POST['gender'],$_POST['birth_date']);
                $_SESSION['login'] = $_POST['login'];
                header('Location: /account');
            }
        } else {
            require_once ROOT . '/views/account/registration.php';
        }
        return true;
    }

    /** actionView - needs to tranfer data(Array with all $login information) from Model to View
     * this View is used for Edit data or Remove User, so only signed in users allowed to only their own accounts
     * only 'root' user can Edit all accounts
     * @param $login string
     * @return true -//-
     */
    public function actionView($login){
        $result = $this->acc_obj->getOneAcc($login);
        if($_SESSION['login'] == $result['login']){
            require_once ROOT.'/views/account/view.php';
        } else {
            $_SESSION['msg'] = 'You have not enough permissions'; //needs to show to user his incorrect action
            header('Location: /account');
        }
        unset($_SESSION['edit_msg']);
        return true;
    }

    /** actionEdit - handles Edit action from View of actionView and Edit records in DataBase through Model
     * @param $login string
     * @return true -//-
     */
    public function actionEdit($login){
        if ($_SESSION['login'] == $login){
            $edit_result = $this->acc_obj->editAcc($login,$_POST['firstname'],$_POST['surname'],$_POST['gender'],$_POST['birth_date']);

            if ($edit_result){
                $_SESSION['edit_msg'] = 'Edit successful'; // needs to show to user status of his action
                header("Location: /account/user/$login");
            } else {
                $_SESSION['edit_msg'] = 'Something went wront, try later';
                header("Location: /account/user/$login");
            }
        } else {
            header('Location: /account');
        }
        return true;
    }
    /** actionRemove - handles Remove action from View and removes Account($login) from DataBase
     * @param $login string
     * @return true -//-
     */
    public function actionRemove($login){
        if ($_SESSION['login'] == $login){
            $rm_result = $this->acc_obj->removeAcc($login);
            if ($rm_result){
                $_SESSION['msg'] = 'Remove successful'; // needs to show to user status of his action
                header("Location: /account");
            } else {
                $_SESSION['edit_msg'] = 'Something went wront, try later';
                header("Location: /account/user/$login");
            }
        } else {
            header('Location: /account');
        }
        return true;
    }

    /** actionRemove - handles Edit Password form from View and changes Password in DataBase
     * @param $login string
     * @return true -//-
     */
    public function actionEditpw($login){

        if ($_SESSION['login'] == $login){
            require_once ROOT.'/views/account/editpw.php';
            if ($_POST['password']){
                $edit_result = $this->acc_obj->editPassword($login,$_POST['password']);
                if ($edit_result){
                    $_SESSION['edit_msg'] = 'Edit successful'; // needs to show to user status of his action
                    header("Location: /account/user/$login");
                } else {
                    $_SESSION['edit_msg'] = 'Something went wront, try later';
                    header("Location: /account/user/$login");
                }
            }
        } else {
            header('Location: /account');
        }
        return true;
    }


    /** Encrypts password, returns result as String
     *@param $password string - password
     *@return string - encrypted password
     */
    private function pwEncrypt($password){
        $result = md5($password);
        $result = substr($result,0,14);
        $result = $result.'lev';
        return $result;
    }
}
