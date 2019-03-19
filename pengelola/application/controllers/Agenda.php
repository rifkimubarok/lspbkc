<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
        $this->template->display("agenda/index");
    }

    public function get_agenda()
    {
        $this->load->model('model_data','data');
        $res = $this->data->get_datatables_agenda();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($res as $field) {
            $publish = $field->status == 1 ? 'Draf' : 'Publish';
            $publish1 = $field->status == 1 ? 'fa fa-eye green' : 'fa fa-eye-slash red';
            $button = '<a onclick=edit_agenda(this) data-value="'.$field->id_agenda.'"><span>Edit</span>&nbsp;|&nbsp;</a>';
            $button .= '<a href="'.BASE.'agenda/p/'.$field->tema_seo.'" target="_blank"><span>Lihat</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=delete_agenda(this) data-value="'.$field->id_agenda.'"><span>Hapus</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=toogle_publish(this) status="'.$field->status.'" data-value="'.$field->id_agenda.'"><span>'.$publish.'</span></a>';
            $action = "<div style='min-height:25px;'><ul class='action'><li>".$button."</li></ul></div>";
            $status = '<span style="float:right;"><i class="'.$publish1.'"></i></span>';
            $tgl_mulai = strtotime($field->tgl_mulai);
            $tgl_selesai = strtotime($field->tgl_selesai);
            $tgl_fix = '<i class="fa fa-calendar"></i> '.diff_tg($tgl_mulai,$tgl_selesai).'<br><i class="fa fa-clock"></i> '.$field->jam.$status;
            array_push($data,array($no++,$field->tema.$action,$field->pengirim,$tgl_fix));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_agenda(),
            "recordsFiltered" => $this->data->count_filtered_agenda(),
            "data" => $data)));
    }

    public function get_agenda_single()
    {
        $this->load->model("model_data","data");
        $id = get_post("id_agenda");
        $hasil = $this->data->_get_agenda($id);
        if($hasil){
            echo json_encode($hasil);
        }else{
            echo "error";
        }
    }

    public function upload_image($file_name)
    {  
            $config['upload_path']          = './../assets/images/agenda/';
            $config['allowed_types']        = 'jpg';
            $config['overwrite'] = true;
            $config['max_size']             = 2048;
            $config['file_name'] = sha1($file_name).".jpg";
            $image_data = array();
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('cover_image'))
            {
                    $error = array('error' => $this->upload->display_errors());

                    echo json_encode($error);
            }
            else
            {
                $image_data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image_data['full_path'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = 710;
                $config['height']       = 300;
                $this->load->library('image_lib', $config);
                if($this->image_lib->resize())return $image_data;

            }
    }

    public function update_agenda()
    {
        $this->load->model("model_data","data");
        $id_agenda = $this->input->post("id_agenda");
        $tema = $this->input->post("tema");
        $isi_agenda = $this->input->post("isi_agenda");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_selesai = $this->input->post("tgl_selesai");
        $jam = $this->input->post("jam");

        $data = array("tema"=>$tema,"isi_agenda"=>htmlspecialchars($isi_agenda),"tgl_mulai"=>$tgl_mulai,"tgl_selesai"=>$tgl_selesai,"jam"=>$jam);
        $hasil = $this->data->update_agenda($data,$id_agenda);
        if($hasil){
            if(isset($_FILES["cover_image"]["tmp_name"])){
                $image = $this->upload_image($id_agenda);
                if($image){
                    echo json_encode(array("status"=>true,"image"=>$image));
                }else{
                    echo "upload image gagal";
                }
            }else{
                echo json_encode(array("status"=>true,"berita"=>true));
            }
        }else{
            echo "update agenda gagal";
        }
        
    }

    public function save_agenda()
    {
        $this->load->model("model_data","data");
        $tema = $this->input->post("tema");
        $isi_agenda = $this->input->post("isi_agenda");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_selesai = $this->input->post("tgl_selesai");
        $jam = $this->input->post("jam");
        $pengirim = $this->user->nama;
        $id_user = $this->user->id;
        $tema_seo = strlen($tema) > 70 ? rand().'-'.url_title(substr($tema, 0,70),'-',true) : rand().'-'.url_title($tema,'-',true);

        $data = array("tema"=>$tema,"tema_seo"=>$tema_seo,"isi_agenda"=>htmlspecialchars($isi_agenda),"tgl_mulai"=>$tgl_mulai,"tgl_selesai"=>$tgl_selesai,"jam"=>$jam,"status"=>1,"pengirim"=>$pengirim,"id_user"=>$id_user);
        $hasil = $this->data->save_agenda($data);
        if($hasil != 0){
            if(isset($_FILES["cover_image"]["tmp_name"])){
                $image = $this->upload_image($hasil);
                if($image){
                    echo json_encode(array("status"=>true,"image"=>$image));
                }else{
                    echo "upload image gagal";
                }
            }else{
                echo json_encode(array("status"=>true,"berita"=>true));
            }
        }else{
            echo "Simpan berita gagal";
        }
        
    }

    public function delete_agenda()
    {
        $this->load->model("model_data",'data');
        $id = $this->input->post("id_agenda");

        $hasil = $this->data->delete_agenda($id);    
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function toogle_publish()
    {
        $this->load->model("model_data","data");
        $id = $this->input->post("id_agenda");
        $status = $this->input->post("status");

        $data = array("status"=>$status);
        $hasil = $this->data->update_agenda($data,$id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

}