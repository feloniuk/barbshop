<?php
$permission = array(
    '*' => array(
        '*' => array(
            'allow' => false,
            'redirect' => url('panel','login')
        ),
        'superadmin' => array(
            'allow' => true
        )
    ),
);

/* End of file */