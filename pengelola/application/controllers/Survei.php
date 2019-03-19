<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	$this->template->display("survei/index");
    }

    public function get_pie_survei()
    {
    	$kepuasan = array("","Puas","Netral","Tidak Puas");
    	$this->load->model("model_data","data");
    	$hasil = $this->data->get_pie_survei();
    	$output = array();
    	foreach ($hasil as $item) {
    		$row = array("name"=>$kepuasan[$item->kepuasan],"y"=>intval($item->jumlah));
    		$output[] = $row;
    	}
    	echo json_encode(array("data"=>$output));
    }

}

?>