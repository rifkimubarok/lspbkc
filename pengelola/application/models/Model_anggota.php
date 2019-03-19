<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model_anggota extends CI_Model
{
    private $anggota_table = "__anggota";
    private $anggota_inti_table = "__anggota_registrasi";
    private $anggota_calon_table = "__calon_anggota";
    private $status_table = "__ref_status_krn";
	private $anggota_dpd_table = "__pengurus_daerah";
    private $jabatan_table = "__ref_jabatan";
    private $member_table = "__users";
	function __construct()
	{
		parent::__construct();
	}

    public function get_ref_jabatan()
    {
        $hasil = $this->db->get($this->jabatan_table);
        return $hasil->result();
    }

	public function get_anggota()
	{
		$hasil =  $this->db->get('__anggota');
		return $hasil->result();
	}

	public function get_tahun_anggota()
	{
		$this->db->select("tahun_krn");
		$this->db->group_by("tahun_krn");
		$this->db->order_by("tahun_krn","asc");
		$hasil = $this->db->get($this->anggota_table);
		return $hasil->result();
	}

	public function get_data_anggota($id)
	{
		$this->db->where(array("id"=>$id));
		$hasil = $this->db->get($this->anggota_table);
		return $hasil->row();
	}

    public function save_anggota($data)
    {
        $hasil = $this->db->insert($this->anggota_table,$data);
        return $hasil;
    }

	public function update_data($data,$id)
	{
		$this->db->where(array("id"=>$id));
		$hasil = $this->db->update($this->anggota_table,$data);
		return $hasil;
	}

    public function delete_anggota($id)
    {
        $this->db->where(array("id"=>$id));
        $this->db->delete($this->anggota_table);
        $hasil = $this->db->affected_rows();
        return $hasil;
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

    /*INTI SECTION*/

    public function get_data_anggota_inti($id)
    {
        $this->db->select("a.*,upper(b.status) as status_");
        $this->db->where(array("a.id"=>$id));
        $this->db->from($this->anggota_inti_table.' a');
        $this->db->join($this->status_table.' b','on a.status_krn = b.id','inner');
        $hasil = $this->db->get();
        return $hasil->row();
    }

    public function save_anggota_inti($data)
    {
        $hasil = $this->db->insert($this->anggota_inti_table,$data);
        return $hasil;
    }

    public function create_account($data)
    {
        $this->db->insert($this->member_table,$data);
    }

    public function update_data_inti($data,$id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->update($this->anggota_inti_table,$data);
        return $hasil;
    }

    public function delete_anggota_inti($id)
    {
        $this->db->where(array("id"=>$id));
        $this->db->delete($this->anggota_inti_table);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    var $column_order_member_inti = array(null,'a.nama','a.jk', 'asal_text_krn','a.penugasan_text_krn',"b.status");
    var $column_search_member_inti = array('a.nama','a.jk', 'asal_text_krn','a.penugasan_text_krn',"b.status");
    var $order_inti = array('a.register_date'=>'desc');

    public function _get_datatables_query_member_inti()
    {
        $data = new myObject();
        $this->db->select('a.*,a.status as aktif,b.status');
        $this->db->from($this->anggota_inti_table.' a');
        $this->db->join($this->status_table.' b',"on a.status_krn = b.id","inner");
        $i = 0;

        foreach ($this->column_search_member_inti as $item) // loop column
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

                if(count($this->column_search_member_inti) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_member_inti[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order_inti;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_member_inti()
    {
        $this->_get_datatables_query_member_inti();
        $this->_get_custom_field_member_inti();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_member_inti()
    {
        $this->_get_datatables_query_member_inti();
        $this->_get_custom_field_member_inti();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_member_inti()
    {
        if(isset($_POST['status_krn']) && $_POST['status_krn'] != null){
            $status_krn = get_post('status_krn');
            $this->db->where(array('status_krn'=>$status_krn));
        }
    }

    /*END INTI SECTION*/


    /*DPD SECTION */
    public function get_data_anggota_dpd($id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->get($this->anggota_dpd_table);
        return $hasil->row();
    }

    public function save_anggota_dpd($data)
    {
        $hasil = $this->db->insert($this->anggota_dpd_table,$data);
        return $hasil;
    }

    public function update_data_dpd($data,$id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->update($this->anggota_dpd_table,$data);
        return $hasil;
    }

    public function delete_anggota_dpd($id)
    {
        $this->db->where(array("id"=>$id));
        $this->db->delete($this->anggota_dpd_table);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    var $column_order_member_dpd = array(null,'a.no_kta','a.nama','b.urutan',);
    var $column_search_member_dpd = array('a.no_kta','a.nama','a.id_jabatan',);
    var $order_dpd = array('b.urutan'=>'asc');

    public function _get_datatables_query_member_dpd()
    {
        $data = new myObject();
        $this->db->select('a.*,b.nama_jabatan');
        $this->db->from($this->anggota_dpd_table.' a');
        $this->db->join($this->jabatan_table.' b',"on a.id_jabatan = b.id","left");
        $i = 0;

        foreach ($this->column_search_member_dpd as $item) // loop column
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

                if(count($this->column_search_member_dpd) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_member_dpd[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order_dpd;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_member_dpd()
    {
        $this->_get_datatables_query_member_dpd();
        $this->_get_custom_field_member_dpd();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_member_dpd()
    {
        $this->_get_datatables_query_member_dpd();
        $this->_get_custom_field_member_dpd();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_member_dpd()
    {
        if(isset($_POST['provinsi']) && $_POST['provinsi'] != null){
            $provinsi = get_post('provinsi');
            $this->db->where(array('kode_prov'=>$provinsi));
        }
    }
    /*END DPD SECTION */


    /*SECTION CALON ANGGOTA UTAMA*/
    var $column_order_member_calon = array(null,'a.nama','a.jk','provinsi_nama',"a.status");
    var $column_search_member_calon = array('a.nama','a.jk','provinsi',"a.status");
    var $order_calon = array('a.register_date'=>'desc');

    public function _get_datatables_query_member_calon()
    {
        $data = new myObject();
        $this->db->select('a.*,a.status as aktif,b.name as provinsi_nama');
        $this->db->from($this->anggota_calon_table.' a');
        $this->db->join('ref_provinsi b',"on a.provinsi = b.kode","left");
        $i = 0;

        foreach ($this->column_search_member_calon as $item) // loop column
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

                if(count($this->column_search_member_calon) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_member_calon[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order_calon;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_member_calon()
    {
        $this->_get_datatables_query_member_calon();
        $this->_get_custom_field_member_calon();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_member_calon()
    {
        $this->_get_datatables_query_member_calon();
        $this->_get_custom_field_member_calon();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_member_calon()
    {
        if(isset($_POST['status_krn']) && $_POST['status_krn'] != null){
            $status_krn = get_post('status_krn');
            $this->db->where(array('status_krn'=>$status_krn));
        }
    }


    public function get_data_calon($id)
    {
        $this->db->select("a.*,b.name as provinsi_nama, c.nama as kabupaten_nama, d.nama as kecamatan_nama");
        $this->db->where(array("a.id"=>$id));
        $this->db->from($this->anggota_calon_table.' a');
        $this->db->join('ref_provinsi b','on a.provinsi = b.kode','left');
        $this->db->join('ref_kabupaten_kota c','on a.kabupaten = c.kode','left');
        $this->db->join('ref_kecamatan d','on a.kecamatan = d.kode','left');
        $hasil = $this->db->get();
        return $hasil->row();
    }

    public function save_calon($data)
    {
        $hasil = $this->db->insert($this->anggota_calon_table,$data);
        return $hasil;
    }

    public function update_calon($data,$id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->update($this->anggota_calon_table,$data);
        return $hasil;
    }

    public function delete_calon($id)
    {
        $this->db->where(array("id"=>$id));
        $this->db->delete($this->anggota_calon_table);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }
    /*END SECTION CALON ANGGOTA UTAMA*/

}