<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
        $this->load->model("model_data","data");
        $output['user'] = $this->data->get_user_data();
    	$this->template->display("users",$output);
    }

    public function reset_pw()
    {
        $id = get_post("member_id");
        $this->load->model("model_data","data");
        $hasil = $this->data->reset_pw_user($id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function blok_user()
    {
        $id = get_post("member_id");
        $status = get_post("status");
        $data = array("blokir"=>$status);
        $this->load->model("model_data","data");
        $hasil = $this->data->blok_user($data,$id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }
}