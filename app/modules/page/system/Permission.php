<?php
$scope = 'user'; // Scope

$permission = array(
    '*' => array(
        '*' => array(
            'allow' => true
        )
    ),

    'index' => array(
        '*' => array(
            'allow' => true
        ),
        /*
        'guest' => array(
            'allow' => false,
            'redirect' => url('page','sign_in')
        )
        */
    ),

    'login' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url()
        ),
        'guest' => array(
            'allow' => true,
        )
    ),

    'go_login' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url()
        ),
        'guest' => array(
            'allow' => true,
        )
    ),

    'sign_in' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url()
        ),
        'guest' => array(
            'allow' => true,
        )
    ),

    'go_sign_in' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url()
        ),
        'guest' => array(
            'allow' => true,
        )
    ),

);

/* End of file */