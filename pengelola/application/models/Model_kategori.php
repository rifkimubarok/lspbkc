<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model_kategori extends CI_Model
{
    private $kategori_table = "kategori";
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_data($seo_kategori){
	    
	}

    var $column_order_kategori = array(null,'nama_kategori',null);
    var $column_search_kategori = array('nama_kategori');
    var $orde_kategori = array('id_kategori'=>'desc');

    public function _get_datatables_query_kategori()
    {
        $data = new myObject();
        $this->db->select("*");
        $this->db->from($this->kategori_table);
        $i = 0;

        foreach ($this->column_search_kategori as $item) // loop column
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

                if(count($this->column_search_kategori) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_kategori[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->orde_kategori;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_kategori()
    {
        $this->_get_datatables_query_kategori();
        $this->_get_custom_field_kategori();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_kategori()
    {
        $this->_get_datatables_query_kategori();
        $this->_get_custom_field_kategori();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_kategori()
    {

    }

    function get_kategori(){
        return $this->db->get($this->kategori_table)->result();
    }

    function get_kategori_single($id_kategori){
        $this->db->where(array("id_kategori"=>$id_kategori));
        $hasil = $this->db->get($this->kategori_table);
        return $hasil->row();
    }

    function save_kategori($data){
        $this->db->insert($this->kategori_table,$data);
        return $this->db->affected_rows();
    }

    function update_kategori($data,$id_kategori){
        $this->db->where(array("id_kategori"=>$id_kategori));
        $hasil = $this->db->update($this->kategori_table,$data);
        return $hasil;
    }
    
}