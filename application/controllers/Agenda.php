<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function index()
    {
    	$this->load->model('model_data','data');
    	$this->load->library("pagination");
    	$config = array();
        $config["base_url"] = BASEURL . "agenda/index";
        $total_row = $this->data->count_agenda();
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
        $data["agenda"] = $this->data->get_agenda($ofset,$config["per_page"],1);
        $str_links = $this->pagination->create_links();
        $data["links"] = /*explode('&nbsp;',$str_links );*/$str_links;
        $output['agenda'] = $this->load->view("content/agenda.php",$data,TRUE);
        $output['title'] = "Agenda Kegiatan";

    	$this->template->display("agenda/index",$output);
    }

    public function p()
    {
        $this->load->model("model_data","data");
        $seo_judul = $this->uri->segment(3);
        $komentar['komentar'] = $this->data->get_komentar_agenda($seo_judul);
        $output['_komentar'] = $this->load->view("agenda/komentar",$komentar,true);
        $output['agenda'] = $this->data->get_agenda(0,1,1,$seo_judul);
        $output['title'] = $output['agenda'][0]->tema;
        $output['image'] = GAMBAR.'agenda/'.$output['agenda'][0]->ref;
        $this->template->display("agenda/single_post",$output);
    }

    public function post_komentar()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            $id_agenda = get_post("id_agenda");
            $komentar = htmlspecialchars(get_post_text("message"));
            $data = array("id_agenda"=>$id_agenda,"nama_komentar"=>$user->nama,"user_id"=>$user->id,"isi_komentar"=>$komentar);

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
}
