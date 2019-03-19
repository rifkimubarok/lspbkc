<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemaps extends CI_Controller {

	function __construct(){
        parent::__construct();
    }

    public function index()
    {
    	 $this->load->model("model_data","data");
    	 $hasil['items'] = $this->data->get_sitemap();
    	 $this->load->view("sitemap",$hasil);
    }
}