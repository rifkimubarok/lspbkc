<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
    }

    public function index()
    {
    	while (isset(get_session('user')->islogin)) {
        	unset_session("user");
        }

       	redirect(base_url());
    }
}