<?php
/**
 *  book Controller Class
 *
 * @package     Book Order Web
 * @subpackage  book
 * @category	Controller
 * @author      Raccoon
 * @link        http://haraguroi-raccoon.blogspot.tw/
 */
    class bookController extends OS_Controller{

        /**
         *建構子
         *
         *@access   public
         *
         */
        public function __construct(){
            parent::__construct();
            $this->_opdata['title'] = "圖書訂購系統";
            $this->_opdata['menu'] = array(
                    '訂單修改'  =>  conver_url('./?controller=book&action=edit'),
                    '登出'      =>  conver_url('./?controller=book&action=logout')
            );
            if($_SESSION['user']['admin']==1){
                $this->_opdata['menu']['系統管理'] = conver_url('./?controller=admin');
                $this->_opdata['menu']['login as'] = conver_url('./?controller=book&action=loginas');
            }

        }

        /**
         *登入表單
         *
         *@access   public
         *
         */
        public function index(){
            if(isset($_SESSION['login']) and isset($_SESSION['account'])){
                header("Location:".conver_url("index.php?controller=book&action=main"));
                exit();
            }
            $this->_opdata['login_url'] = conver_url("./?controller=book&action=login");
            $this->showTemplate('book_login');
        }

        /**
         *登入
         *
         *@access   public
         *
         */
        public function login(){
            if( $this->_request->isPost()){

                $account = addslashes($this->_request->getPost("account"));
                $password = addslashes( $this->_request->getPost("password"));
                $password = md5(sha1(md5($password)));
                if($this->_model->login($account,$password)==1){
                    $_SESSION['login'] = 1;
                    $_SESSION['account'] = $account;
                    $_SESSION['user'] = $this->_model->_mysql->getData();
                    $_SESSION['account_id'] = $_SESSION['user']['id'];
                    echo "ch : ".$_SESSION['user']['changepass'];
                    if($_SESSION['user']['changepass']==1){
                        header("Location:".conver_url("./index.php?controller=book&action=chpass"));
                        exit;
                    }else{
                        header("Location:".conver_url("./index.php?controller=book&action=main"));
                        exit;
                    }
                }else{
                    $this->_opdata['message'] = '帳號或密碼錯誤';
                    $this->index();
                }
            }
        }

        /**
         *
         *
         *
         */
        public function loginas(){
            $this->checklogin();
            $this->checkadmin();
            $this->_opdata['form_url'] = conver_url("./index.php?controller=book&action=dologinas");
            $this->showTemplate('book_loginas');
        }
        public function dologinas(){
            $id = $this->_request->getPost('account_id');
            $this->_model->init();
            $this->_model->_mysql->query("select * from `user` WHERE account='$id'");
            if($this->_model->_mysql->getNum()==1){
                $_SESSION['account'] = $id;
                $_SESSION['user'] = $this->_model->_mysql->getData();
                $_SESSION['account_id'] = $_SESSION['user']['id'];
                $_SESSION['user']['admin'] = 1;
                header("Location:".conver_url("./index.php?controller=book&action=main"));
            }else{
                $this->_opdata['message'] = "找不到使用者";
                $this->_opdata['form_url'] = conver_url("./?controller=book&action=dologinas");
                $this->showTemplate('book_loginas');
            }
        }

        /**
         *修改訂單
         *
         *@access   public
         *
         */
        public function edit(){
            $this->checklogin();
           $this->checklogin();
           $this->_opdata['state'] = array(
                    '0' =>  '訂單已送出(可修改)',
                    '1' =>  '訂單處理中(不可修改)',
                    '2' =>  '已領書'
           );
           
           $this->_opdata['orders'] = $this->_model->getOrder();
           if(count($this->_opdata['orders'])!=0){
               foreach($this->_opdata['orders'] as $key => $value ){
                   $this->_opdata['orders'][$key]['detail'] = $this->_model->getOrderDetail($value['id']);
               }
           }

           if(count($this->_opdata['orders'])==0){
               $this->_opdata['message'] = "無訂單";
           }
           $this->showTemplate('book_edit');
        }

        public function editorder(){
            $this->checklogin();
            $id = $this->_request->getQuery('id');
            if($this->_model->getOneOrder($id) ==1 ){
                $this->_opdata['order'] = $data = $this->_model->_mysql->getData();
                $this->_opdata['order']['detail'] = $this->_model->getOrderDetail($data['id']);
                $this->_opdata['now'] = date('Y-m-d h:i:s');
                $this->_opdata['shop'] = $this->_model->getShopData($data['shop_id']);
                $this->_opdata['book_list'] = $this->_model->getShopBook($data['shop_id']);

                foreach($this->_opdata['book_list'] as $key => $value){
                    $flag = FALSE;
                    foreach($this->_opdata['order']['detail'] as $value2){
                        if($value['book_id'] == $value2['book_id']){
                            $flag=TRUE;
                            break;
                        }
                    }
                    if($flag==TRUE){
                        $this->_opdata['book_list'][$key]['check']="checked=\"checked\"";
                    }else{
                        $this->_opdata['book_list'][$key]['check'] = "";   
                    }
                }

                $this->_opdata['edit_url'] = conver_url("./?controller=book&action=doeditorder");
                $this->showTemplate('book_editOrder');
            }else{
                $this->_opdata['message'] = "該筆訂單無法修改；或是找不到訂單";   
            }
        }
        public function doeditorder(){
            $this->checklogin();
            $id = $this->_request->getPost('orderid');
            if(!preg_match('/^[0-9]+$/' , $id)){
                throw new Exception('haha');
                exit();
            }
            if($this->_model->getOneOrder($id)==1){
                $this->_model->doeditorder($id , $this->_request->getPost('order',FALSE));
            }
            header("Location:".conver_url("index.php?controller=book&action=edit"));
        }
        /**
         *修改密碼
         *
         *@access public
         *
         */
         public function chpass(){
             $this->checklogin();
             $this->_opdata['do_chpass'] = conver_url('./?controller=book&action=dochpass');
             $this->showTemplate('user_ch_pass');
         }
         public function dochpass(){
             $this->checklogin();
             $p1 = $this->_request->getPost('pass');
             $p2 = $this->_request->getPost('current_pass');
             if(empty($p1) or empty($p2)){
                 $this->_opdata['message'] = "密碼不能空白";
                 $this->showTemplate('user_ch_pass');
                 exit();
             }
             if($p1 != $p2 ){
                 $this->_opdata['message'] = '兩次輸入密碼不一樣！';
                 $this->showTemplate('user_ch_pass');
                 exit();
             }else{
                 $this->_model->chpass($p1);
             }
             header("Location:".conver_url("./index.php?controller=book&action=main"));
         }
        
        /**
         *清除訂單
         *
         *@access   public
         *
         */
        public function clear(){
           //$this->_model->clearOrder();
           header("Location:".conver_url("./index.php?controller=book&action=main"));
        }

        /**
         *登出
         *
         *@access   public
         *
         */                
        public function logout(){
            unset($_SESSION['login']);
            unset($_SESSION['account']);
            unset($_SESSION['user']);
            unset($_SESSION['account_id']);
            header("Location:".conver_url("index.php"));
        }

        /**
         *檢查是否登入，未登入轉道登入畫面
         *順便執行更改密碼
         *@access   private
         *
         */
        private function checklogin(){
            if(!isset($_SESSION['account']) || ($_SESSION['login']!=1) ){
                if($_SESSION['user']['changepass']==1){
                    header("Location:".conver_url("./index.php?controller=book&action=chpass"));
                    exit;
                }else{
                    header("Location:".conver_url("./index.php"));
                    exit;
                }
            }
        }
        private function checkadmin(){
            if($_SESSION['user']['admin']!=1){
                header("Location:".conver_url("index.php"));
                exit();
            }
        }
        
        /**
         *主頁面
         *
         *@access   public
         *
         */
        public function main(){
            $this->checklogin();

            $this->_opdata['message'] = "如果看到本頁是空的，代表已經有訂單了。請到\"訂單修改\"修改。";

            $this->_model->init();
            $data = $this->_model->_mysql->getAllData('shop');
            foreach($data as $key => $value){
                $data[$key]['book_list'] = $this->_model->getShopBook($value['id']);
                $data[$key]['order_num'] = $this->_model->getOrderInformation($value['id']);
            }
            //debug_show($data);
            $this->_opdata['shop'] = $data;
            $this->_opdata['order_url'] = conver_url('./?controller=book&action=order');
            $this->_opdata['now'] = strtotime( date("Y-m-d H:i:s"));
            /*
            if($num!=0){
                $this->_opdata['message'] = "訂單已存在，請點選 <a href=\"./?controller=book&action=edit\" >\"修改訂單\"</a> 修改。";
            }else{
                
                $this->_opdata['shop'] = $this->_model->getShopData($this->shop_id);

                if( $this->_opdata['now'] > $this->_opdate['shop']['start_time'] ){
                    $this->_opdata['order_url'] = './?controller=book&action=order';
                    $this->_opdata['book_list'] = $this->_model->getShopBook($this->shop_id);    
                }else{
                    $this->_opdata['message'] = "訂購時間已過";
                }
                
            }*/
            $this->showTemplate('book_main');
        }
        
        /**
         *run 訂購
         *
         *@access   public
         *
         */
        public function order(){
            $this->checklogin();
            $this->_opdata['message'] = $this->_model->order( $this->_request->getPost('shop_id') ,  $this->_request->getPost('order' , FALSE));
            $this->showTemplate('book_main');
        }
    }