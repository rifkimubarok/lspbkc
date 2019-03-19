<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
    private $user;
	function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

    public function index()
    {
    	$this->load->model("model_data","data");
    	$output['user'] = $this->data->get_rincian_user($this->user->id);
    	$this->template->display("setting",$output);
    }

    public function save_profile()
    {
    	$nama = get_post_text("nama");
    	$email = get_post_text("email");
    	$no_hp = get_post_text("no_hp");

    	$data = array("nama"=>$nama,"email"=>$email,"no_hp"=>$no_hp);
    	$this->load->model();
    }

    public function save_data_member()
    {
    	$user = get_session("user");
    	if(isset($user->islogin) && $user->islogin){
	    	$nama = get_post("nama");
	    	$email = get_post("email");
	    	$no_hp = get_post("no_hp");
	    	$id_member = $user->id_member;
	    	$data = array("email"=>$email,"nama"=>$nama,"no_hp"=>$no_hp);	
	    	$this->load->model("model_data","data");
	    	$this->data->user_update($data,$id_member);
	    	echo json_encode(array("status"=>true));
    	}else{
    		echo json_encode(array("status"=>false,"message"=>"Sesi Telah Habis Silahkan Login Kembali."));
    	}
    }

    public function update_akun()
    {
    	$user = get_session("user");
    	if(isset($user->islogin) && $user->islogin){
	    	$cur_pass = get_post_text('cur_pass');
			$new_pass = get_post_text('new_pass');
			$con_pass = get_post_text('con_pass');
			$username = get_post_text('username');
			$stat_user = get_post_text('stat_user');
			if($new_pass == $con_pass){
				$this->load->model("model_data","data");
				$data = array("password"=>$new_pass);
				if(intval($stat_user)){
					$data['username'] = $username;
					$hasil = $this->data->check_username($username);
					if($hasil){
						echo json_encode(array("status"=>false,"message"=>"Username Sudah Ada."));
						return true;
					}
				}
				$hasil = $this->data->change_akun($data,$user->id,$cur_pass);
				echo json_encode($hasil);
			}else{
				echo json_encode(array("status"=>false,"message"=>"Konfirmasi Password Tidak Sama."));	
			}
		}else{
    		echo json_encode(array("status"=>false,"message"=>"Sesi Telah Habis Silahkan Login Kembali."));
    	}
    }



    public function upload_foto($image,$file_name,$width,$height,$quality){
        $baseFromJavascript = $image;
        $base_to_php = explode(',', $baseFromJavascript);
        $data = base64_decode($base_to_php[1]);
        $id = get_post("id");
        $filepath = './../assets/images/member_docs/'.$file_name.'.jpg';
        if(file_put_contents($filepath,$data) != false){
            //echo json_encode(array("success"=>true,"foto"=>$baseFromJavascript));
            $this->fix_size($filepath,$width,$height,$quality);
            $this->create_thumb($filepath,40,60,50);
        }else{
            //echo json_encode(array("success"=>false));
        }
    }

    private function fix_size($file,$width1,$height1,$quality){
        $save = './../assets/images/member_docs/';
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
        $save = './../assets/images/member_docs/';
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



    public function update_photo()
    {
        $user = get_session("user");
        $foto = $_POST['image'];
        $this->upload_foto($foto,'foto_'.$user->id,400,600,80);
        echo json_encode(array("status"=>true));
    }
}