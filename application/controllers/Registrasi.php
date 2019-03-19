<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

    public function index()
    {
        $output['captcha'] = $this->create_captcha();
        $output['status_krn'] = 1;
        $output['title'] = "Registrasi Pasukan Utama";
        $this->template->display("content/registrasi",$output); 
    }

    public function inti()
    {
        $output['captcha'] = $this->create_captcha();
        $output['status_krn'] = 2;
        $output['title'] = "Registrasi Pasukan Inti";
        $this->template->display("content/registrasi",$output); 
    }

    public function sahabat()
    {
        $output['title'] = "Registrasi Sahabat KRN";
        $output['captcha'] = $this->create_captcha();
        $this->template->display("content/registrasi_sahabat",$output); 
    }

	public function calon()
	{
        $output['title'] = "Registrasi Calon Pasukan Inti";
		$output['captcha'] = $this->create_captcha();
		$this->template->display("content/registrasi_calon",$output);	
	}

	public function ref_status()
	{
		$this->load->model("model_data","data");
		$hasil = $this->data->get_ref_status("id in(1,2)");
		echo json_encode($hasil);
	}

	public function register()
    {
        $this->load->model("model_anggota","data");
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
        $tahun_krn = trim($this->input->post('tahun_krn'));
        $status_krn = trim($this->input->post('status_krn'));
        $saran = trim($this->input->post('saran'));
        $security_code = trim($this->input->post('security_code'));
        $data = array('nama'=>$nama,'jk'=>$jk,'tempat_lahir'=>$tempat_lahir,'tgl_lahir'=>$tgl_lahir,'no_hp'=>$no_hp,'email'=>$email,'alamat'=>$alamat,'asal_krn'=>$asal_krn,'asal_text_krn'=>$asal_text_krn,'penugasan_krn'=>$penugasan_krn,'penugasan_text_krn'=>$penugasan_text_krn,'tahun_krn'=>$tahun_krn,'status_krn'=>$status_krn,'saran'=>$saran);
        if($this->check_captcha($security_code)){
            $hasil = $this->data->register_anggota($data);
            $foto = $_POST['foto_file'];
            $ktp = $_POST['ktp_file'];
            if(isset($hasil->id)){
                $subjek = "TERIMAKASIH TELAH MENDAFTAR";
                $message = "Terimakasih\r\n
                            Data yang yang telah disampaikan akan kami Verifikasi. \r\n
                            Salam Remaja....\r\n
                            DPP Purna Pasma KRN";
                $email = array("email"=>$email,"subjek"=>$subjek,"pesan"=>$message);
                $this->upload_foto($foto,'foto_'.$hasil->id,400,600,80);
                $this->upload_foto($ktp,'ktp_'.$hasil->id,400,267,92);
                $this->send_email($email);
            }
            echo json_encode($hasil->message);
        }else{
            echo json_encode(array("status"=>false,"message"=>"Security Code Salah"));
        }
    }

    public function register_calon()
	{
		$this->load->model("model_anggota","data");
		$nama = trim($this->input->post('nama'));
		$jk = trim($this->input->post('jk'));
		$tempat_lahir = trim($this->input->post('tempat_lahir'));
		$tgl_lahir = trim($this->input->post('tgl_lahir'));
		$no_hp = trim($this->input->post('no_hp'));
		$email = trim($this->input->post('email'));
        $alamat = trim($this->input->post('alamat'));
        $provinsi = trim($this->input->post('provinsi'));
        $kabupaten = trim($this->input->post('kabupaten'));
        $kecamatan = trim($this->input->post('kecamatan'));
        $status_pendidikan = trim($this->input->post('status_pendidikan'));
		$alamat_instansi = trim($this->input->post('alamat_instansi'));
		$security_code = trim($this->input->post('security_code'));
		$data = array('nama'=>$nama,'jk'=>$jk,'tempat_lahir'=>$tempat_lahir,'tgl_lahir'=>$tgl_lahir,'no_hp'=>$no_hp,'email'=>$email,'alamat'=>$alamat,'provinsi'=>$provinsi,'kabupaten'=>$kabupaten,'kecamatan'=>$kecamatan,'status_pendidikan'=>$status_pendidikan,'alamat_instansi'=>$alamat_instansi,);
		if($this->check_captcha($security_code)){
			$hasil = $this->data->register_calon($data);
            $foto = $_POST['foto_file'];
            $ktp = $_POST['ktp_file'];
            if(isset($hasil->id)){
                $subjek = "TERIMAKASIH TELAH MENDAFTAR";
                $message = "Terimakasih\r\n
                            Data yang yang telah disampaikan akan kami Verifikasi. \r\n
                            Salam Remaja....\r\n
                            DPP Purna Pasma KRN";
                $email = array("email"=>$email,"subjek"=>$subjek,"pesan"=>$message);
                $this->upload_foto($foto,'calon_foto_'.$hasil->id,400,600,80);
                $this->upload_foto($ktp,'calon_ktp_'.$hasil->id,400,267,92);
                $this->send_email($email);
            }
			echo json_encode($hasil->message);
		}else{
			echo json_encode(array("status"=>false,"message"=>"Security Code Salah"));
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

	private function check_captcha($word)
    {
    	$data = $this->session->tempdata('security_regist');
    	if(isset($data->word) && $data->word == $word){
    		$check = new myObject();
    		$this->session->unset_tempdata('security_regist');
    		return 1;
    	}
    	$this->session->unset_tempdata('security_regist');
    	return 0;
    }

	private function create_captcha()
    {
        $this->load->helper('captcha');
        $cap_config = array(
            'img_path' => './' . $this->config->item('captcha_path'),
            'img_url' => base() . $this->config->item('captcha_path'),
            'font_path' => './assets/captcha/fonts/tes.otf',
            'font_size' => '18',
            'img_width' => $this->config->item('captcha_width'),
            'img_height' => $this->config->item('captcha_height'),
            'expiration'    => 300,
            'word_length'   => 6,
            'ip_address' => $this->input->ip_address(),
            'img_id'        => 'captcha_image',
            'pool'          => '0123456789',
            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(79, 135, 36)
            )
        );
        $cap = create_captcha($cap_config);
        // Save captcha params in session
        $data = new myObject();
        $data->word = $cap['word'];
        $data->image = $cap['image'];
        $this->session->set_tempdata('security_regist',$data,300);
        //set_flash('security_regist',$data);
        return $data;
    }

    public function refresh_captcha()
    {
        $hasil = $this->create_captcha();
        echo json_encode(array("image"=>$hasil->image));
    }

    public function upload_foto($image,$file_name,$width,$height,$quality){
        $baseFromJavascript = $image;
        $base_to_php = explode(',', $baseFromJavascript);
        $data = base64_decode($base_to_php[1]);
        $id = get_post("id");
        $filepath = './assets/images/member_docs/'.$file_name.'.jpg';
        if(file_put_contents($filepath,$data) != false){
            //echo json_encode(array("success"=>true,"foto"=>$baseFromJavascript));
            $this->fix_size($filepath,$width,$height,$quality);
            $this->create_thumb($filepath,40,60,50);
        }else{
            //echo json_encode(array("success"=>false));
        }
    }

    private function fix_size($file,$width1,$height1,$quality){
        $save = './assets/images/member_docs/';
        list($width, $height) = getimagesize($file) ;
        $file_name = basename($file);

        $modwidth = $width1;

        $diff = $width / $modwidth;

        $modheight = $height1;
        $tn = imagecreatetruecolor($modwidth, $modheight) ;
        $image = imagecreatefromjpeg($file) ;
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

        imagejpeg($tn, $save.$file_name, $quality) ;
    }

    private function create_thumb($file,$width1,$height1,$quality){
        $save = './assets/images/member_docs/';
        list($width, $height) = getimagesize($file) ;
        $file_name = "thumb_".basename($file);

        $modwidth = $width1;

        $diff = $width / $modwidth;

        $modheight = $height1;
        $tn = imagecreatetruecolor($modwidth, $modheight) ;
        $image = imagecreatefromjpeg($file) ;
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

        imagejpeg($tn, $save.$file_name, $quality) ;
    }

    public function get_provinsi(){
        $this->load->model('model_data');
        $hasil = $this->model_data->get_provinsi();
        $this->output->set_output(json_encode(array("provinsi"=>$hasil)));
    }

    public function get_kabupaten(){
        $this->load->model('model_data');
        $kode_prov = get_post('kode_prov');
        $hasil = $this->model_data->get_kabupaten($kode_prov);
        $this->output->set_output(json_encode(array("kabupaten"=>$hasil)));
    }

    public function get_kecamatan(){
        $this->load->model('model_data');
        $kode_kab = get_post('kode_kab');
        $hasil = $this->model_data->get_kecamatan($kode_kab);
        $this->output->set_output(json_encode(array("kecamatan"=>$hasil)));
    }

     public function get_kelurahan(){
        $this->load->model('model_data');
        $kode_kec = get_post('kode_kec');
        $hasil = $this->model_data->get_kelurahan($kode_kec);
        $this->output->set_output(json_encode(array("kelurahan"=>$hasil)));
    }

    public function update_photo()
    {
        $user = get_session("user");
        $foto = $_POST['image'];
        if(isset($user)){
            if($user->level == 1){
                $this->upload_foto($foto,'foto_'.$user->id,400,600,80);
            }else{
                $this->upload_foto($foto,'calon_foto_'.$user->id,400,600,80);
            }
        }
        echo json_encode(array("status"=>true));
    }

}