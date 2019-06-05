<?php

require_once ROOT.'/models/Account.php';

class AccountController{
    private $acc_obj;
    public function __construct()
    {
        $this->acc_obj = new Account();
    }
    /** actionIndex - needs to transfer data(Array with existing accounts) from Model(Account.php) to View
     * @param $page int - number of page. that needs to be displayed
     * @return true - needs for correct Router.php working
     */
    public function actionIndex($page = 1){
        $results = $this->acc_obj->getAccounts($page,$_POST['keyword'],$_POST['birth_date'],$_POST['gender'],$_POST['order'],$_POST['order_type']);

        $result = $results[0];
        $count = $results[1];

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
        if ($_POST['login']) {
            $msg = $this->acc_obj->signIn($_POST['login']);
        }
        if ($msg === true){
            header('Location: /account');
        }
        require_once ROOT.'/views/account/login.php';
        return true;
    }

    /** actionLogout - handles sign out button */
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
        if ($_POST['login'] && $_POST['password']){
            $msg = $this->acc_obj->newAcc($_POST['login'], $_POST['password'],$_POST['firstname'],$_POST['surname'] ,$_POST['gender'],$_POST['birth_date']);
        }
        if ($msg === true){
            header('Location: /account');
        }
            require_once ROOT . '/views/account/registration.php';
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
        if ($result === false){
            header('Location: /account');
        }
        require_once ROOT.'/views/account/view.php';
        unset($_SESSION['edit_msg']);
        return true;
    }

    /** actionEdit - handles Edit action from View of actionView and Edit records in DataBase through Model
     * @param $login string
     * @return true -//-
     */
    public function actionEdit($login){
        if ($_SESSION['login'] == $login || $_SESSION['login'] == 'root'){
            $this->acc_obj->editAcc($login,$_POST['firstname'],$_POST['surname'],$_POST['gender'],$_POST['birth_date']);
            header("Location: /account/user/$login");
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
        if ($_SESSION['login'] == $login || $_SESSION['login'] == 'root'){
            $this->acc_obj->removeAcc($login);
            header('Location: /account');
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
        if ($_SESSION['login'] == $login || $_SESSION['login'] == 'root'){
            require_once ROOT.'/views/account/editpw.php';
            $this->acc_obj->editPassword($login,$_POST['password']);
        } else {
            header('Location: /account');
        }
        return true;
    }
}
