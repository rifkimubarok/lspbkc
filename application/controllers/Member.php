<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	private $user;
	function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        if(!isset($this->user->islogin) && !$this->user->islogin){
        	redirect("logout");
        }else{
            if($this->user->level == 9){
                redirect(BASEURL."pengelola");
            }
        }
    }

    public function index()
    {
    	$user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
        	$this->load->model("model_data","data");
        	$output['user'] = $this->data->get_rincian_user($user->id);
            $output['title'] = "Member Area";
        	$this->template->display('member/index',$output);
        }
    }

    public function save_data_member()
    {
    	$user = get_session("user");
    	if(isset($user->islogin) && $user->islogin){
	    	$email = get_post("email");
	    	$no_hp = get_post("no_hp");
	    	$id_member = $user->id_member;
	    	$data = array("email"=>$email,"no_hp"=>$no_hp);	
	    	$this->load->model("model_data","data");
	    	$this->data->user_update($data,$id_member);
	    	echo json_encode(array("status"=>true));
    	}else{
    		echo json_encode(array("status"=>false,"Message"=>"Sesi Telah Habis Silahkan Login Kembali."));
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
						echo json_encode(array("status"=>false,"Message"=>"Username Sudah Ada."));
						return true;
					}
				}
				$hasil = $this->data->change_akun($data,$user->id,$cur_pass);
				echo json_encode($hasil);
			}else{
				echo json_encode(array("status"=>false,"Message"=>"Konfirmasi Password Tidak Sama."));	
			}
		}else{
    		echo json_encode(array("status"=>false,"Message"=>"Sesi Telah Habis Silahkan Login Kembali."));
    	}
    }

    public function get_forum()
    {
    	$this->load->model("model_data","data");
    	$this->load->library('pagination');
		$config = array();
        $config["base_url"] = BASEURL . "berita/index";
        $total_row = $this->data->count_forum();
        $config["total_rows"] = $total_row;
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp;<a class="active">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
        $page = ($this->uri->segment(3)) ;
          }
        else{
               $page = 1;
        }
        $ofset = ($page - 1) * $config["per_page"];
        $data["forum"] = $this->data->get_forum($ofset,$config["per_page"],null,null,null,$this->user->id);
        $str_links = $this->pagination->create_links();
        $data["links"] = /*explode('&nbsp;',$str_links );*/$str_links;
		$this->load->view("member/post_forum",$data);
    }



    public function post_diskusi()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            
            $judul = get_post_text("judul_forum");
            $content = htmlspecialchars(get_post_text("summernote"));
            $judul_seo = strlen($judul) > 70 ? rand().'-'.url_title(substr($judul, 0,70),'-',true) : rand().'-'.url_title($judul,'-',true);
            $member_id = $user->id;
            $nama_pengirim = $user->nama;
            $data = array("member_id"=>$member_id,"nama_pengirim"=>$nama_pengirim,"judul_forum"=>$judul,"seo_judul"=>$judul_seo,"content"=>$content);
            $hasil = $this->data->post_forum($data);
            if($hasil){
                echo json_encode(array("status"=>true));
            }
        }else{
            echo json_encode(array("status"=>false));
            redirect("logout");
        }
    }

    public function update_diskusi()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            
            $id = get_post_text("forum_id");
            $judul = get_post_text("judul_forum");
            $content = htmlspecialchars(get_post_text("summernote"));
            $member_id = $user->id;
            $nama_pengirim = $user->nama;
            $data = array("judul_forum"=>$judul,"content"=>$content);
            $where = array("id"=>$id,"member_id"=>$member_id);
            $hasil = $this->data->update_forum($data,$where);
            if($hasil){
                echo json_encode(array("status"=>true));
            }
        }else{
            echo json_encode(array("status"=>false));
            redirect("logout");
        }
    }

    public function hapus_forum()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            
            $id = get_post_text("forum_id");
            $member_id = $user->id;
            $where = array("id"=>$id,"member_id"=>$member_id);
            $hasil = $this->data->hapus_forum($where);
            if($hasil){
                echo json_encode(array("status"=>true));
            }
        }else{
            echo json_encode(array("status"=>false));
            redirect("logout");
        }
    }

    public function status_forum()
    {
        $user = get_session("user");
        if(isset($user->islogin) && $user->islogin){
            $this->load->model("model_data","data");
            
            $id = get_post_text("forum_id");
            $status = get_post_text("status");
            $member_id = $user->id;
            $where = array("id"=>$id,"member_id"=>$member_id);
            $data = array("status"=>$status);
            $hasil = $this->data->update_forum($data,$where);
            if($hasil){
                echo json_encode(array("status"=>true));
            }
        }else{
            echo json_encode(array("status"=>false));
            redirect("logout");
        }
    }

    public function get_single_forum()
    {
        $id = get_post("forum_id");
        $this->load->model("model_data","data");
        $member_id = $this->user->id;
        $hasil = $this->data->get_forum(0,1,null,$id,null,$member_id);
        $output = new myObject();
        $output->id = $hasil[0]->id;
        $output->judul_forum = $hasil[0]->judul_forum;
        $output->content = htmlspecialchars_decode($hasil[0]->content);
        echo json_encode($output);
    }

    public function test_query()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->get_forum(0,100,null,null,1);
        echo json_encode($hasil);
    }

    public function get_form_update()
    {
        $this->load->view("member/update_photo");
    }
}