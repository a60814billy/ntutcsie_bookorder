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
        $query = $this->_model->_mysql->query("select * from shop , shop_product where shop.id = shop_product.shop_id and shop.id = 2");
        while($data = mysql_fetch_assoc($query)){
            $this->_opdata['shop'][] = $data;
        }
        debug_show($this->_opdata);
    }

}