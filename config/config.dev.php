<?php
    //路由設定
    $CONFIG['system']['route'] = array(
        'dufault_controller'    => 'book',
        'default_action'        => 'index',
        'post_str'              => '.php',
        'rewrite'               => TRUE
    );
    //需載入之函式庫
    $CONFIG['system']['lib'] = array(
        'mysql'     =>  'lib_mysql',
        'mysqli'    =>  'lib_mysqli',
        'request'   =>  'lib_requests',
        'debug'     =>  'debug',
        'message'   =>  'debug'
    );

    //資料庫設定
    $CONFIG['system']['database'] = array(
        'hostname'  =>  'localhost',
        'username'  =>  'root',
        'password'  =>  '123456',
        'database'  =>  'ntutcsie'
    );

    //其他設定
    $CONFIG['system']['other'] = array(
        'debug_mode'=>  TRUE,
        'sql_engine'=>  'mysqli'
    );


    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT ^ E_NOTICE);
    ini_set("display_errors" , "On");
?>