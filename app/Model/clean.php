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
    class cleanModel extends OS_Model{
		
		
		
		//µn¤J§PÂ_
		public function login($username , $password){
            $this->init();
            $this->_mysql->query("select * from `user` WHERE `account`='$username' and `password`='$password'");
            return $this->_mysql->getNum();
        }
		
		public function getCleanGroup($id){
            $this->init();
            $sql = "SELECT * FROM user a LEFT join clean_choise b on a.id = b.user_id WHERE b.work=$id";
            $this->_mysql->query($sql);
            if($this->_mysql->getNum()>0){
                while($rs = mysql_fetch_assoc($this->_mysql->query)){
                    $tmp[] = $rs;
                }    
            }
            return $tmp;
        }
	}
	
	
?>