<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	redirect(base_url());
    }

    public function p()
    {
    	$id = $this->uri->segment(3);
        $output = array();
    	$base = "profile";
    	$page = file_exists(VIEWPATH.$base.'/'.$id.'.php') == 1 ? $base.'/'.$id : 'not_found';
    	$this->template->display($page,$output);
    }

    public function get_profile()
    {
        $id = get_post("id");
        $this->load->model('model_data','data');
        $hasil = $this->data->get_profile_content($id);
        echo json_encode($hasil);
    }

    public function save_profile()
    {
        $this->load->model('model_data','data');
        $id = get_post("id");
        $isi_profile =htmlspecialchars(get_post_text("isi_profile"));

        $data = array("isi_profile"=>$isi_profile);

        $hasil = $this->data->save_profile($data,$id);

        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function get_struktur()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->get_struktur();
        echo json_encode($hasil);
    }

    public function get_jabatan()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->get_jabatan();
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

    public function get_form_update()
    {
        $id = get_post("id");
        $page = get_post_text("page");
        $output["id"] = $id;
        $this->load->view("profile/".$page,$output);
    }

    public function get_detail_profile()
    {
        $this->load->model("model_data","data");
        $id = get_post("id");
        $hasil = $this->data->get_detail_profile($id);
        echo json_encode($hasil);
    }

    public function delete_profile()
    {
        $this->load->model("model_data","data");
        $id = get_post("id");
        $hasil = $this->data->delete_data_struktur($id);
        echo json_encode($hasil);
    }

    public function update_data()
    {
        $this->load->model("model_data","data");
        $nama = get_post_text("nama");
        $jabatan = get_post("jabatan");
        $struktur = get_post("struktur");
        $keterangan= get_post("keterangan");
        $id_profile= get_post("id_profile");

        $data = array("nama"=>$nama,"jabatan"=>$jabatan,"struktur"=>$struktur,"keterangan"=>$keterangan);
        $hasil = $this->data->update_data_struktur($data,$id_profile);
        if ($hasil) {
            echo json_encode(array("status"=>true));
        }
    }

    public function tambah_data()
    {
        $this->load->model("model_data","data");
        $nama = get_post_text("nama");
        $jabatan = get_post("jabatan");
        $struktur = get_post("struktur");
        $keterangan= get_post("keterangan");

        $data = array("nama"=>$nama,"jabatan"=>$jabatan,"struktur"=>$struktur,"keterangan"=>$keterangan);
        $hasil = $this->data->tambah_data_struktur($data);
        if ($hasil) {
            echo json_encode(array("status"=>true));
        }
    }

    public function update_photo(){
        $baseFromJavascript = $_POST['image'];
        $base_to_php = explode(',', $baseFromJavascript);
        $data = base64_decode($base_to_php[1]);
        $id = get_post("id");
        $filepath = './../assets/images/struktur/'.sha1($id).'.jpg';
        if(file_put_contents($filepath,$data) != false){
            echo json_encode(array("success"=>true,"foto"=>$baseFromJavascript));
            //$this->create_thumb($filepath);
        }else{
            echo json_encode(array("success"=>false));
        }
    }

    private function create_thumb($file){
        $save = VIEWPATH.'uploaded_images/member_pics/thumb/';
        list($width, $height) = getimagesize($file) ;
        $file_name = basename($file);

        $modwidth = 40;

        $diff = $width / $modwidth;

        $modheight = 40;
        $tn = imagecreatetruecolor($modwidth, $modheight) ;
        $image = imagecreatefromjpeg($file) ;
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

        imagejpeg($tn, $save.$file_name, 60) ;
    }

}