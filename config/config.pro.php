<?php
    $CONFIG['system']['route'] = array(
        'dufault_controller'    => 'index',
        'default_action'        => 'index',
        'post_str'              => '.php',
        'rewrite'               => TRUE
    );
    
    $CONFIG['system']['lib'] = array(
        'mysql'     =>  'lib_mysql',
        'request'   =>  'lib_requests'
    );

    $CONFIG['system']['database'] = array(
        'hostname'  =>  'localhost',
        'username'  =>  'ntutcsie',
        'password'  =>  'ntut',
        'database'  =>  'ntutcsie'
    );
    $CONFIG['system']['other'] = array(
        'debug_mode'=>  FALSE
    );
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set("display_errors" , "Off");
?>