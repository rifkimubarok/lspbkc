<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    private $user;
	function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
        $this->template->display("menu/menu");
        //$this->load->view("menu");
    }

    public function getMenu()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->getMenu();
        echo json_encode($hasil);
    }

    public function getParrentMenu()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->getParrentMenu();
        echo json_encode($hasil);
    }

    public function getlink()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->getLink();
        $output['link'] = $hasil;
        $this->load->view("menu/link",$output);
    }

    public function save_menu()
    {
        $isNew = get_post("isNew");
        $id_main = get_post('id_main');
        $nama_menu = get_post_text('nama_menu');
        $aktif = get_post('aktif');
        $link = get_post_text('link');
        $this->load->model("model_data","data");
        $data = array("nama_menu"=>$nama_menu,"link"=>$link,"aktif"=>$aktif);
        $where = array("id_main"=>$id_main);
        $hasil = $this->data->save_main_menu($data,$where,$isNew);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function save_submenu()
    {
        $id_sub = get_post("id_sub");
        $nama_sub = get_post_text("nama_sub");
        $aktif = get_post("aktif");
        $link_sub = get_post_text("link_sub");
        $id_main = get_post("id_main");
        $isNew = get_post("isNew");
        $this->load->model("model_data","data");

        $data = array("nama_sub"=>$nama_sub,"aktif"=>$aktif,"link_sub"=>$link_sub,"id_main"=>$id_main);
        $where = array("id_sub"=>$id_sub);

        $hasil = $this->data->save_sub_menu($data,$where,$isNew);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function up_level_menu()
    {
        $id=get_post("id_main");
        $isChild=get_post("isChild");
        $this->load->model("model_data","data");
        $hasil = $this->data->move_position_up_menu($id,$isChild);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    

    public function down_level_menu()
    {
        $id=get_post("id_main");
        $isChild=get_post("isChild");
        $this->load->model("model_data","data");
        $hasil = $this->data->move_position_slider_down_menu($id,$isChild);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function remove_menu()
    {
        $id=get_post("id_main");
        $isChild=get_post("isChild");
        $this->load->model("model_data","data");
        $hasil = $this->data->remove_menu($id,$isChild);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }
}