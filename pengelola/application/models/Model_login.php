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
		$this->db->select('id,nama,email');
		$this->db->where($data);
		$hasil = $this->db->get('__users');
		return $hasil->row();
	}
}