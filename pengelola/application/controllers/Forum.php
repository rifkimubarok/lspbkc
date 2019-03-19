<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {
    private $user;
	function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	$this->template->display("forum/index");
    }

    public function get_forum()
    {
        $this->load->model('model_data','data');
        $res = $this->data->get_datatables_forum();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($res as $field) {
            $jml_komentar = $this->data->get_komentar_count_forum($field->id);
            $publish = $field->status == 1 ? 'Draf' : 'Publish';
            $publish1 = $field->status == 1 ? 'fa fa-eye green' : 'fa fa-eye-slash red';
            $button = '';
            if($this->user->id == $field->member_id){
                $button .= '<a onclick=edit_forum(this) data-value="'.$field->id.'"><span>Edit</span>&nbsp;|&nbsp;</a>';
            }
            $button .= '<a href="'.BASE.'forum/detail/'.$field->seo_judul.'" target="_blank"><span>Lihat</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=delete_forum(this) data-value="'.$field->id.'"><span>Hapus</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=toogle_publish(this) status="'.$field->status.'" data-value="'.$field->id.'"><span>'.$publish.'</span></a>';
            $action = "<div style='min-height:25px;'><ul class='action'><li>".$button."</li></ul></div>";
            $activity = '<div style="width:49.99999%;float:left;"><i class="fa fa-eye"></i>&nbsp;&nbsp;'.number_format($field->view_counter,0).'</div>';
            $activity .= '<div style="width:49.99999%;float:left;"><i class="fa fa-comment"></i>&nbsp;&nbsp;'.number_format($jml_komentar,0).'</div>';
            $date_insert = date('d/m/y', strtotime($field->date_insert)).'<span style="float:right;"><i class="'.$publish1.'"></i></span>';
            array_push($data,array($no++,$field->judul_forum.$action,$field->nama_pengirim,$activity,$date_insert));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_forum(),
            "recordsFiltered" => $this->data->count_filtered_forum(),
            "data" => $data)));
    }

    public function get_editor()
    {
        $this->load->view("berita/editor");
    }

    public function get_forum_single()
    {
        $this->load->model("model_data","data");
        $id = get_post("id_forum");
        $hasil = $this->data->_get_forum($id);
        if($hasil){
            echo json_encode($hasil);
        }else{
            echo "error";
        }
    }

    public function upload_image($file_name)
    {  
            $config['upload_path']          = './../assets/images/berita/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['file_name'] = sha1($file_name);
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

    public function update_forum()
    {
        $this->load->model("model_data","data");
        $id_forum = $this->input->post("id_forum");
        $judul = $this->input->post("judul");
        $content = $this->input->post("content");

        $data = array("judul_forum"=>$judul,"content"=>htmlspecialchars($content));
        $hasil = $this->data->update_forum($data,$id_forum);
        if($hasil){
            echo json_encode(array("status"=>true,"berita"=>true));
        }else{
            echo "update berita gagal";
        }
        
    }

    public function save_forum()
    {
        $this->load->model("model_data","data");
        $judul = $this->input->post("judul");
        $content = get_post_text("content");
        $nama_lengkap = $this->user->nama;
        $judul_seo = strlen($judul) > 70 ? rand().'-'.url_title(substr($judul, 0,70),'-',true) : rand().'-'.url_title($judul,'-',true);
        $id_user = $this->user->id;
        $data = array("judul_forum"=>$judul,"content"=>htmlspecialchars($content),"nama_pengirim"=>$nama_lengkap,"seo_judul"=>$judul_seo,"status"=>1,"member_id"=>$id_user);
        $hasil = $this->data->save_forum($data);
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

    public function delete_forum()
    {
        $this->load->model("model_data",'data');
        $id = $this->input->post("id_forum");

        $hasil = $this->data->delete_forum($id);    
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function toogle_publish()
    {
        $this->load->model("model_data","data");
        $id = $this->input->post("id_forum");
        $status = $this->input->post("status");

        $data = array("status"=>$status);
        $hasil = $this->data->update_forum($data,$id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

}