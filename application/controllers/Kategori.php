<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function get_kategori()
    {
    	$this->load->model("model_data","data");
        $hasil = $this->data->get_kategori();
        if($hasil){
            echo json_decode($hasil);
        }
    }

}