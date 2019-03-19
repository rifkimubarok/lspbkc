<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model_Register extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function register($data)
	{
		if($this->check_email($data['email'])>0){
			return 2;
		}
		if($this->check_username($data['username'])>0){
			return 3;
		}
		return $this->db->insert('__users',$data);
	}

	public function check_email($email)
	{
		$this->db->where(array('email'=>$email));
		$this->db->select('email');
		$hasil = $this->db->get('__users');
		return $hasil->num_rows();
	}

	public function check_username($username)
	{
		$this->db->where(array('username'=>$username));
		$this->db->select('username');
		$hasil = $this->db->get('__users');
		return $hasil->num_rows();
	}
}