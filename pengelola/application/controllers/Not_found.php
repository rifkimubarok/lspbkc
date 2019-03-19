<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Not_found extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
        $this->template->display("not_found");
    }
}