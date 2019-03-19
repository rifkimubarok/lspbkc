<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model_buku extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_buku()
	{
		$hasil =  $this->db->get('__buku');
		return $hasil->result();
	}

}