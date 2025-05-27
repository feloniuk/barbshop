<?php
$scope = 'user'; // Scope

$permission = array(
    '*' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url('panel','login')
        ),
        'moder' => array(
            'allow' => true
        ),
        'admin' => array(
            'allow' => true
        ),
        'superadmin' => array(
            'allow' => true
        ),
        'master' => array(
            'allow' => true
        )
    ),

    'login' => array(
        '*' => array(
            'allow' => true
        ),
        'user' => array(
            'allow' => true,
        ),
        'moder' => array(
            'redirect' => url('panel')
        ),
        'admin' => array(
            'allow' => false,
            'redirect' => url('panel')
        ),
        'master' => array(
            'allow' => false,
            'redirect' => url('panel')
        ),
    ),

    'restore_password' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url('panel')
        ),
        'user' => array(
            'allow' => true,
        ),
        'guest' => array(
            'allow' => true,
        )
    ),

    'restore_process' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url('panel')
        ),
        'user' => array(
            'allow' => true,
        ),
        'guest' => array(
            'allow' => true,
        )
    ),
);

/* End of file */