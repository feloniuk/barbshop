<?php
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
    ),
);

/* End of file */