<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

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
        $total_row = $this->data->count_forum();
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
        $data["forum"] = $this->data->get_forum($ofset,$config["per_page"],null,null,1);
        $str_links = $this->pagination->create_links();
        $data["links"] = /*explode('&nbsp;',$str_links );*/$str_links;
		$output['forum'] = $this->load->view("forum/index",$data,true);
		$output['title'] = "Forum Diskusi";
		$this->template->display("forum/forum",$output);
    }

    public function detail()
    {
    	$seo_judul = segment(3);
    	$this->load->model("model_data","data");
    	$data['forum'] = $this->data->get_forum(0,1,$seo_judul);
    	$komentar['komentar'] = $this->data->get_komentar_forum($seo_judul);
    	$data['_komentar'] = $this->load->view("forum/komentar",$komentar,true);
    	$data['title'] = isset($data['forum'][0]->judul_forum) ? $data['forum'][0]->judul_forum :'';
    	$this->template->display("forum/detail",$data);
    }

    public function post_komentar()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            $forum_id = get_post("forum_id");
            $komentar = htmlspecialchars(get_post_text("message"));
            $data = array("id_forum"=>$forum_id,"nama_pengirim"=>$user->nama,"member_id"=>$user->id,"komentar"=>$komentar);

            $hasil = $this->data->post_komentar_forum($data);
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
            $data = array("id_komentar"=>$id_komentar,"nama_pengirim"=>$user->nama,"member_id"=>$user->id,"komentar"=>$komentar);

            $hasil = $this->data->post_komentar_reply($data);
            if($hasil){
                echo json_encode(array("status"=>true));
            }
        }else{
            echo json_encode(array("status"=>false));
            redirect("logout");
        }
    }
}
