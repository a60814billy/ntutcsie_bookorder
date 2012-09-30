<?php
    class lib_view{
        public $_viewfile;
        public $_content;
        public $_config;
        public function __construct($config){
            $this->_config = $config;
        }

        public function init( $viewfile , $data ){
            $this->_viewfile=  $viewfile;
            ob_start();
            include( $this->_viewfile);
            if($this->_config['other']['debug_mode']){
                debug_show($_SESSION);
                debug_show($data);    
            }
            $this->_content = ob_get_contents();
            ob_end_clean();
        }

        public function rander(){
            echo $this->_content;
        }
    }

?>