<?php
/**
 *  book Model Class
 *
 * @package     Book Order Web
 * @subpackage  book
 * @category	Model
 * @author      Raccoon
 * @link        http://haraguroi-raccoon.blogspot.tw/
 */
    class bookModel extends OS_Model{
        

        public $account_id;

        /**
         *確認訂單是否存在
         *
         *@access   public
         *@param    int $shop_id
         *@return   int
         */
        public function getOrderInformation($shop_id){
            $this->init();
            $sql = "select * from `order` WHERE user_id='".$_SESSION['account_id']."' and shop_id=$shop_id";
            $this->_mysql->query($sql);
            return $this->_mysql->getNum();
        }

        /**
         *登入
         *
         *@access   public
         *@param    string $username , $password
         *@return   int
         */
        public function login($username , $password){
            $this->init();
            $this->_mysql->query("select * from `user` WHERE `account`='$username' and `password`='$password'");
            return $this->_mysql->getNum();
        }

        /**
         *更改密碼
         *
         *@access   public
         *@param    string $password
         *@return   int
         */
        public function chpass($password){
            $this->init();
            $data = array(
                'id'        =>  $_SESSION['account_id'],
                'password'  =>  md5(sha1(md5($password))),
                'changepass'=>  0
            );
            $this->_mysql->update('user' , $data);
        }

        /**
         *取得商店資料
         *
         *@access   public
         *@param    int $id
         *@return   array shopData
         */
        public function getShopData($id){
            $this->init();
            $this->_mysql->query("SELECT * from `shop` WHERE id=$id");
            return $this->_mysql->getData();
        }

        /**
         *清除所有訂單 
         *Debug用
         *@access   public
         *@param    
         *@return   
         */
        public function clearOrder(){
            $this->init();
            $sql = "TRUNCATE TABLE `order`";
            $this->_mysql->query($sql);
            $sql = "TRUNCATE TABLE `order_detail`";
            $this->_mysql->query($sql);
            return ;
        }

        /**
         *取得商店販售書籍資料
         *
         *@access   public
         *@param    int $id
         *@return   array books
         */
        public function getShopBook($id){
            $this->init();
            $sql = "SELECT * FROM shop_product a LEFT join book b on a.book_id = b.id WHERE a.shop_id=$id ";
            $this->_mysql->query($sql);
            if($this->_mysql->getNum()>0){
                while($rs = mysql_fetch_assoc($this->_mysql->query)){
                    $tmp[] = $rs;
                }    
            }
            return $tmp;
        }

        /**
         *取得所有書籍資料
         *
         *@access   public
         *@param    
         *@return   array Books
         */
        public function getAllBook(){
            $this->init();
            return $this->_mysql->getAllData('book');
        }


        /**
         *取得單一訂單資訊(include order order_detail book)
         *
         *@access   public
         *@param    int $order id
         *@return   array data
         */
         function getOneOrder($id){
             $this->init();
             $this->_mysql->query("SELECT * from `order` WHERE id=$id and user_id ={$_SESSION['account_id']}  and state=0");
             return $this->_mysql->getNum();
         }
        
        /**
         *取得所有訂單資訊
         *
         *@access   public
         *@param    int $shop_id
         *@return   array data
         */        
        public function getOrder(){
            $this->init();
            $this->_mysql->query("select `order`.* , shop.name as shop_name from `order` , `shop` WHERE `order`.shop_id = shop.id and `user_id`=".$_SESSION['account_id']);
            while($rs = mysql_fetch_assoc($this->_mysql->query)){
                $data[] = $rs;
            }
            return $data;
        }

        /**
         *取得訂單詳細資料
         *
         *@access   public
         *@param    int $order id
         *@return   array data
         */       
         public function getOrderDetail($id){
             $this->init();
             $this->_mysql->query("select `order_detail`.* , book.name , book.class_name from `order_detail` , book where `order_detail`.book_id = book.id and order_detail.order_id =$id");
             while($rs = mysql_fetch_assoc($this->_mysql->query)){
                 $data[] = $rs;
             }
             return $data;
         }

        /**
         *訂購~
         *
         *@access   public
         *@param    int $shop_id , array $list
         *@return   String 結果
         */
        public function order($shop_id , $list){
            $this->init();
            if(!preg_match("/^[0-9]{1,2}$/" , $shop_id)){
                $result = "Error!";
                return $result;
            }
            if(count($list)==0){
                $result = "請選擇訂購項目！";
                return $result;
            }
            $flag = FALSE;
            $quantity = 0;
            $price = 0;
            $ori_price = 0;
            //檢查變數
            foreach($list as $key => $value){
                if(!preg_match('/^[0-9]{1,2}$/' , $value)){
                    $list[$key] = "";
                }else{
                    $quantity++;
                    $this->_mysql->query("select * from `book` WHERE `id`=$value");
                    $tmp = $this->_mysql->getData();
                    $ori_price += $tmp['origin_price'];
                    $price += $tmp['sall_price'];
                }
            }
            $adddata = array(
                'shop_id'       => $shop_id,
                'book_quantity' => $quantity,
                'origin_price'  => $ori_price,
                'sall_count'    => $price,
                'user_id'       => $_SESSION['account_id']
            );

            $id = $this->_mysql->insert('order' , $adddata);

            foreach($list as $value){
                if(!empty($value)){
                    $adddata = array(
                        'order_id'  => $id,
                        'book_id'   => $value
                    );
                    $this->_mysql->insert('order_detail' , $adddata);
                }
            }
            $result = "訂購完成：訂單ID : " . $id;
            return $result;
        }

        /**
         *修改訂單~
         *
         *@access   public
         *@param    int $shop_id , array $list
         *@return   String 結果
         */
        public function doeditorder($orderid , $list){
            $this->init();
            if(count($list)==0){
                $this->_mysql->delete('order' , $orderid);
                $this->_mysql->query("delete from `order_detail` WHERE order_id=$orderid");
                header("Location:".conver_url('index.php?controller=book&action=main'));
                exit();
            }
            $this->_mysql->query("delete from `order_detail` WHERE order_id=$orderid");
            $flag = FALSE;
            $quantity = 0;
            $price = 0;
            //檢查變數
            foreach($list as $key => $value){
                if(!preg_match('/^[0-9]{1,2}$/' , $value)){
                    $list[$key] = "";
                }else{
                    $quantity++;
                    $this->_mysql->query("select * from `book` WHERE `id`=$value");
                    $tmp = $this->_mysql->getData();
                    $price += $tmp['sall_price'];
                }
            }
            $updata = array(
                'id'            => $orderid,
                'book_quantity' => $quantity,
                'sall_count'    => $price,
            );
            $this->_mysql->update('order' , $updata);

            foreach($list as $value){
                if(!empty($value)){
                    $adddata = array(
                        'order_id'  => $orderid,
                        'book_id'   => $value
                    );
                    $this->_mysql->insert('order_detail' , $adddata);
                }
            }
            $result = "修改完成：訂單ID  " . $orderid;
            return $result;
        }

    }

?>