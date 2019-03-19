<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function index()
    {
        $data['title'] = "Kontak Kami";
    	$this->template->display("kontak/index",$data);
    }

    public function kirim_pesan()
    {
    	$nama = htmlspecialchars(clean(get_post_text("nama")));
    	$subject = htmlspecialchars(clean(get_post_text("subjek")));
    	$email = htmlspecialchars(clean(get_post_text("email")));
    	$pesan = htmlspecialchars(clean(get_post_text("pesan")));

    	$data = array("nama"=>$nama,"subjek"=>$subject,"email"=>$email,"pesan"=>$pesan);
    	$this->load->model("model_data","data");
    	$hasil = $this->data->send_message($data);
    	if($hasil){
    		echo json_encode(array("status"=>true));
    	}
    }

    public function masukan_saran()
    {
        $data['title'] = "Masukan Saran";
        $this->template->display("kontak/masukan_saran",$data);
    }
}
