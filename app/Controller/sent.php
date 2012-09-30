<?php
class sentController extends OS_Controller{
    
    public function __construct(){
        parent::__construct();
        if($_SESSION['user']['admin']==0){
            header("Location:".conver_url('./controller=book'));
        }
    }

    public function index(){
        $this->_model->init();
    }

}