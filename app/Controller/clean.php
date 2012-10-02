<?php
/**
 *  clean Controller Class
 *
 * @package     Clean chiose Web
 * @subpackage  clean
 * @category	Controller
 * @author      Tpes
 * @link        http://
 */
 
 		
    class cleanController extends OS_Controller{
	
		//建構子
		public function __construct(){
            parent::__construct();
            $this->_opdata['title'] = "掃地時間選擇系統";
			$this->_opdata['editwork'] = 0;
            $this->_opdata['menu'] = array(
					'完成列表'  =>  conver_url('./?controller=clean'),
                    '工作選擇'  =>  conver_url('./?controller=clean&action=edit'),
                    '登出'      =>  conver_url('./?controller=clean&action=logout')
            );
            if($_SESSION['user']['admin']==1){
                $this->_opdata['menu']['系統管理'] = conver_url('./?controller=admin');
                //$this->_opdata['menu']['login as'] = conver_url('?c=clean&a=loginas');
            }

		}
	
		//首頁
		public function index(){
			if(isset($_SESSION['login']) and isset($_SESSION['account'])){
                header("Location:".conver_url("index.php?controller=clean&action=main"));
                exit();
            }
            $this->_opdata['login_url'] = conver_url("./?controller=clean&action=login");
			$this->_opdata['loginname'] = "登入掃地選擇系統";
            $this->showTemplate('book_login');
		}
		//登入
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
                    //if($_SESSION['user']['changepass']==1){
                    //    header("Location:".conver_url("index.php?controller=book&action=chpass"));
                    //    exit;
                    //}else{
                        header("Location:".conver_url("index.php?controller=clean&action=main"));
                        exit;
                    //}
                }else{
                    $this->_opdata['message'] = '帳號或密碼錯誤';
                    $this->index();
                }
            }
        }
		
		//登出
		public function logout(){
            unset($_SESSION['login']);
            unset($_SESSION['account']);
            unset($_SESSION['user']);
            unset($_SESSION['account_id']);
            header("Location:".conver_url("index.php?controller=clean"));
        }
		
		//檢查登入
		private function checklogin(){
            if(!isset($_SESSION['account']) || ($_SESSION['login']!=1) ){
                //if($_SESSION['user']['changepass']==1){
                    //header("Location:".conver_url("index.php?controller=clean&action=chpass"));
                //    exit;
                //}else{
                    header("Location:".conver_url("index.php?controller=clean"));
                    exit;
                //}
            }
        }
		
		//檢查admin
		private function checkadmin(){
            if($_SESSION['user']['admin']!=1){
                header("Location:".conver_url("index.php?controller=clean"));
                exit();
            }
        }
		
		//登入首頁
		public function main(){
            $this->checklogin();
            if(empty($this->_opdata['message'])){
				$this->_opdata['message'] = "請選擇服務項目，或放入紙鈔";
			}
            $this->_model->init();
            $data = $this->_model->_mysql->getAllData('clean_group');
            foreach($data as $key => $value){
                $data[$key]['teammate'] = $this->_model->getCleanGroup($value['id']);
            }
            $this->_opdata['group'] = $data;
            $this->_opdata['now'] = strtotime( date("Y-m-d H:i:s"));
            $this->showTemplate('clean_main');
        }
		
		//編輯工作
		public function edit(){
            $this->checklogin();
						
            if(($this->_opdata['editwork'])==0){
               $this->_opdata['message'] = "目前不開放選擇掃地工作";
            }
		    if( $this->_request->isPost()){
				$check = $this->_request->getPost("check");
				if(empty($check)) {
					$this->_opdata['message'] = "請選擇掃地工作";
				} else {
					$this->_model->init();
					$this->_model->_mysql->query("select * from `clean_choise` WHERE work=$check");
					if($this->_model->_mysql->getNum()<4){
						$this->_model->_mysql->query("delete from `clean_choise` where user_id=$_SESSION[account_id]");
						$adddata = array(
							'user_id' => $_SESSION['account_id'],
							'work' => $check
						);
						$id = $this->_model->_mysql->insert('clean_choise' , $adddata);
						if($id!=0){
							$this->_opdata['message'] = "選擇成功";
							$this->main();
							exit;
						}
					} else {
						$this->_opdata['message'] = "此組人數已達上限，請改選日期";
					}
				}
		    }
		    $this->_model->init();
            $data = $this->_model->_mysql->getAllData('clean_group');
		    $this->_opdata['group'] = $data;
			//$this->_model->init();
			$this->_model->_mysql->query("select work from `clean_choise` WHERE user_id=$_SESSION[account_id]");
			$temp = $this->_model->_mysql->getData();
			$this->_opdata['ccheck'][$temp[work]] = "checked";
            $this->showTemplate('clean_edit');
        }
		
		
		
	}
	
?>