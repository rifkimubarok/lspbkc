<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setlanguage extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function set($lang = null)
    {
    	if($lang == null)
    		set_session("language","indonesia");
    	else set_session("language",$lang);
    	redirect(BASEURL);
    }
}