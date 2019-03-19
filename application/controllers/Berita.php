<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function index()
    {
    	$this->load->model("model_data","data");
    	$this->load->library('pagination');
		$config = array();
        $config["base_url"] = BASEURL . "berita/index";
        $total_row = $this->data->count_berita(1);
        $config["total_rows"] = $total_row;
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp;<a class="active">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
        $page = ($this->uri->segment(3)) ;
          }
        else{
               $page = 1;
        }
        $ofset = ($page - 1) * $config["per_page"];
        $data["berita"] = $this->data->get_berita($ofset,$config["per_page"],null,null,1);
        $str_links = $this->pagination->create_links();
        $data["links"] = /*explode('&nbsp;',$str_links );*/$str_links;
		$output['berita'] = $this->load->view("content/berita.php",$data,true);
        $output['title'] = "Berita";
		$this->template->display("berita/index",$output);
    }

    public function p()
    {
        $this->load->model("model_data","data");
    	$seo_judul = $this->uri->segment(3);
        $komentar['komentar'] = $this->data->get_komentar_berita($seo_judul);
        $output['berita'] = $this->data->get_berita(0,1,$seo_judul);
        $output['_komentar'] = $this->load->view("berita/komentar",$komentar,true);
        $output['title'] = $output['berita'][0]->judul;
        $output['image'] = GAMBAR.'berita/'.$output['berita'][0]->ref;
    	$this->template->display("berita/single_post",$output);
    }

    public function post_komentar()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            $id_berita = get_post("id_berita");
            $komentar = htmlspecialchars(get_post_text("message"));
            $data = array("id_berita"=>$id_berita,"nama_komentar"=>$user->nama,"user_id"=>$user->id,"isi_komentar"=>$komentar);

            $hasil = $this->data->post_komentar_berita($data);
            if($hasil){
                echo json_encode(array("status"=>true));
            }
        }else{
            echo json_encode(array("status"=>false));
            redirect("logout");
        }
    }

    public function reply_comment()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            $id_komentar = get_post("id_komentar");
            $komentar = htmlspecialchars(get_post_text("isi_komentar"));
            $data = array("id_komentar"=>$id_komentar,"nama_komentar"=>$user->nama,"user_id"=>$user->id,"isi_komentar"=>$komentar);

            $hasil = $this->data->reply_comment_berita($data);
            if($hasil){
                echo json_encode(array("status"=>true));
            }
        }else{
            echo json_encode(array("status"=>false));
            redirect("logout");
        }
    }

    public function kategori()
    {
        $kategori = $this->uri->segment(2);
        $judul = $this->uri->segment(3);
        $this->load->model("model_data","data");
    	$this->load->library('pagination');
		$config = array();
        $config["base_url"] = BASEURL . "kat/".$kategori."/".$judul;
        $total_row = $this->data->count_berita(1,$kategori);
        $config["total_rows"] = $total_row;
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp;<a class="active">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        
        $this->pagination->initialize($config);
        if($this->uri->segment(4)){
        $page = ($this->uri->segment(4)) ;
          }
        else{
               $page = 1;
        }
        $ofset = ($page - 1) * $config["per_page"];
        $data["berita"] = $this->data->get_berita($ofset,$config["per_page"],null,null,1,$kategori);
        $str_links = $this->pagination->create_links();
        $data["links"] = /*explode('&nbsp;',$str_links );*/$str_links;
		$output['berita'] = $this->load->view("content/berita.php",$data,true);
        $output['title'] = "Berita";
		$this->template->display("berita/index",$output);
    }

}