<?php
    $EVN = 'develop';
    //$EVN = 'product';     
    if($EVN == 'develop'){
        include_once "config.dev.php";
    }else{
        include_once "config.pro.php";
    }
?>