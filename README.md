# 5ibers
DataBase connection configuration located in /config/db_cfg.php 
Connection to DataBase produced by PDO. 
Working version of code located at https://serezhalev.info/account 
CSS contains some extra css..
PHP 7.0.8 MySQL 5.5.42 Web-Server Apache 2.2.29

1. Model Account.php
    Contains methods:
- getAccounts - handles request for list of accounts. 
    Returns list of accounts.
- getOneAcc - handles request for list of one accounts's data. Request must contain $login.
    Returns account's data list.
- getOneAccLight - handles request for login&password. Request must contain $login.
    Returns login$password.
- newAcc - handles request for creating account. Request must contain $login&$password.
    Returns action result.
- editAcc - handles request for editing account. Request must contain $login.
    Returns action result.
- editPassword - handles request for editing account's password. Request must contain $login&$password.
    Returns action result.
- removeAcc - handles request for removing account. Request must contain $login.
    Returns action result.
- getCount - handles request for strings count. Request must contain $keyword,$birth_date,$gender
    Returns count of strings.

<-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

2. Controller AccountController.php
    Contains methods:
- actionIndex - Connects getAccounts and /view/index, handles 'filter/sorting' form.
- actionLogin - Handles sign in form.
- actionRegistration - Handles sign up form. Connects newAcc with /view/registration.
- actionView - Connects getOneAcc with /view/view.
- actionEdit - Handles Edit form at /view/view.
- actionRemove - Handles Remove Button at /view/view
- actionEditpw - Handles Edit Password form at /view/editpw.
