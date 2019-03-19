<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Static_page extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
        $this->template->display("static_pages/index");
    }

    public function get_halaman()
    {
        $this->load->model('model_data','data');
        $res = $this->data->get_datatables_halaman();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($res as $field) {
            $publish = $field->status == 1 ? 'Draf' : 'Publish';
            $publish1 = $field->status == 1 ? 'fa fa-eye green' : 'fa fa-eye-slash red';
            $button = '<a onclick=edit_halaman(this) data-value="'.$field->id_halaman.'"><span>Edit</span>&nbsp;|&nbsp;</a>';
            $button .= '<a href="'.BASE.'hal/'.$field->id_halaman.'/'.$field->judul_seo.'" target="_blank"><span>Lihat</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=delete_halaman(this) data-value="'.$field->id_halaman.'"><span>Hapus</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=toogle_publish(this) status="'.$field->status.'" data-value="'.$field->id_halaman.'"><span>'.$publish.'</span></a>';
            $action = "<div style='min-height:25px;'><ul class='action'><li>".$button."</li></ul></div>";
            $tanggal = date('d/m/y', strtotime($field->tanggal)).'<span style="float:right;"><i class="'.$publish1.'"></i></span>';\
            array_push($data,array($no++,$field->judul.$action,$tanggal));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_halaman(),
            "recordsFiltered" => $this->data->count_filtered_halaman(),
            "data" => $data)));
    }

    public function save_halaman()
    {
        $judul_halaman = get_post_text("judul");
        $isi_halaman = htmlspecialchars($this->input->post("isi_halaman"));
        $seo_title = url_title($judul_halaman);
        $data = array("judul"=>$judul_halaman,"isi_halaman"=>$isi_halaman,"judul_seo"=>$seo_title);
        $this->load->model("model_data","data");
        $hasil = $this->data->save_halaman($data);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function update_halaman()
    {
        $id_halaman = get_post_text("id_halaman");
        $judul_halaman = get_post_text("judul");
        $isi_halaman = htmlspecialchars($this->input->post("isi_halaman"));
        $seo_title = url_title($judul_halaman);
        $data = array("judul"=>$judul_halaman,"isi_halaman"=>$isi_halaman,"judul_seo"=>$seo_title);
        $where = array("id_halaman"=>$id_halaman);
        $this->load->model("model_data","data");
        $hasil = $this->data->update_halaman($data,$where);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function get_halaman_single()
    {
        $id_halaman = get_post("id_halaman");
        $where = array("id_halaman"=>$id_halaman);
        $this->load->model("model_data","data");
        $hasil = $this->data->get_halaman_single($where);
        if($hasil){
            $hasil->isi = html_entity_decode($hasil->isi_halaman);
            echo json_encode($hasil);
        }
    }

    public function delete_halaman()
    {
        $id_halaman = get_post("id_halaman");
        $where = array("id_halaman"=>$id_halaman);
        $this->load->model("model_data","data");
        $hasil = $this->data->delete_halaman($where);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function toogle_publish()
    {
        $id_halaman = get_post_text("id_halaman");
        $status = get_post("status");
        $where = array("id_halaman"=>$id_halaman);
        $data =array("status"=>$status);
        $this->load->model("model_data","data");
        $hasil = $this->data->update_halaman($data,$where);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }
}