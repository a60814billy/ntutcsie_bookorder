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
        'username'  =>  'bookorderUcubl',
        'password'  =>  'S$@{|{qIdQyH',
        'database'  =>  'bookorder'
    );
    $CONFIG['system']['other'] = array(
        'debug_mode'=>  TRUE
    );
    ini_set("display_errors" , "On");
    error_reporting(E_ALL & ~E_NOTICE)
?>