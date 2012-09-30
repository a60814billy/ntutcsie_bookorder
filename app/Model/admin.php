<?php
/**
 *  admin Model Class
 *
 * @package     Book Order Web
 * @subpackage  admin
 * @category	Model
 * @author      Raccoon
 * @link        http://haraguroi-raccoon.blogspot.tw/
 */    
    class adminModel extends OS_Model{
                               
        public function adduser($data){
            $this->init();
            return $this->_mysql->insert('user' , $data);
        }
        public function addbook($data){
            $this->init();
            return $this->_mysql->insert('book' , $data);
        }

        public function getShop(){
            $this->init();
            return $this->_mysql->getAllData('shop');
        }

        public function getAllBook(){
            $this->init();
            return $this->_mysql->getAllData('book');
        }
        
        public function getShopByID($id){
            $this->init();
            $this->_mysql->query("SELECT * FROM `shop` WHERE id=$id");
            return $this->_mysql->getData();
        }

        public function getshoplist($id){
            $this->init();
            $sql = "SELECT * FROM book a LEFT JOIN (SELECT * from shop_product WHERE shop_id=$id) b on a.id = b.book_id ;";
            $this->_mysql->query($sql);
            while($rs = mysql_fetch_assoc($this->_mysql->query)){
                if(!empty($rs['shop_id'])){
                    $rs['check'] = 'checked=\"checked\"';
                }else{
                    $rs['check'] = '';
                }
                $data[] = $rs;
            }
            return $data;
        }
        
        public function editshop($updata , $pro){
            $this->init();
            $this->_mysql->update('shop' , $updata);
            $this->_mysql->query("DELETE from `shop_product` WHERE `shop_id`=".$updata['id']);
            foreach($pro as $value){
                if(preg_match('/^[0-9]+$/' , $value)){
                    $data = array(
                        'shop_id'   =>  $updata['id'] , 
                        'book_id'   =>  $value
                    );
                    $this->_mysql->insert('shop_product' , $data);
                }
            }
        }

    }
?>