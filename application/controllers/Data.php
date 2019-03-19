<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function index()
    {
    	$this->load->model("Model_anggota","anggota");
    	$data['anggota'] = $this->anggota->get_anggota();
        $data['title'] = "Data Purna Pasma";
    	$this->template->display("data/index",$data);
    }

    public function get_member()
    {
        $this->load->model('model_anggota','anggota');
        $res = $this->anggota->get_datatables_member();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            $jk = $field->jk =="P"?"Perempuan":"Laki-laki";
            array_push($data,array($no++,$field->nama,$jk,$field->asal_text_krn,$field->penugasan_text_krn,$field->tahun_krn));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota->count_filtered_member(),
            "recordsFiltered" => $this->anggota->count_filtered_member(),
            "data" => $data)));
    }

    public function get_angkatan()
    {
        $this->load->model("model_anggota","anggota");
        $angkatan = $this->anggota->get_angkata();
        echo json_encode($angkatan);
    }
}
