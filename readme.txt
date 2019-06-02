1. Model Account.php
    Contains methods:
# getAccounts - handles request for list of accounts. Returns list of accounts.
# getOneAcc - handles request for list of one accounts's data. Request must contain $login.
    Returns account's data list.
# getOneAccLight - handles request for login&password. Request must contain $login.
    Returns login$password.
# newAcc - handles request for creating account. Request must contain $login&$password.
    Returns action result.
# editAcc - handles request for editing account. Request must contain $login.
    Returns action result.
# editPassword - handles request for editing account's password. Request must contain $login&$password.
    Returns action result.
# removeAcc - handles request for removing account. Request must contain $login.
    Returns action result.
# getCount - handles request for strings count. Request must contain $keyword,$birth_date,$gender
    Returns count of strings.

<-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

2. Controller AccountController.php
    Contains methods:
# actionIndex - Connects getAccounts and /view/index, handles 'filter/sorting' form.
# actionLogin - Handles sign in form.
# actionRegistration - Handles sign up form. Connects newAcc with /view/registration.
# actionView - Connects getOneAcc with /view/view.
# actionEdit - Handles Edit form at /view/view.
# actionRemove - Handles Remove Button at /view/view
# actionEditpw - Handles Edit Password form at /view/editpw.

<-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

3. Major notes.
# DataBase connection settings located in /config/db_cfg.php
# PHP 7.0.8 MySQL 5.5.42 Web-Server Apache 2.2.29
# CSS contains some extra css, that is not necessary because this is
    all CSS from serezhalev.info
# Routes.php contains only Account Routes.
# Working View of code located at serezhalev.info/account
# DataBase dump located in /account.sql
# Root Account's permissions at serezhalev.info/account
    contains login:'root' password'justasimplepw'.
# Root permission contains opportunity to edit all other
    accounts(remove account,edit password,edit user data)

<-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

4.1 .htaccess settings that are set at serezhalev.info  :
AddDefaultCharset utf-8

php_flag display_errors on
php_value error_reporting 0

RewriteEngine on
RewriteBase /

RewriteCond %{HTTPS} !=on
RewriteRule ^/?(.*) https://%{SERVER_NAME}/$1 [R,L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php
RewriteRule ^(.*php)$ index.php

<-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

4.2 .htaccess settings that are set at localhost :
AddDefaultCharset utf-8

RewriteEngine on

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php
RewriteRule ^(.*php)$ index.php

<-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

5. Minor changes.
In technical task was stated that access to all functions should be available
only after login&registration. Due that this is only Test Task, I decided to allow all
users to accounts list because it is "accounts for accounts" and there is no any sense
to block it from all users. But if it is really matters, I will do it by technical task.
I never gonna do same things in Real Project and I am able to strictly follow technical task.

<-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

6. Contacts.
# +79132019677
# vk.com/serezhalev
# thisisdaijas@gmail.com
# serezhalev.info