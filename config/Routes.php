<?php

    return array(
        'news/([0-9]+)$' => 'news/view/$1',
        'news$' => 'news/index',
        'news/page([0-9]+)$' => 'news/index/$1',
        'news/update/([0-9]+)$' => 'news/update/$1',
        'news/newpost$' => 'news/add',
        'mail$' => 'mail/mailtome',
        'layouts/([A-Za-z]+)$'=> 'layout/index/$1',
        'account/login$' => 'account/login',
        'account/logout$' => 'account/logout',
        'account/registration$' => 'account/registration',
        'account/user/([A-Za-z0-9]+)$' => 'account/view/$1',
        'account/user/edit/([A-Za-z0-9]+)$' => 'account/edit/$1',
        'account/user/remove/([A-Za-z0-9]+)$' => 'account/remove/$1',
        'account/user/editpw/([A-Za-z0-9]+)$' => 'account/editpw/$1',
        'account/user/edit$' => 'account/index',
        'account/page([0-9]+)$' => 'account/index/$1',
        'account$' => 'account/index',
        '(.*)php' => 'index/view',
        '\w+' => 'index/view',
        ''=> 'index/view',
    );