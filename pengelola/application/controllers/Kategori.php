<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    function index(){
        $this->template->display("berita/kategori");
    }

    public function get_kategori()
    {
        $this->load->model("model_kategori","data");
        $id_kategori = $this->input->post("id_kategori");
        if($id_kategori != null){
            $hasil = $this->data->get_kategori_single($id_kategori);
        }else{
            $hasil = $this->data->get_kategori();
        }

        if($hasil){
            echo json_encode($hasil);
        }
    }

    function get_data_kategori(){
        $this->load->model('model_kategori','data');
        $res = $this->data->get_datatables_kategori();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($res as $field) {
            $action_button = "";
            $action_button .= "<button class='btn btn-primary btn-xs btn-edit' data-value=$field->id_kategori ><i class='fa fa-pencil'></i></button>";
//            $action_button .= " <button class='btn btn-danger btn-xs btn-delete' data-value=$field->id_kategori ><i class='fa fa-trash'></i></button>";
            array_push($data,array($no++,$field->nama_kategori,$action_button));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_kategori(),
            "recordsFiltered" => $this->data->count_filtered_kategori(),
            "data" => $data)));
    }

    function save_kategori(){
        $nama_kategori = $this->input->post("nama_kategori");
        $title_seo = url_title($nama_kategori,"-",true);

        $data = array("nama_kategori"=>$nama_kategori,"kategori_seo"=>$title_seo);

        $this->load->model("model_kategori","data");

        $hasil = $this->data->save_kategori($data);
        if($hasil){
            echo json_encode(array("status"=>true));
        }

    }

    function update_kategori(){
        $id_kategori = $this->input->post("id_kategori");
        $nama_kategori = $this->input->post("nama_kategori");
        $title_seo = url_title($nama_kategori,"-",true);

        $data = array("nama_kategori"=>$nama_kategori,"kategori_seo"=>$title_seo);

        $this->load->model("model_kategori","data");

        $hasil = $this->data->update_kategori($data,$id_kategori);
        if($hasil){
            echo json_encode(array("status"=>true));
        }

    }

}