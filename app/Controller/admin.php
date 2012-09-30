<?php
/**
 *  admin Controller Class
 *
 * @package     Book Order Web
 * @subpackage  admin
 * @category	Controller
 * @author      Raccoon
 * @link        http://haraguroi-raccoon.blogspot.tw/
 */    
    class adminController extends OS_Controller{

        public function __construct(){
            parent::__construct();
            $this->_opdata['title'] = "訂書系統-管理";

            $ip = $_SERVER['REMOTE_ADDR'];
            
            if($_SESSION['user']['admin']==1){

            }else{
                if(($ip!="127.0.0.1") and ($ip!="::1") ){
                    header("Location:".conver_url('index.php'));
                }
            }
            $_SERVER['now'] = date('Y-m-d H:i:s');
            $this->_opdata['menu'] = array(
                '新增使用者'     =>  conver_url('./?controller=admin&action=adduser'),
                '新增使用者(CSV)'=>  conver_url('./?controller=admin&action=addusercsv'),
                '修改使用者'     =>  conver_url('./?controller=admin&action=edituser'),
                '新增書籍'       =>  conver_url('./?controller=admin&action=addbook'),
                '新增商店'       =>  conver_url('./?controller=admin&action=addshop'),
                '修改商店'       =>  conver_url('./?controller=admin&action=editshop'),
                '顯示訂單'       =>  conver_url('./?controller=admin&action=showorder')
            );
        }
        
        public function index(){
            debug_show($_SERVER);
            $this->showTemplate('admin');
        }

        public function showorder(){
            $this->_model->init();
            
            $this->_opdata['shop'] = $this->_model->_mysql->getAllData('shop');
            $this->_opdata['form_url'] = conver_url('./?controller=admin&action=showorderbyshop');
            $this->showTemplate('admin_show_order_select_shop');
            
        }
        public function showorderbyshop(){
            $id = $this->_request->getPost('shop');
            $this->_model->init();
            $this->_model->_mysql->query("select * from shop_product WHERE shop_id=$id");
            while($data = mysql_fetch_array($this->_model->_mysql->query)){
                $this->_opdata['shop'][] = $data;
            }

            foreach($this->_opdata['shop'] as $key => $value){
                $this->_model->_mysql->query("SELECT count(*) from order_detail where book_id=".$value['book_id']);
                $this->_opdata['shop'][$key]['num'] = $this->_model->_mysql->getData();
                $this->_model->_mysql->query("SELECT * from book where id=".$value['book_id']);
                $this->_opdata['shop'][$key]['book'] = $this->_model->_mysql->getData();
            }
            
            $query = $this->_model->_mysql->query("SELECT `order`.id , `order`.shop_id , user.account , user.username , `order`.book_quantity , `order`.sall_count , `order`.state from `order` , `user` WHERE `order`.`user_id` = `user`.`id` and `order`.shop_id =$id order by `order`.id asc");
            while($data = mysql_fetch_assoc($query)){
                $this->_opdata['order_list'][] = $data;    
            }
            
            foreach($this->_opdata['order_list'] as $key => $value ){
                $query = $this->_model->_mysql->query("SELECT book.* from `order_detail`,`book` WHERE `book`.id = `order_detail`.book_id and order_id=".$value['id']);
                while($data = mysql_fetch_assoc($query)){
                    $this->_opdata['order_list'][$key]['detail'][] = $data;
                }
            }

            $this->showTemplate('admin_show_order');
        }

        public function addusercsv(){
            $this->_opdata['do_addusercsv_url'] = conver_url('./?controller=admin&action=doaddusercsv');
            $this->showTemplate('admin_addusercsv');
        }

        public function doaddusercsv(){
            debug_show($_FILES);
            $f = fopen($_FILES['file']['tmp_name'] , 'r' );

            while($csv = fgetcsv($f , $_FILES['file']['size'])){
                $data = array(
                    'account'       =>  (int) trim($csv[0]),
                    'password'      =>  md5(sha1(md5(trim($csv[2])))) ,
                    'username'      =>  trim($csv[1]),
                    'birth'         =>  (int) trim($csv[2]),
                    'changepass'    =>  (int) trim($csv[3]),
                    'admin'         =>  (int) trim($csv[4])
                );
                $this->_model->adduser($data);
                echo $this->_model->_mysql->sql."..OK<br />";
            }
            fclose($f);
            header("Location:".conver_url("index.php?controller=admin"));
        }

        public function edituser(){
            $this->_model->init();
            $this->_opdata['users'] = $this->_model->_mysql->getAllData('user');
            $this->showTemplate('admin_editUser');
        }
        public function edituser2(){
            $this->_model->init();
            $this->_model->query("SELECT * from `user` WHERE id=".$this->_request->getQuery('id'));
            $data = $this->_model->getData();
            $this->showTemplate('admin_editUser');
        }

        public function addshop(){
            $this->_opdata['addshop_url'] = conver_url('./?controller=admin&action=doaddshop');
            $this->_opdata['book_lsit'] = $this->_model->getAllBook();
            $this->showTemplate('admin_addshop');
        }
        public function doaddshop(){
            //debug_show($_POST);
            $name = $this->_request->getPost('name');
            $start = $this->_request->getPost('start_time');
            $terr = $this->_request->getPost('terr_time');
            $pro = $this->_request->getPost('product' , FALSE);
            $data = array(
                'name'  =>  $name,
                'start_time'    => $start,
                'terr_time' => $terr
            );
            
            if(count($pro)==0){
                throw new Expcetion('Haha');
                exit();
            }

            $this->_model->init();
            $id = $this->_model->_mysql->insert('shop' , $data);

            foreach($pro as $value){
                $this->_model->_mysql->query("INSERT into `shop_product`(`shop_id` , `book_id`) VALUES('$id','$value')");
            }   
            header("Location:".conver_url('index.php?controller=admin'));
        }
        public function editshop(){
            $this->_opdata['editshop_url'] = conver_url('./?controller=admin&action=editshopdetail');
            $this->_opdata['shop'] = $this->_model->getShop();
            $this->showTemplate('admin_EditShop');
        }
        public function editshopdetail(){
            $shop_id = $this->_request->getPost('shop_id');
            if(!preg_match('/^[0-9]+$/' , $shop_id)){
                throw new exception('Shop ID Error');
            }
            $shop['data'] = $this->_model->getShopByID($shop_id);
            $shop['info'] = $this->_model->getShoplist($shop_id);
            $this->_opdata['shop'] = $shop;
            $this->_opdata['editshop_url'] = conver_url("./?controller=admin&action=doeditshop");
            $this->showTemplate('admin_editshop2');
        }

        public function doeditshop(){
            $updata = array(
                'id' =>  $this->_request->getPost('id'),
                'name'  => $this->_request->getPost('name'),
                'start_time'    => $this->_request->getPost('start_time'),
                'terr_time' =>  $this->_request->getPost('terr_time')
            );
            $this->_model->editshop($updata ,$this->_request->getPost('product' , FALSE));
            header("Location:".conver_url("index.php?controller=admin"));
        }

        public function addbook(){
            $this->_opdata['addBook_url'] = conver_url('./?controller=admin&action=doaddbook');
            $this->showTemplate('admin_AddBook');
        }
        public function doaddbook(){
            $bookname = $this->_request->getPost('name');
            $classname =$this->_request->getPost('class');
            $origin = $this->_request->getPost('origin');
            $sall = $this->_request->getPost('sall');

            $data = array(
                'name'  =>$bookname,
                'class_name' =>  $classname,
                'origin_price'  => $origin,
                'sall_price'    =>  $sall
            );
            echo "ID : ".$this->_model->addbook($data);
            echo $this->_model->_mysql->sql;
            echo "<br />新增成功";
        }

        public function adduser(){
            $this->_opdata['addUser_url'] = conver_url("./?controller=admin&action=addusering");
            $this->showTemplate('admin_AddUser');
        }

        public function addusering(){
            $account = $this->_request->getPost('account');
            $password = $this->_request->getPost('password');
            $username = $this->_request->getPost('UserName');
            $change = (int)$this->_request->getPost('changePassword');
            $data = array(
                'account'   =>  $account,
                'password'  =>  md5(sha1(md5($password))),
                'username'  =>  $username,
                'changepass'=>  $change
            );
            $this->_model->adduser($data);
            echo "加入成功";
        }
    } 

?>