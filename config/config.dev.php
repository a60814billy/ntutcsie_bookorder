<?php
    
    $CONFIG['system']['route'] = array(
        'dufault_controller'    => 'index',
        'default_action'        => 'index',
        'post_str'              => '.php',
        'rewrite'               => TRUE
    );
    
    $CONFIG['system']['lib'] = array(
        'mysql'     =>  'lib_mysql',
        'request'   =>  'lib_requests'
    );

    $CONFIG['system']['database'] = array(
        'hostname'  =>  'localhost',
        'username'  =>  'bookorder',
        'password'  =>  '2F9DAmE9HVZ4N6EH',
        'database'  =>  'bookorder'
    );
    $CONFIG['system']['other'] = array(
        'debug_mode'=>  TRUE
    );
    
?>