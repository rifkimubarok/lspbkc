<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function index()
    {
    	redirect(base_url());
    }

    public function p()
    {
        $this->load->model("model_data","data");
    	$id = $this->uri->segment(2);
        $output = array();
        $base = "profile";
        $hasil = $this->data->get_halaman($id);;
        if($hasil){
            $output['profile'] = $hasil;
            $output['title'] = $hasil->judul;
            $page = $base."/index";
        }else{
            $page = "not_found";
        }
        $this->template->display($page,$output);
    }

    

    public function p2()
    {
        $this->load->model("model_data","data");
    	$id = $this->uri->segment(3);
        $output = array();
    	$base = "profile";
        if($id == 'struktur-organisasi'){
            $output['title'] = "Struktur Organisasi";
    	    $page = file_exists(VIEWPATH.$base.'/'.$id.'.php') == 1 ? $base.'/'.$id : 'not_found';
        }else{
            $output['profile'] = $this->data->get_profile($id);
            $output['title'] = $output['profile']->judul;
            $page = $base."/index";
        }
    	$this->template->display($page,$output);
    }


    public function get_struktur()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->get_struktur();
        echo json_encode($hasil);
    }

    public function get_anggota_struktur()
    {
        $this->load->model("model_data","data");
        $id = $this->input->post("id");
        $hasil = $this->data->get_anggota_struktur($id);
        $output['data'] = $hasil;
        $this->load->view("profile/anggota_struktur",$output);
    }

}