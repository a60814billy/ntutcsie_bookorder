<?php
    $CONFIG['system']['route'] = array(
        'dufault_controller'    => 'index',
        'default_action'        => 'index',
        'post_str'              => '.php',
        'rewrite'               => FALSE
    );
    
    $CONFIG['system']['lib'] = array(
        'mysql'     =>  'lib_mysql',
        'request'   =>  'lib_requests'
    );

    $CONFIG['system']['database'] = array(
        'hostname'  =>  'localhost',
        'username'  =>  'bookorder',
        'password'  =>  'c5VUq9m7rwHZKB88',
        'database'  =>  'bookorder'
    );
    $CONFIG['system']['other'] = array(
        'debug_mode'=>  TRUE
    );
    
?>