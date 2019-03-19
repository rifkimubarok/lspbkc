<?php
class Auth_user {
    protected $_ci;
    private $user ;
    function __construct()
    {
        $this->_ci =&get_instance();
        $this->user = get_session('user');
    }

    public function check()
    {
    	if (isset($this->user->islogin) && $this->user->islogin) {
    		if($this->user->level == 9){
    			return true;
    		}else{
    			redirect(base_url());
    			return false;
    		}
    	}else{
    		redirect(base_url());
    	}
    }
}
