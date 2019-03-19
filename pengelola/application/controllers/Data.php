<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	$this->load->model("Model_anggota","anggota");
    	$data['anggota'] = $this->anggota->get_anggota();
    	$this->template->display("data/index",$data);
    }


    public function purnapasma()
    {
        $this->template->display("data/purnapasma");
    }

    public function pasukaninti()
    {
        $this->template->display("data/pasukaninti");
    }

    public function sahabatkrn()
    {
        $this->template->display("data/sahabatkrn");
    }

    public function datadpd()
    {
        $this->template->display("data/datadpd");
    }

    public function calon_pasma()
    {
        $this->template->display("data/calon_pasma");
    }

    public function get_member()
    {
        $this->load->model('model_anggota','anggota');
        $res = $this->anggota->get_datatables_member();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            $jk = $field->jk =="P"?"Perempuan":"Laki-laki";
            $action = '<button class="btn btn-primary btn-xs" onclick="edit_data(this)" data-value="'.$field->id.'"><i class="fa fa-pencil"></i></button>&nbsp;';
            $action .= '<button class="btn btn-danger btn-xs" onclick="hapus_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-trash"></i></button>';
            array_push($data,array($no++,$field->nama,$jk,$field->asal_text_krn,$field->penugasan_text_krn,$field->tahun_krn,$action));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota->count_filtered_member(),
            "recordsFiltered" => $this->anggota->count_filtered_member(),
            "data" => $data)));
    }

    public function get_data_anggota()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_anggota");
        $hasil = $this->anggota->get_data_anggota($id);
        if($hasil){
            echo json_encode($hasil);
        }
    }

    public function update_anggota()
    {
        $this->load->model("Model_anggota","anggota");
        $id = trim($this->input->post('id'));
        $nama = trim($this->input->post('nama'));
        $jk = trim($this->input->post('jk'));
        $tempat_lahir = trim($this->input->post('tempat_lahir'));
        $tgl_lahir = trim($this->input->post('tgl_lahir'));
        $no_hp = trim($this->input->post('no_hp'));
        $email = trim($this->input->post('email'));
        $alamat = trim($this->input->post('alamat'));
        $asal_krn = trim($this->input->post('asal_krn'));
        $asal_text_krn = trim($this->input->post('asal_text_krn'));
        $penugasan_krn = trim($this->input->post('penugasan_krn'));
        $penugasan_text_krn = trim($this->input->post('penugasan_text_krn'));
        $status_krn = trim($this->input->post('status_krn'));
        $tahun_krn = trim($this->input->post('tahun_krn'));
        $data = array('nama'=>$nama,'jk'=>$jk,'tempat_lahir'=>$tempat_lahir,'tgl_lahir'=>$tgl_lahir,'no_hp'=>$no_hp,'email'=>$email,'alamat'=>$alamat,'asal_krn'=>$asal_krn,'asal_text_krn'=>$asal_text_krn,'penugasan_krn'=>$penugasan_krn,'penugasan_text_krn'=>$penugasan_text_krn,'status_krn'=>$status_krn,'tahun_krn'=>$tahun_krn);
        $hasil = $this->anggota->update_data($data,$id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function delete_anggota()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_anggota");
        $hasil = $this->anggota->delete_anggota($id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function save_anggota()
    {
        $this->load->model("Model_anggota","anggota");
        $nama = trim($this->input->post('nama'));
        $jk = trim($this->input->post('jk'));
        $tempat_lahir = trim($this->input->post('tempat_lahir'));
        $tgl_lahir = trim($this->input->post('tgl_lahir'));
        $no_hp = trim($this->input->post('no_hp'));
        $email = trim($this->input->post('email'));
        $alamat = trim($this->input->post('alamat'));
        $asal_krn = trim($this->input->post('asal_krn'));
        $asal_text_krn = trim($this->input->post('asal_text_krn'));
        $penugasan_krn = trim($this->input->post('penugasan_krn'));
        $penugasan_text_krn = trim($this->input->post('penugasan_text_krn'));
        $status_krn = trim($this->input->post('status_krn'));
        $tahun_krn = trim($this->input->post('tahun_krn'));
        $data = array('nama'=>$nama,'jk'=>$jk,'tempat_lahir'=>$tempat_lahir,'tgl_lahir'=>$tgl_lahir,'no_hp'=>$no_hp,'email'=>$email,'alamat'=>$alamat,'asal_krn'=>$asal_krn,'asal_text_krn'=>$asal_text_krn,'penugasan_krn'=>$penugasan_krn,'penugasan_text_krn'=>$penugasan_text_krn,'status_krn'=>$status_krn,'tahun_krn'=>$tahun_krn);
        $hasil = $this->anggota->save_anggota($data);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    /*INTI SECTION*/
    public function get_member_inti()
    {
        $this->load->model('model_anggota','anggota');
        $res = $this->anggota->get_datatables_member_inti();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            $jk = $field->jk =="P"?"Perempuan":"Laki-laki";
            $action = '<button class="btn btn-primary btn-xs" onclick="edit_data(this)" data-value="'.$field->id.'"><i class="fa fa-eye"></i></button>&nbsp;';
            if($field->aktif == 0){
                $action .= '<button class="btn btn-success btn-xs" onclick="aprove_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-check"></i></button>';
            }

            $action .= '<button class="btn btn-danger btn-xs" onclick="hapus_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-trash"></i></button>&nbsp;';
            array_push($data,array($no++,$field->nama,$jk,$field->asal_text_krn,$field->penugasan_text_krn,$field->status,$action));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota->count_filtered_member_inti(),
            "recordsFiltered" => $this->anggota->count_filtered_member_inti(),
            "data" => $data)));
    }

    public function get_sahabat()
    {
        $this->load->model('model_anggota','anggota');
        $res = $this->anggota->get_datatables_member_inti();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            $jk = $field->jk =="P"?"Perempuan":"Laki-laki";
            $action = '<button class="btn btn-primary btn-xs" onclick="edit_data(this)" data-value="'.$field->id.'"><i class="fa fa-eye"></i></button>&nbsp;';
            if($field->aktif == 0){
                
                $action .= '<button class="btn btn-success btn-xs" onclick="aprove_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-check"></i></button>';
            }
            $action .= '<button class="btn btn-danger btn-xs" onclick="hapus_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-trash"></i></button>&nbsp;';
            array_push($data,array($no++,$field->nama,$jk,$field->asal_text_krn,$action));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota->count_filtered_member_inti(),
            "recordsFiltered" => $this->anggota->count_filtered_member_inti(),
            "data" => $data)));
    }

    public function get_data_anggota_inti()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_anggota");
        $hasil = $this->anggota->get_data_anggota_inti($id);
        if($hasil){
            echo json_encode($hasil);
        }
    }

    public function update_anggota_inti()
    {
        $this->load->model("Model_anggota","anggota");
        $id = trim($this->input->post('id'));
        $nama = trim($this->input->post('nama'));
        $jk = trim($this->input->post('jk'));
        $tempat_lahir = trim($this->input->post('tempat_lahir'));
        $tgl_lahir = trim($this->input->post('tgl_lahir'));
        $no_hp = trim($this->input->post('no_hp'));
        $email = trim($this->input->post('email'));
        $alamat = trim($this->input->post('alamat'));
        $asal_krn = trim($this->input->post('asal_krn'));
        $asal_text_krn = trim($this->input->post('asal_text_krn'));
        $penugasan_krn = trim($this->input->post('penugasan_krn'));
        $penugasan_text_krn = trim($this->input->post('penugasan_text_krn'));
        $status_krn = trim($this->input->post('status_krn'));
        $saran = trim($this->input->post('saran'));
        $data = array('nama'=>$nama,'jk'=>$jk,'tempat_lahir'=>$tempat_lahir,'tgl_lahir'=>$tgl_lahir,'no_hp'=>$no_hp,'email'=>$email,'alamat'=>$alamat,'asal_krn'=>$asal_krn,'asal_text_krn'=>$asal_text_krn,'penugasan_krn'=>$penugasan_krn,'penugasan_text_krn'=>$penugasan_text_krn,'status_krn'=>$status_krn,'saran'=>$saran);
        $hasil = $this->anggota->update_data_inti($data,$id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function delete_anggota_inti()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_anggota");
        $data = $this->anggota->get_data_anggota_inti($id);
        $hasil = $this->anggota->delete_anggota_inti($id);
        if($hasil){
            $this->delete_dokument($id);
            $message = "Anda telah melakukan registrasi.\r\nMohon maaf data anda tidak dapat kami proses karena data anda teridentifikasi bukan Pasukan / Sahabat Kirab Remaja Nasional.\r\nTerima kasih, Salam Remaja.\r\n
                DPP Purna Pasma KRN";
            $subjek = "DATA ANDA KAMI TOLAK.";
            $email = array("email"=>$data->email,"subjek"=>$subjek,"pesan"=>$message);
            $this->send_email($email);
            echo json_encode(array("status"=>true));
        }
    }

    public function delete_dokument($id_anggota)
    {
        $foto_path = './../assets/images/member_docs/foto_'.$id_anggota.'.jpg';
        $ktp_path = './../assets/images/member_docs/ktp_'.$id_anggota.'.jpg';
        if (file_exists($foto_path)) 
        unlink($foto_path);

        if (file_exists($ktp_path)) 
        unlink($ktp_path);
    }

    public function save_anggota_inti()
    {
        $this->load->model("Model_anggota","anggota");
        $nama = trim($this->input->post('nama'));
        $jk = trim($this->input->post('jk'));
        $tempat_lahir = trim($this->input->post('tempat_lahir'));
        $tgl_lahir = trim($this->input->post('tgl_lahir'));
        $no_hp = trim($this->input->post('no_hp'));
        $email = trim($this->input->post('email'));
        $alamat = trim($this->input->post('alamat'));
        $asal_krn = trim($this->input->post('asal_krn'));
        $asal_text_krn = trim($this->input->post('asal_text_krn'));
        $penugasan_krn = trim($this->input->post('penugasan_krn'));
        $penugasan_text_krn = trim($this->input->post('penugasan_text_krn'));
        $status_krn = trim($this->input->post('status_krn'));
        $saran = trim($this->input->post('saran'));
        $data = array('nama'=>$nama,'jk'=>$jk,'tempat_lahir'=>$tempat_lahir,'tgl_lahir'=>$tgl_lahir,'no_hp'=>$no_hp,'email'=>$email,'alamat'=>$alamat,'asal_krn'=>$asal_krn,'asal_text_krn'=>$asal_text_krn,'penugasan_krn'=>$penugasan_krn,'penugasan_text_krn'=>$penugasan_text_krn,'status_krn'=>$status_krn,'saran'=>$saran);
        $hasil = $this->anggota->save_anggota_inti($data);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function aprove_anggota_()
    {
        $id = get_post("id_anggota");
        $data = array("status"=>1);

        $this->load->model("Model_anggota","anggota");
        $hasil = $this->anggota->update_data_inti($data,$id);
        if($hasil){
            $data = $this->anggota->get_data_anggota_inti($id);
            $nama = explode(" ", $data->nama);
            $username = $nama[0].rand();
            $password = $nama[0].rand();
            $message = "Salam REMAJA.\r\n\r\n";
            $message .= "Selamat akun anda yang bernama ".$data->nama." telah kami verifikasi.\r\n";
            $message .= "Berikut Merupakan akun untuk melakukan login di portal ".BASE."\r\n";
            $message .= "Username : ".$username."\r\n";
            $message .= "Password : ".$password."\r\n";
            $message .= "Terima Kasih Telah mendaftar. REMAJA JAYA 5X\r\n";
            $message .= "\r\nDPP Purna Pasma KRN";

            $subjek = "DATA TERVERIFIKASI";
            $email = array("email"=>$data->email,"subjek"=>$subjek,"pesan"=>$message);
            $user = array("id_"=>$id,"username"=>$username,"password"=>md5(sha1($password)));
            $this->send_email($email);
            $this->anggota->create_account($user);
            echo json_encode(array("status"=>true));
        }

    }

    public function send_email($data)
    {
        $this->config->load("email");
        $config = $this->config->item("smtp");
        $this->load->library('email', $config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($this->config->item('email'), $this->config->item('email_name'));
        $this->email->to($data['email']);
        $this->email->subject($data['subjek']);
        $this->email->message(nl2br(htmlspecialchars_decode($data['pesan'])));
        $this->email->send();
    }

    public function send_email1($data)
    {
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $this->email->from($this->config->item('email'), $this->config->item('email_name'));
        $this->email->to($data['email']);

        $this->email->subject($data['subjek']);
        $this->email->message(nl2br(htmlspecialchars_decode($data['pesan'])));

        $this->email->send();
    }

    /*END INTI SECTION*/

    /*DPD SECTION*/
     public function get_member_dpd()
    {
        $this->load->model('model_anggota','anggota');
        $res = $this->anggota->get_datatables_member_dpd();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            $jk = $field->jk =="P"?"Perempuan":"Laki-laki";
            $action = '<button class="btn btn-primary btn-xs" onclick="edit_data(this)" data-value="'.$field->id.'"><i class="fa fa-pencil"></i></button>&nbsp;';
            $action .= '<button class="btn btn-danger btn-xs" onclick="hapus_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-trash"></i></button>';
            array_push($data,array($no++,$field->no_kta,$field->nama,$field->nama_jabatan,$action));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota->count_filtered_member_dpd(),
            "recordsFiltered" => $this->anggota->count_filtered_member_dpd(),
            "data" => $data)));
    }

    public function get_data_anggota_dpd()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_anggota");
        $hasil = $this->anggota->get_data_anggota_dpd($id);
        if($hasil){
            echo json_encode($hasil);
        }
    }

    public function update_anggota_dpd()
    {
        $this->load->model("Model_anggota","anggota");
        $id = trim($this->input->post('id'));
        $no_kta = trim($this->input->post('no_kta'));
        $nama = trim($this->input->post('nama'));
        $jk = trim($this->input->post('jk'));
        $id_jabatan = trim($this->input->post('id_jabatan'));
        $alamat = trim($this->input->post('alamat'));
        $keterangan = trim($this->input->post('keterangan'));
        $kode_prov = trim($this->input->post('kode_prov'));
        $data = array('no_kta'=>$no_kta,'nama'=>$nama,'jk'=>$jk,'id_jabatan'=>$id_jabatan,'alamat'=>$alamat,'keterangan'=>$keterangan,'kode_prov'=>$kode_prov);
        $hasil = $this->anggota->update_data_dpd($data,$id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function delete_anggota_dpd()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_anggota");
        $hasil = $this->anggota->delete_anggota_dpd($id);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function save_anggota_dpd()
    {
        $this->load->model("Model_anggota","anggota");
        $no_kta = trim($this->input->post('no_kta'));
        $nama = trim($this->input->post('nama'));
        $jk = trim($this->input->post('jk'));
        $id_jabatan = trim($this->input->post('id_jabatan'));
        $alamat = trim($this->input->post('alamat'));
        $keterangan = trim($this->input->post('keterangan'));
        $kode_prov = trim($this->input->post('kode_prov'));
        $data = array('no_kta'=>$no_kta,'nama'=>$nama,'jk'=>$jk,'id_jabatan'=>$id_jabatan,'alamat'=>$alamat,'keterangan'=>$keterangan,'kode_prov'=>$kode_prov);
        $hasil = $this->anggota->save_anggota_dpd($data);
        if($hasil){
            echo json_encode(array("status"=>true));
        }
    }

    public function get_ref_jabatan()
    {
        $this->load->model("model_anggota","anggota");
        $hasil = $this->anggota->get_ref_jabatan();
        echo json_encode($hasil);
    }

    /*SECTION CALON ANGGOTA PASUKAN UTAMA*/
    public function get_calon()
    {
        $this->load->model('model_anggota','anggota');
        $res = $this->anggota->get_datatables_member_calon();
        $data = array();
        $no = $_POST['start']+1;
        foreach ($res as $field) {
            $jk = $field->jk =="P"?"Perempuan":"Laki-laki";
            $action = '<button class="btn btn-primary btn-xs" onclick="edit_data(this)" data-value="'.$field->id.'"><i class="fa fa-eye"></i></button>&nbsp;';
            if($field->aktif == 0){
                $action .= '<button class="btn btn-success btn-xs" onclick="aprove_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-check"></i></button>';
            }

            $action .= '<button class="btn btn-danger btn-xs" onclick="hapus_data(this)" data-value="'.$field->id.'" data-nama="'.$field->nama.'"><i class="fa fa-trash"></i></button>&nbsp;';
            array_push($data,array($no++,$field->nama,$jk,$field->provinsi_nama,$action));
        }
        $this->output->set_output(json_encode(array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota->count_filtered_member_calon(),
            "recordsFiltered" => $this->anggota->count_filtered_member_calon(),
            "data" => $data)));
    }

    public function get_data_calon()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_calon");
        $hasil = $this->anggota->get_data_calon($id);
        if($hasil){
            echo json_encode($hasil);
        }
    }

    public function delete_calon()
    {
        $this->load->model("Model_anggota","anggota");
        $id = $this->input->post("id_calon");
        $data = $this->anggota->get_data_calon($id);
        $hasil = $this->anggota->delete_calon($id);
        if($hasil){
            $this->delete_dokument_calon($id);
            $message = "Anda telah melakukan registrasi.\r\nPermohonan Maaf.\r\nTerima kasih, Salam Remaja.\r\n
                DPP Purna Pasma KRN";
            $subjek = "DATA ANDA KAMI TOLAK.";
            $email = array("email"=>$data->email,"subjek"=>$subjek,"pesan"=>$message);
            $this->send_email($email);
            echo json_encode(array("status"=>true));
        }
    }

    public function delete_dokument_calon($id_calon)
    {
        $foto_path = './../assets/images/member_docs/calon_foto_'.$id_calon.'.jpg';
        $ktp_path = './../assets/images/member_docs/calon_ktp_'.$id_calon.'.jpg';
        if (file_exists($foto_path)) 
        unlink($foto_path);

        if (file_exists($ktp_path)) 
        unlink($ktp_path);
    }


    public function aprove_calon_()
    {
        $id = get_post("id_anggota");
        $data = array("status"=>1);

        $this->load->model("Model_anggota","anggota");
        $hasil = $this->anggota->update_calon($data,$id);
        if($hasil){
            $data = $this->anggota->get_data_calon($id);
            $nama = explode(" ", $data->nama);
            $username = $nama[0].rand();
            $password = $nama[0].rand();
            $message = "Salam REMAJA.\r\n\r\n";
            $message .= "Selamat data anda yang bernama ".$data->nama." telah kami verifikasi.\r\n";
            /*$message .= "Berikut Merupakan akun untuk melakukan login di portal ".BASE."\r\n";
            $message .= "Username : ".$username."\r\n";
            $message .= "Password : ".$password."\r\n";*/
            $message .= "Terima Kasih Telah mendaftar. REMAJA JAYA 5X\r\n";
            $message .= "\r\nDPP Purna Pasma KRN";

            $subjek = "DATA TERVERIFIKASI";
            $email = array("email"=>$data->email,"subjek"=>$subjek,"pesan"=>$message);
            $user = array("id_"=>$id,"username"=>$username,"password"=>md5(sha1($password)));
            $this->send_email($email);
            //$this->anggota->create_account($user);
            echo json_encode(array("status"=>true));
        }

    }
    /*END SECTION CALON ANGGOTA PASUKAN UTAMA*/


    /*Upload Data Using Excel*/
    public function upload(){
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $this->load->model("model_anggota","anggota");
        if(1 > 0 ){
            $fileName = time().$_FILES['file_anggota']['name'];

            $config['upload_path'] = './assets/xls_file/'; //buat folder dengan nama assets di root folder
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size'] = 10000;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if(! $this->upload->do_upload('file_anggota') )
            $this->upload->display_errors();

            $media = $this->upload->data('file_anggota');
            $inputFileName = "assets/xls_file/".$fileName;
            
            try {
                    $inputFileType = IOFactory::identify($inputFileName);
                    $objReader = IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    
                } catch(Exception $e) {
                    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                }

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                
                for ($row = 2; $row <= $highestRow; $row++){
                //  Read a row of data into an array                 
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                    NULL,
                                                    TRUE,
                                                    FALSE);
                                                    
                    //Sesuaikan sama nama kolom tabel di database
                    $tgl_lahir = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][3]));
                     $data = array(
                        'nama'=>$rowData[0][0],
                        'jk'=>$rowData[0][1],
                        'tempat_lahir'=>$rowData[0][2],
                        'tgl_lahir'=>$tgl_lahir,
                        'alamat'=>$rowData[0][4],
                        'no_hp'=>$rowData[0][5],
                        'email'=>$rowData[0][6],
                        'tahun_krn'=>$rowData[0][7],
                        'asal_krn'=>$rowData[0][8],
                        'asal_text_krn'=>$rowData[0][9],
                        'status_krn'=>$rowData[0][10],
                        'penugasan_krn'=>$rowData[0][11],
                        'penugasan_text_krn'=>$rowData[0][12],
                    );
                    //sesuaikan nama dengan nama tabel
                    $this->anggota->save_anggota($data);
                        
                }
                unlink($inputFileName);
            echo json_encode(array("status"=>"berhasil"));
        }
    }
    /*END Upload Data Using Excel*/

}
