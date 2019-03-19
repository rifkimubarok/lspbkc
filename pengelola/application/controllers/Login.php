<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin)
        {
            if($user->level == 9){
                header("Location:".BASEURL."Home");
            }else{
                redirect(BASE);
            }
        }
    }

    public function index()
    {
    	$output['captcha'] = $this->create_captcha();
    	$this->load->view("login",$output);
    }

    function create_captcha()
    {
        $this->load->helper('captcha');
        unset_session("captcha");
        $cap_config = array(
            'img_path' => './' . $this->config->item('captcha_path'),
            'img_url' => BASEURL . $this->config->item('captcha_path'),
            'font_path' => './../assets/captcha/fonts/tes.otf',
            'font_size' => '18',
            'img_width' => 200,
            'img_height' => 56,
            'expiration'    => 300,
            'word_length'   => 4,
            'font_size'     => 24,
            'ip_address' => $this->input->ip_address(),
            'img_id'        => 'captcha_image',
            'pool'          => '0123456789',
            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(79, 135, 36)
            )
        );
        $cap = create_captcha($cap_config);
        // Save captcha params in session
        $data = new myObject();
        $data->word = $cap['word'];
        $data->image = $cap['image'];
        set_session('captcha',$data);
        return $data;
    }

    public function do_login()
    {
    	$username = clean(get_post_text("username"));
    	$password = md5(sha1(clean(get_post_text("password"))));
    	$security_code = get_post("security_code");
    	$data = array("username"=>$username,"password"=>$password);
    	if($this->check_captcha($security_code)){
    		$this->load->model('model_data',"data");
    		$hasil = $this->data->do_login($data);
    		echo json_encode($hasil);
    	}else{
    		echo json_encode(array("status"=>false,"message"=>"Wrong Security Code"));
    	}

    }

    private function check_captcha($word)
    {
    	$data = get_session("captcha");
    	if($data->word == $word){
            unset_session("captcha");
    		return 1;
    	}
    	return 0;
    }

    function refresh_captcha()
    {
        $this->load->helper('captcha');
        unset_session("captcha");
        $cap_config = array(
            'img_path' => './' . $this->config->item('captcha_path'),
            'img_url' => BASEURL . $this->config->item('captcha_path'),
            'font_path' => './../assets/captcha/fonts/tes.otf',
            'font_size' => '25',
            'img_width' => 200,
            'img_height' => 56,
            'expiration'    => $this->config->item('captcha_width'),
            'word_length'   => 4,
            'font_size'     => 24,
            'ip_address' => $this->input->ip_address(),
            'img_id'        => 'captcha_image',
            'pool'          => '0123456789',
            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(79, 135, 36)
            )
        );
        $cap = create_captcha($cap_config);
        // Save captcha params in session
        $data = new myObject();
        $data->word = $cap['word'];
        $data->image = $cap['image'];
        set_session('captcha',$data);
        echo $data->image;
    }
}