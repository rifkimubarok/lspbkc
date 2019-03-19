<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {
    private $user;
	function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	$this->template->display("berita/index");
    }

    public function get_berita()
    {
        $this->load->model('model_data','data');
        $res = $this->data->get_datatables_berita();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($res as $field) {
            $jml_komentar = $this->data->get_komentar_count_berita($field->id_berita);
            $publish = $field->status == 1 ? 'Draf' : 'Publish';
            $publish1 = $field->status == 1 ? 'fa fa-eye green' : 'fa fa-eye-slash red';
            $button = '<a onclick=edit_berita(this) data-value="'.$field->id_berita.'"><span>Edit</span>&nbsp;|&nbsp;</a>';
            $button .= '<a href="'.BASE.'artikel/p/'.$field->judul_seo.'" target="_blank"><span>Lihat</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=delete_berita(this) data-value="'.$field->id_berita.'"><span>Hapus</span>&nbsp;|&nbsp;</a>';
            $button .= '<a onclick=toogle_publish(this) status="'.$field->status.'" data-value="'.$field->id_berita.'"><span>'.$publish.'</span></a>';
            $action = "<div style='min-height:25px;'><ul class='action'><li>".$button."</li></ul></div>";
            $activity = '<div style="width:49.99999%;float:left;"><i class="fa fa-eye"></i>&nbsp;&nbsp;'.number_format($field->dibaca,0).'</div>';
            $activity .= '<div style="width:49.99999%;float:left;"><i class="fa fa-comment"></i>&nbsp;&nbsp;'.number_format($jml_komentar,0).'</div>';
            $tanggal = date('d/m/y', strtotime($field->tanggal)).'<span style="float:right;"><i class="'.$publish1.'"></i></span>';
            $kategori = " <span class='kategori'>".$field->nama_kategori."</span>";
            array_push($data,array($no++,$field->judul.$kategori.$action,$field->nama_lengkap,$activity,$tanggal));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_filtered_berita(),
            "recordsFiltered" => $this->data->count_filtered_berita(),
            "data" => $data)));
    }

    public function get_editor()
    {
        $this->load->view("berita/editor");
    }

    public function get_berita_single()
    {
        $this->load->model("model_data","data");
        $id = get_post("id_berita");
        $hasil = $this->data->_get_berita($id);
        if($hasil){
            echo json_encode($hasil);
        }else{
            echo "error";
        }
    }

    public function upload_image($file_name)
    {  
            $config['upload_path']          = './../assets/images/berita/';
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

    public function update_berita()
    {
        $this->load->model("model_data","data");
        $id_berita = $this->input->post("id_berita");
        $judul = $this->input->post("judul");
        $isi_berita = $this->input->post("isi_berita");
        $id_kategori = $this->input->post("id_kategori");

        $data = array("judul"=>$judul,"isi_berita"=>htmlspecialchars($isi_berita),"id_kategori"=>$id_kategori);
        $hasil = $this->data->update_berita($data,$id_berita);
        if($hasil){
            if(isset($_FILES["cover_image"]["tmp_name"])){
                $image = $this->upload_image($id_berita);
                if($image){
                    echo json_encode(array("status"=>true,"image"=>$image));
                }else{
                    echo "upload image gagal";
                }
            }else{
                echo json_encode(array("status"=>true,"berita"=>true));
            }
        }else{
            echo "update berita gagal";
        }
        
    }

    public function save_berita()
    {
        $this->load->model("model_data","data");
        $judul = $this->input->post("judul");
        $isi_berita = get_post_text("isi_berita");
        $id_kategori = $this->input->post("id_kategori");
        $nama_lengkap = $this->user->nama;
        $judul_seo = strlen($judul) > 70 ? rand().'-'.url_title(substr($judul, 0,70),'-',true) : rand().'-'.url_title($judul,'-',true);
        $id_user = $this->user->id;
        $data = array("judul"=>$judul,"isi_berita"=>htmlspecialchars($isi_berita),"id_kategori"=>$id_kategori,"nama_lengkap"=>$nama_lengkap,"judul_seo"=>$judul_seo,"status"=>1,"id_user"=>$id_user);
        $hasil = $this->data->save_berita($data);
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

    public function delete_berita()
    {
        $this->load->model("model_data",'data');
        $id = $this->input->post("id_berita");

        $hasil = $this->data->delete_berita($id);    
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function toogle_publish()
    {
        $this->load->model("model_data","data");
        $id = $this->input->post("id_berita");
        $status = $this->input->post("status");

        $data = array("status"=>$status);
        $hasil = $this->data->update_berita($data,$id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

}