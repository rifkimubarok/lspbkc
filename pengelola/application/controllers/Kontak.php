<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	$this->template->display("kontak/index");
    }

    public function get_kontak()
    {
        $this->load->model('model_data','data');
        $res = $this->data->get_datatables_berita();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($res as $field) {
            $publish = $field->status == 1 ? 'Draf' : 'Publish';
            $publish1 = $field->status == 1 ? 'fa fa-eye green' : 'fa fa-eye-slash red';
            $button = '<a onclick=edit_berita(this) data-value="'.$field->id_berita.'"><span>Edit</span>&nbsp;|&nbsp;</a>';
            $button .= '<a href="'.BASE.'berita/p/'.$field->judul_seo.'" target="_blank"><span>Lihat</span>&nbsp;|&nbsp;<a>';
            $button .= '<a onclick=delete_berita(this) data-value="'.$field->id_berita.'"><span>Hapus</span>&nbsp;|&nbsp;<a>';
            $button .= '<a onclick=toogle_publish(this) status="'.$field->status.'" data-value="'.$field->id_berita.'"><span>'.$publish.'</span><a>';
            $action = "<div style='min-height:25px;'><ul class='action'><li>".$button."</li></ul></div>";
            $activity = '<div style="width:49.99999%;float:left;"><i class="fa fa-eye"></i>&nbsp;&nbsp;'.number_format($field->dibaca,0).'</div>';
            $activity .= '<div style="width:49.99999%;float:left;"><i class="fa fa-comment"></i>&nbsp;&nbsp;'.number_format($field->dibaca,0).'</div>';
            $tanggal = date('d/m/y', strtotime($field->tanggal)).'<span style="float:right;"><i class="'.$publish1.'"></i></span>';
            array_push($data,array($no++,$field->judul.$action,$field->nama_lengkap,$activity,$tanggal));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_berita(),
            "recordsFiltered" => $this->data->count_filtered_berita(),
            "data" => $data)));
    }

    public function kotak_masuk()
    {
        $this->template->display("kontak/kotak_masuk");
    }

    public function get_content()
    {
        $this->load->model("model_data","data");
        $page_ = $this->input->post("page");
        $data = $this->input->post("data");
        $base = "kontak";
        $output['data'] = $this->data->get_content_pesan($page_,$data);
        $page = file_exists(VIEWPATH.$base.'/'.$page_.'.php') == 1 ? $base.'/'.$page_ : 'not_found';
        $this->load->view($page,$output);
    }

    public function compose()
    {
        $this->load->model("model_data","data");
        $data = $this->input->post("data");
        $output['data'] = $this->data->get_detail_pesan($data['id']);
        $this->load->view('kontak/compose',$output);
    }

    public function send_message()
    {
        $nama = trim($this->input->post('nama'));
        $email = trim($this->input->post('email'));
        $subjek = trim($this->input->post('subjek'));
        $pesan = trim(htmlspecialchars($this->input->post('pesan')));
        $this->load->model("model_data","data");
        $data = array("nama"=>$nama,"email"=>$email,"subjek"=>$subjek,"pesan"=>$pesan);
        $hasil = $this->data->save_pesan_keluar($data);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function get_config()
    {
        $this->config->load("email");
    }
}
