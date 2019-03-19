<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function verifikasi()
    {
    	$username = trim(clean(get_post_text("username")));
    	$password = trim(clean(get_post_text("password")));
    	$captha = trim(clean(get_post_text("captha")));
    	if($this->check_captcha($captha)){
    		$data = array("username"=>$username,"password"=>md5(sha1($password)));
    		$this->load->model("model_login","auth");
    		$hasil = $this->auth->auth($data);
    		echo json_encode($hasil);
    	}else{
    		echo json_encode(array("status"=>false,"message"=>"Kode Keamanan Salah."));
    	}

        /*echo json_encode($this->check_captcha($captha));*/

    }

    private function check_captcha($word)
    {
    	$data = get_session('captcha_login');
    	if(isset($data->word) && $data->word == $word){
    		$check = new myObject();
    		unset_session('captcha_login');
    		return 1;
    	}
    	unset_session('captcha_login');
    	return 0;
    }

    public function check_chaptca()
    {
        $data = get_session('captcha_login');
        echo json_encode($data);
    }
}