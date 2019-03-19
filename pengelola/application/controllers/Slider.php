<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	$this->template->display("slider/index");
    }



    public function get_slider()
    {
        $this->load->model('model_data','data');
        $res = $this->data->get_datatables_slider();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            $action = '<button class="btn btn-primary btn-xs" onclick="edit_data(this)" data-value="'.$field->id.'"><i class="fa fa-pencil"></i></button>&nbsp;';
            $action .= '<button class="btn btn-danger btn-xs" onclick="hapus_data(this)" data-value="'.$field->id.'"><i class="fa fa-trash"></i></button>&nbsp;';
            if($field->status == 1){
            	$action .= '<button class="btn btn-success btn-xs" onclick="toogle_data(this)" data-value="'.$field->id.'" data-status=0><i class="fa fa-eye"></i></button>';
            }else{
            	$action .= '<button class="btn btn-warning btn-xs" onclick="toogle_data(this)" data-value="'.$field->id.'" data-status=1><i class="fa fa-eye-slash"></i></button>';
            }
            $act_up_down = $field->urutan == 1 ? "<button class='btn-primary' onclick=down_button(this) data-value='".$field->id."'><i class='fa fa-arrow-down'></i></button>" : "<button class='btn-primary' onclick=up_button(this) data-value='".$field->id."'><i class='fa fa-arrow-up'></i></button>&nbsp;<button class='btn-primary' onclick=down_button(this) data-value='".$field->id."'><i class='fa fa-arrow-down'></i></button>";
            if($field === end($res)) $act_up_down = "<button class='btn-primary' onclick=up_button(this) data-value='".$field->id."'><i class='fa fa-arrow-up'></i></button>";
            array_push($data,array($no++,$field->description,$act_up_down,$action));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_slider(),
            "recordsFiltered" => $this->data->count_filtered_slider(),
            "data" => $data)));
    }

    public function get_data_slider()
    {
        $id=get_post("id_slide");
        $this->load->model("model_data","data");
        $hasil = $this->data->get_data_slider($id);
        if($hasil){
            echo json_encode($hasil);
        }
    }

    public function up_slider()
    {
        $id=get_post("id_slide");
        $this->load->model("model_data","data");
        $hasil = $this->data->move_position_slider_up($id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function down_slider()
    {
        $id=get_post("id_slide");
        $this->load->model("model_data","data");
        $hasil = $this->data->move_position_slider_down($id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }


    public function update_photo($id_slider){
        $baseFromJavascript = $_POST['image'];
        $base_to_php = explode(',', $baseFromJavascript);
        $data = base64_decode($base_to_php[1]);
        $id = $id_slider;
        $filepath = './../assets/images/slider/'.sha1($id).'.jpg';
        if(file_put_contents($filepath,$data) != false){
            //echo json_encode(array("success"=>true,"foto"=>$baseFromJavascript));
            $this->create_thumb($filepath);
        }else{
            echo json_encode(array("success"=>false));
        }
    }

    private function create_thumb($file){
        $save = './../assets/images/slider/';
        list($width, $height) = getimagesize($file) ;
        $file_name = basename($file);

        $modwidth = 1140;

        $diff = $width / $modwidth;

        $modheight = 430;
        $tn = imagecreatetruecolor($modwidth, $modheight) ;
        $image = imagecreatefromjpeg($file) ;
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

        imagejpeg($tn, $save.$file_name, 70) ;
    }

    public function update_slider()
    {
        $id = get_post('id');
        $description = get_post('description');
        $status_baner = get_post('status_baner');
        $img = get_post('image');
        if($status_baner == 1){
            $this->update_photo($id);
        }
        $this->load->model("model_data","data");
        $data = array("description"=>$description);
        $hasil = $this->data->update_slide($data,$id);
        if($hasil){
            echo json_encode(array("success"=>true));
        }
    }

    public function simpan_slide()
    {
        $description = get_post('description');
        $status_baner = get_post('status_baner');
        $img = get_post('image');
        $this->load->model("model_data","data");
        $urutan = $this->data->get_last_urutan() + 1;
        $data = array("description"=>$description,"urutan"=>$urutan);
        $hasil = $this->data->save_slide($data);
        if($hasil){
            if($status_baner == 1){
                $this->update_photo($hasil);
            }
            echo json_encode(array("success"=>true));
        }
    }

    public function hapus_banner()
    {
        $id = get_post("id_slide");
        $this->load->model("model_data","data");
        $hasil = $this->data->_get_slide_delete($id);
        if($hasil){
            $this->remove_file_gambar($id);
            echo json_encode(array("success"=>true));
        }
    }

    public function remove_file_gambar($id_slide)
    {
        $file_name = sha1($id_slide);
        $image = glob('./../assets/images/slider/'.$file_name.'.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
        foreach ($image as $imag) {
            if (file_exists($imag)) 
                unlink($imag);
        }
    }

    public function toogle_data_slider()
    {
        $id = get_post('id_slide');
        $status = get_post("status");
        $this->load->model("model_data","data");
        $hasil = $this->data->update_slide(array("status"=>$status),$id);
        if($hasil){
            echo json_encode(array("success"=>true));
        }
    }
}