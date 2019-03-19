<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpd extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function index()
    {
    	$this->load->model("Model_anggota","anggota");
    	$data['anggota'] = $this->anggota->get_anggota();
        $data['title'] = "Data Pengurus DPD";
    	$this->template->display("data/dpd",$data);
    }

    public function ref_provinsi()
    {
        $this->load->model('model_data','data');
        $hasil = $this->data->get_provinsi();
        echo json_encode($hasil);
    }

    public function get_dpd()
    {
        $this->load->model('model_data','data');
        $res = $this->data->get_datatables_dpd();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            array_push($data,array($no++,$field->no_kta,$field->nama,$field->jabatan,$field->alamat));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_dpd(),
            "recordsFiltered" => $this->data->count_filtered_dpd(),
            "data" => $data)));
    }
}
