<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model_anggota extends CI_Model
{
    private $anggota_table = '__anggota';
    private $anggota_registrasi_table = '__anggota_registrasi';
	private $calon_anggota_table = '__calon_anggota';

	function __construct()
	{
		parent::__construct();
	}

	public function get_anggota()
	{
		$hasil =  $this->db->get('__anggota');
		return $hasil->result();
	}

	var $column_order_member = array(null,'nama','jk', 'asal_text_krn','penugasan_text_krn',"tahun_krn");
    var $column_search_member = array('nama','jk', 'asal_text_krn','penugasan_text_krn',"tahun_krn");
    var $order = array('nama'=>'asc');

	public function _get_datatables_query_member()
	{
        $data = new myObject();
        $this->db->from($this->anggota_table);
        $i = 0;

        foreach ($this->column_search_member as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_member) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_member[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

    function count_filtered_member()
    {
        $this->_get_datatables_query_member();
        $this->_get_custom_field_member();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_member()
    {
        $this->_get_datatables_query_member();
        $this->_get_custom_field_member();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_member()
    {
    	if(isset($_POST['tahun_krn']) && $_POST['tahun_krn'] != null){
    		$tahun = get_post('tahun_krn');
    		$this->db->where(array('tahun_krn'=>$tahun));
    	}
    }

    public function get_angkata()
    {
    	$this->db->select('tahun_krn');
    	$this->db->group_by('tahun_krn');
    	return $this->db->get($this->anggota_table)->result();
    }

    public function register_anggota($data)
    {
        $row = new myObject();
        if(!$this->check_anggota($data)){
            $this->db->insert($this->anggota_registrasi_table,$data);
            if($this->db->affected_rows()){
                $row->id = $this->db->insert_id();
                $row->message = array("status"=>true);
                return $row;
            }
            $row->message = array("status"=>false,"message"=>"Data gagal disimpan.");
            return $row;
        }
        $row->message = array("status"=>false,"message"=>"Data dengan nama ".$data['nama']." sudah terdaftar");
        return $row;
    }

    private function check_anggota($data)
    {
        $this->db->where(array("nama"=>$data['nama'],"tempat_lahir"=>$data['tempat_lahir'],"tgl_lahir"=>$data['tgl_lahir']));
        $hasil = $this->db->get($this->anggota_registrasi_table);
        return $hasil->num_rows();
    }

    public function register_calon($data)
    {
        $row = new myObject();
        if(!$this->check_calon($data)){
            $this->db->insert($this->calon_anggota_table,$data);
            if($this->db->affected_rows()){
                $row->id = $this->db->insert_id();
                $row->message = array("status"=>true);
                return $row;
            }
            $row->message = array("status"=>false,"message"=>"Data gagal disimpan.");
            return $row;
        }
        $row->message = array("status"=>false,"message"=>"Data dengan nama ".$data['nama']." sudah terdaftar");
        return $row;
    }

    private function check_calon($data)
    {
        $this->db->where(array("nama"=>$data['nama'],"tempat_lahir"=>$data['tempat_lahir'],"tgl_lahir"=>$data['tgl_lahir']));
        $hasil = $this->db->get($this->calon_anggota_table);
        return $hasil->num_rows();
    }

}