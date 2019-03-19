<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model_login extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function auth($data)
    {
        $this->db->select("id,nama,email,no_hp,username,level,id_,blokir");
        //$this->db->where(array("blokir"=>"N"));
        $this->db->where($data);
        $hasil = $this->db->get('v_member_all');
        if($hasil->num_rows()>0){
            $data = $hasil->row(1);
            if($data->blokir == "Y"){
                return array("status"=>false,"message"=>"Akun Anda di Nonaktifkan.");
            }
            $sesi = new myObject();
            $sesi->islogin = true;
            $sesi->nama = $data->nama;
            $sesi->id = $data->id;
            $sesi->email = $data->email;
            $sesi->no_hp = $data->no_hp;
            $sesi->level = $data->level;
            $sesi->user = $data->username;
            $sesi->id_member = $data->id_;
            set_session("user",$sesi);
            return array("status"=>true);
        }
        unset_session("user");
        return array("status"=>false,"message"=>"Username / Password Salah");
    }

	public function auth1($data)
	{
		$this->db->select('id');
		$this->db->where($data);
		$this->db->where(array("blokir"=>"N"));
		$hasil = $this->db->get('__users');
		if($hasil->num_rows()){
			$data = $hasil->row(1);
			$hasil = $this->set_sesi($data->id);
			if($hasil){
				$data = array("status"=>true);
				return $data;
			}
		}else{
			unset_session("user");
		}
		return array("status"=>false,"message"=>"Username / Password Salah");
	}

	public function set_sesi($id)
	{
		$this->db->select("id,nama,email");
        $this->db->where(array("id"=>$id));
        $this->db->from('__anggota_registrasi');
        $hasil = $this->db->get()->row(1);
        $member = new myObject();
        $member->islogin = true;
        $member->id = $hasil->id;
        $member->nama = $hasil->nama;
        $member->email = $hasil->email;
        set_session("user",$member);
        return true;
	}
}