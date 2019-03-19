<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model_data extends CI_Model
{
	private $berita_table = "berita";
	private $kategori_table = "kategori";
	private $agenda_table = "agenda";
	private $slider_table = '__slider_news';
	private $profile_table = '__profile';
    private $jabatan_table = '__ref_jabatan';
    private $struktur_table = '__ref_struktur';
    private $organisasi_table = '__struktur_organisasi';
    private $forum_table = '__forum';
    private $forum_komentar_table = '__forum_komentar';
    private $forum_komentar_reply_table = '__forum_komentar_reply';
    private $polling_table = '__polling';

	function __construct()
	{
		parent::__construct();
    }

    /*Statistik */
    public function get_statistik()
    {
        $hasil = $this->db->query("select (SELECT count(*) from hubungi where `status` = 1) as jml_pesan, 0 as jml_pendaftar");
        return $hasil->row();
    }

    public function get_json_total_pengunjung()
    {
        $sql = "SELECT UNIX_TIMESTAMP(tanggal) as tanggal,COUNT(*) as jumlah from statistik where tanggal BETWEEN (CURDATE() - INTERVAL '1' MONTH) AND CURDATE() GROUP BY 1";
        $hasil = $this->db->query($sql);
        $data = array();
        foreach ($hasil->result() as $item) {
            $row = array(intval($item->tanggal."000"),intval($item->jumlah));
            $data[] = $row;
        }
        return $data;
    }

    public function get_jml_pengunjung()
    {
        $sql = "call get_statistik";
        return $this->db->query($sql)->row();
    }

    public function get_notification()
    {
        $hasil = $this->db->query("call get_notification()");
        return $hasil->row();
    }
    /*End Statistik */

    /*SECTION LOGIN*/
    public function do_login($data)
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
    /*END SECTION*/

	/*SECTION MENU*/
	public function menu()
	{
		$this->db->order_by("urutan","asc");
		$hasil = $this->db->get_where("mainmenu",array("aktif"=>"Y"));
		$output = new myObject();
		if($hasil->num_rows() > 0){
			$data = $hasil->result();
			$menu = array();
			foreach ($data as $item) {
				$row = array();
				$row =$item;
				$row->submenu = $this->submenu($item->id_main);
				$menu[] = $row;
			}
			$output->data = $menu;
			$output->status = true;
		}else{
			$output->status = false;
		}
		return $output;
	}

	public function submenu($id)
	{
		$this->db->where(array("aktif"=>"Y","id_main"=>$id));
		$this->db->order_by("urutan","asc");
		$hasil = $this->db->get("submenu");
		$output = new myObject();
		if($hasil->num_rows() > 0 ){
			$data = $hasil->result();
			$output->data = $data;
			$output->status = true;
		}else{
			$output->status = false;
		}
		return $output;
	}
	
	public function headlin_news(){
		$this->db->where(array("headline"=>"Y"));
		$hasil = $this->db->get("berita");
		
	}
	/*END SECTION MENU*/

	/*SECTION BERITA*/

	var $column_order_berita = array(null,'judul','nama_lengkap', null,'tanggal');
    var $column_search_berita = array('judul');
    var $order = array('tanggal'=>'desc');

	public function _get_datatables_query_berita()
	{
        $data = new myObject();
        $this->db->select("a.*,ifnull(b.nama_kategori,'Unknown Category') as nama_kategori");
        $this->db->from($this->berita_table.' a');
        $this->db->join($this->kategori_table.' b','on a.id_kategori = b.id_kategori', 'left');
        $i = 0;

        foreach ($this->column_search_berita as $item) // loop column
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

                if(count($this->column_search_berita) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_berita[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

    function count_filtered_berita()
    {
        $this->_get_datatables_query_berita();
        $this->_get_custom_field_berita();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_berita()
    {
        $this->_get_datatables_query_berita();
        $this->_get_custom_field_berita();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_berita()
    {

    }

    public function _get_berita($id)
    {
    	$data = new myObject();
    	$hasil = $this->db->get_where("berita",array("id_berita"=>$id))->row();
    	if($hasil){
    		$data->data = $hasil;
    		$data->isi = htmlspecialchars_decode($hasil->isi_berita);
    	}
    	return $data;

    }

    public function update_berita($data,$id_berita)
    {
    	$this->db->where(array("id_berita"=>$id_berita));
    	$hasil = $this->db->update($this->berita_table,$data);
    	return $hasil;
    }

    public function save_berita($data)
    {
    	$this->db->insert($this->berita_table,$data);
    	$id = $this->db->insert_id();
    	if($this->db->affected_rows()){
    		return $id;
    	}
    	return 0;
    }

    public function delete_berita($id)
    {
    	$this->db->where(array("id_berita"=>$id));
    	$hasil = $this->db->delete($this->berita_table);
    	return $hasil;
    }

    public function get_komentar_count_berita($id_berita)
    {
        $sql = "SELECT ((SELECT count(a.id_berita) FROM berita a INNER JOIN komentar b ON a.id_berita = b.id_berita WHERE a.id_berita = ?)+
                (SELECT COUNT(a.id_berita) FROM komentar a INNER JOIN komentar_reply b on a.id_komentar = b.id_komentar where a.id_berita = ? )) as jml_komentar";
        $hasil = $this->db->query($sql,array($id_berita,$id_berita));
        return $hasil->row()->jml_komentar;
    }
	/*END SECTION BERITA*/

	/*SECTION AGENDA*/
	var $column_order_agenda = array(null,'tema','pengirim', 'tgl_mulai');
    var $column_search_agenda = array('judul');
    var $order_agenda = array('datediff'=>'asc');

	public function _get_datatables_query_agenda()
	{
        $data = new myObject();
        $this->db->select("*, abs(DATEDIFF(tgl_mulai, CURDATE())) as datediff");
        $this->db->from($this->agenda_table);
        $i = 0;

        foreach ($this->column_search_agenda as $item) // loop column
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

                if(count($this->column_search_agenda) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_agenda[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order_agenda;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}


    function count_filtered_agenda()
    {
        $this->_get_datatables_query_agenda();
        $this->_get_custom_field_agenda();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_agenda()
    {
        $this->_get_datatables_query_agenda();
        $this->_get_custom_field_agenda();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function _get_custom_field_agenda()
    {

    }

    public function _get_agenda($id)
    {
    	$data = new myObject();
    	$hasil = $this->db->get_where($this->agenda_table,array("id_agenda"=>$id))->row();
    	if($hasil){
    		$data->data = $hasil;
    		$data->isi = htmlspecialchars_decode($hasil->isi_agenda);
    	}
    	return $data;

    }

    public function update_agenda($data,$id_agenda)
    {
    	$this->db->where(array("id_agenda"=>$id_agenda));
    	$hasil = $this->db->update($this->agenda_table,$data);
    	return $hasil;
    }

    public function save_agenda($data)
    {
    	$this->db->insert($this->agenda_table,$data);
    	$id = $this->db->insert_id();
    	if($this->db->affected_rows()){
    		return $id;
    	}
    	return 0;
    }

    public function delete_agenda($id)
    {
    	$this->db->where(array("id_agenda"=>$id));
    	$hasil = $this->db->delete($this->agenda_table);
    	return $hasil;
    }
	/*END SECTION AGENDA*/

	/*SECTION SLIDESHOW*/
	function get_slider($limit = null,$status = null){
		$this->db->select('*,sha1(id) as ref');
		$this->db->where(array("status"=>$status));
		if($limit != null){
			$this->db->limit($limit);
		}
		$hasil = $this->db->get('__slider_news');
		return $hasil->result();
	}
	/*END SECTION SLIDESHOW*/

	/*SECTION PROFILE*/
	public function get_profile($seo)
	{
		$this->db->select("*,sha1(id_profile) as ref");
		$this->db->where(array("judul_seo"=>$seo));
		$hasil = $this->db->get($this->profile_table);
		return $hasil->row();
	}

    public function get_profile_content($id)
    {
        $this->db->where(array("id_profile"=>$id));
        $hasil = $this->db->get($this->profile_table)->row();
        $row = new myObject();
        $row->id_profile = $hasil->id_profile;
        $row->judul = $hasil->judul;
        $row->judul_seo = $hasil->judul_seo;
        $row->isi_profile = htmlspecialchars_decode($hasil->isi_profile);
        return $row;
    }

    public function save_profile($data,$id)
    {
        $this->db->where(array("id_profile"=>$id));
        $hasil = $this->db->update($this->profile_table,$data);
        return $hasil;
    }

    public function get_struktur()
    {
        $this->db->order_by("urutan","asc");
        $hasil = $this->db->get($this->struktur_table);
        return $hasil->result();
    }

    public function get_jabatan()
    {
        $this->db->where("id not in (4,5)");
        $this->db->order_by("urutan","asc");
        $hasil = $this->db->get($this->jabatan_table);
        return $hasil->result();
    }

    public function get_anggota_struktur($id)
    {
        $this->db->select("a.*,concat(b.nama_jabatan,' ',ifnull(a.keterangan,'')) as nama_jabatan,b.urutan,c.nama_struktur");
        $this->db->where(array("a.struktur"=>$id));
        $this->db->order_by("b.urutan,a.keterangan","asc");
        $this->db->from($this->organisasi_table.' a');
        $this->db->join($this->struktur_table.' c','on a.struktur = c.id','left');
        $this->db->join($this->jabatan_table.' b','on a.jabatan = b.id','left');
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function get_detail_profile($id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->get($this->organisasi_table);
        return $hasil->row();
    }

    public function update_data_struktur($data,$id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->update($this->organisasi_table,$data);
        return $hasil;
    }

    public function tambah_data_struktur($data)
    {
        $hasil = $this->db->insert($this->organisasi_table,$data);
        return $hasil;
    }

    public function delete_data_struktur($id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->delete($this->organisasi_table);
        return $hasil;
    }
	/*END SECTION PROFILE*/

	/*SECTION KATEGORI*/
	public function get_kategori()
	{
		$hasil = $this->db->get("kategori")->result();
		return $hasil;
	}
	/*END SECTION KATEGORI*/

    /*SECTION KONTAK*/
    var $column_order_kontak = array(null,'judul','nama_lengkap', null,'tanggal');
    var $column_search_kontak = array('judul');
    var $order_kontak = array('tanggal'=>'desc');

    public function _get_datatables_query_kontak()
    {
        $data = new myObject();
        $this->db->select("a.*,ifnull(b.nama_kategori,'Unknown Category') as nama_kategori");
        $this->db->from($this->berita_table.' a');
        $this->db->join($this->kategori_table.' b','on a.id_kategori = b.id_kategori', 'left');
        $i = 0;

        foreach ($this->column_search_kontak as $item) // loop column
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

                if(count($this->column_search_kontak) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_kontak[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order_kontak;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_kontak()
    {
        $this->_get_datatables_query_kontak();
        $this->_get_custom_field_kontak();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_kontak()
    {
        $this->_get_datatables_query_kontak();
        $this->_get_custom_field_kontak();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_kontak()
    {

    }

    public function get_content_pesan($page,$data =null)
    {
        switch ($page) {
            case 'kotak_masuk_data':
                $sql = "select * from hubungi order by tanggal desc";
                break;
            case 'kotak_keluar_data':
                $sql = "select * from shoutbox order by tanggal desc";
                break;
            case 'detail_pesan':
                if($data['type']=="inbox"){
                    $sql = "call get_pesan_pengunjung(".htmlspecialchars(clean($data['data'])).")";
                }else{
                    $sql = "select *,0 as inbox from shoutbox where id_shoutbox = '".htmlspecialchars(clean($data['data']))."'";
                }
                break;
            default:
                $sql = false;
                break;
        }

        if($sql){
            $hasil = $this->db->query($sql);
            return $hasil->result();
            /*return $this->db->last_query();*/
        }
        return false;
    }

    public function get_detail_pesan($id)
    {
        $this->db->where(array("id_hubungi"=>$id));
        $hasil = $this->db->get("hubungi")->row();
        return $hasil;
        /*return $this->db->last_query();*/
    }

    public function save_pesan_keluar($data)
    {
        $this->db->insert("shoutbox",$data);
        $this->send_email($data);
        return $this->db->affected_rows();
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
    /*ENDSECTION KONTAK*/

    /*SECTION SLIDER */
    var $column_order_slider = array(null,null,null,"urutan",null);
    var $column_search_slider = array('description');
    var $order_slider = array('urutan'=>'asc');

    public function _get_datatables_query_slider()
    {
        $data = new myObject();
        $this->db->select("*");
        $this->db->from($this->slider_table);
        $i = 0;

        foreach ($this->column_search_slider as $item) // loop column
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

                if(count($this->column_search_slider) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_slider[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order_slider;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    function count_filtered_slider()
    {
        $this->_get_datatables_query_slider();
        $this->_get_custom_field_slider();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_slider()
    {
        $this->_get_datatables_query_slider();
        $this->_get_custom_field_slider();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function _get_custom_field_slider()
    {

    }

    public function _get_slider($id)
    {
        $data = new myObject();
        $hasil = $this->db->get_where($this->agenda_table,array("id_agenda"=>$id))->row();
        if($hasil){
            $data->data = $hasil;
            $data->isi = htmlspecialchars_decode($hasil->isi_agenda);
        }
        return $data;

    }

    public function _get_slide_delete($id_slider)
    {
        $hasil = $this->get_data_slider($id_slider);
        $this->db->select("id,urutan");
        $this->db->order_by("urutan","asc");
        $this->db->where("urutan > ",$hasil->urutan);
        $data = $this->db->get($this->slider_table)->result();
        foreach ($data as $item) {
            $row = array("urutan"=>$item->urutan - 1);
            $this->update_slide($row,$item->id);
        }
        $this->db->delete($this->slider_table,array("id"=>$id_slider));
        return $this->db->affected_rows();
    }

    public function move_position_slider_up($id_slider)
    {
        $this->db->select("urutan");
        $this->db->where(array("id"=>$id_slider));
        $hasil = $this->db->get($this->slider_table);
        if($hasil->num_rows()>0){
            $data = $hasil->row();
            if($this->do_move_up($data->urutan)){
                $row = new myObject();
                $row->urutan = $data->urutan - 1;
                return $this->update_slide($row,$id_slider);
            }
        }
    }

    public function do_move_up($urutan)
    {
        $this->db->select("id,urutan");
        $this->db->where(array("urutan"=>$urutan-1));
        $hasil = $this->db->get($this->slider_table);
        if($hasil->num_rows() >0 ){
            $data = $hasil->row();
            $row = new myObject();
            $row->urutan = $data->urutan + 1;
            return $this->update_slide($row,$data->id);
        }
    }

    public function move_position_slider_down($id_slider)
    {
        $this->db->select("urutan");
        $this->db->where(array("id"=>$id_slider));
        $hasil = $this->db->get($this->slider_table);
        if($hasil->num_rows()>0){
            $data = $hasil->row();
            if($this->do_move_down($data->urutan)){
                $row = new myObject();
                $row->urutan = $data->urutan + 1;
                return $this->update_slide($row,$id_slider);
            }
        }
    }

    public function do_move_down($urutan)
    {
        $this->db->select("id,urutan");
        $this->db->where(array("urutan"=>$urutan+1));
        $hasil = $this->db->get($this->slider_table);
        if($hasil->num_rows() >0 ){
            $data = $hasil->row();
            $row = new myObject();
            $row->urutan = $data->urutan - 1;
            return $this->update_slide($row,$data->id);
        }
    }

    public function update_slide($data,$id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->update($this->slider_table,$data);
        return $hasil;
    }

    public function save_slide($data)
    {
        $this->db->insert($this->slider_table,$data);
        return $this->db->insert_id();
    }

    public function get_last_urutan()
    {
        $this->db->select("urutan");
        $this->db->order_by("urutan","desc");
        $hasil = $this->db->get($this->slider_table)->row();
        return $hasil->urutan;
    }

    public function get_data_slider($id_slider)
    {
        $this->db->where(array("id"=>$id_slider));
        $hasil = $this->db->get($this->slider_table);
        if($hasil->num_rows() > 0 ){
            $data = $hasil->row(1);
            $row = new myObject();
            $row->id = $data->id;
            $row->ref_id = sha1($data->id);
            $row->description = $data->description;
            $row->urutan = $data->urutan;
            return $row;
        }
    }

    /*END SLIDER SECTION*/

    /*START FORUM SECTION*/
    var $column_order_forum = array(null,'judul_forum','nama_pengirim', null,'tanggal');
    var $column_search_forum = array('judul_forum');
    var $orde_forum = array('date_insert'=>'desc');

    public function _get_datatables_query_forum()
    {
        $data = new myObject();
        $this->db->select("a.*,ifnull(b.nama_kategori,'Unknown Category') as nama_kategori");
        $this->db->from($this->forum_table.' a');
        $this->db->join($this->kategori_table.' b','on a.id_kategori = b.id_kategori', 'left');
        $i = 0;

        foreach ($this->column_search_forum as $item) // loop column
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

                if(count($this->column_search_forum) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_forum[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->orde_forum;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_forum()
    {
        $this->_get_datatables_query_forum();
        $this->_get_custom_field_forum();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_forum()
    {
        $this->_get_datatables_query_forum();
        $this->_get_custom_field_forum();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_forum()
    {
        $user = get_session("user");
        if(isset($_POST['checkedbox']) && $_POST['checkedbox']){
            $this->db->where(array("a.member_id"=>$user->id));
        }
    }

    public function _get_forum($id)
    {
        $data = new myObject();
        $hasil = $this->db->get_where($this->forum_table,array("id"=>$id))->row();
        if($hasil){
            $data->data = $hasil;
            $data->isi = htmlspecialchars_decode($hasil->content);
        }
        return $data;

    }

    public function update_forum($data,$id_forum)
    {
        $this->db->where(array("id"=>$id_forum));
        $hasil = $this->db->update($this->forum_table,$data);
        return $hasil;
    }

    public function save_forum($data)
    {
        $this->db->insert($this->forum_table,$data);
        $id = $this->db->insert_id();
        if($this->db->affected_rows()){
            return $id;
        }
        return 0;
    }

    public function delete_forum($id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->delete($this->forum_table);
        return $hasil;
    }

    public function get_komentar_count_forum($id_forum)
    {
        $sql = "SELECT ((SELECT count(a.id) FROM __forum a INNER JOIN __forum_komentar b ON a.id = b.id_forum WHERE a.id = ?)+
                (SELECT COUNT(a.id_forum) FROM __forum_komentar a INNER JOIN __forum_komentar_reply b on a.id_komentar = b.id_komentar where a.id_forum = ? )) as jml_komentar";
        $hasil = $this->db->query($sql,array($id_forum,$id_forum));
        return $hasil->row()->jml_komentar;
    }
    /*END FORUM SECTION*/

    /*SECTION USER MANAGEMENT*/
    public function get_user_data()
    {
        $this->db->select("id,nama,email,no_hp,blokir,username");
        $this->db->where("level < 9");
        $hasil = $this->db->get("v_member_all");
        return $hasil->result();
    }

    public function reset_pw_user($id)
    {
        $data = array("password"=>md5(sha1(12345)));
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->update("__users",$data);;
        return $hasil;
    }

    public function blok_user($data,$id)
    {
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->update("__users",$data);;
        return $hasil;
    }

    public function get_rincian_user($id)
    {
        $this->db->select("id,nama,email,no_hp");
        $this->db->where(array("id"=>$id));
        $hasil = $this->db->get("v_member_all");
        return $hasil->row(1);
    }

    public function user_update($data,$id)
    {
        $this->db->where(array("id"=>$id));
        $this->db->update('__administrator',$data);
        return $this->db->affected_rows();
    }

    public function check_username($username)
    {
        $hasil = $this->db->get_where('__users',array("username"=>$username));
        if($hasil->num_rows() > 0){
            return true;
        }
        return false;
    }

    public function change_akun($data,$id,$cur_pass)
    {
        if($this->check_cur_pass($cur_pass)){
            $this->db->where(array("id"=>$id));
            $this->db->update("__users",$data);
            $hasil = $this->db->affected_rows();
            if($hasil){
                return array("status"=>true);
            }else{
                return array("status"=>false,"message"=>"Terjadi Sebuah Kesalahan.");
            }
        }else{
            return array("status"=>false,"message"=>"Password Sekarang Salah.");
        }
    }

    public function check_cur_pass($cur_pass)
    {
        $user = get_session("user");
        $hasil = $this->db->get_where("__users",array("username"=>$user->user,"password"=>md5(sha1($cur_pass))));
        if($hasil->num_rows()>0){
            return true;
        }
        return false;
    }
    /*END SECTION USER MANAGEMENT*/

    /*SECTION SURVEI*/
    public function get_pie_survei()
    {
        $this->db->select("count(*) as jumlah,kepuasan");
        $this->db->group_by("kepuasan");
        $this->db->order_by("kepuasan","asc");
        $hasil = $this->db->get($this->polling_table);
        return $hasil->result();
    }
    /*END SECTION SURVEI*/

    /* SECTION MENU */
    public function getMenu()
    {
        $sql = "select a.*, ifnull(count(b.id_sub),0) as havesub from mainmenu a left outer join submenu b on a.id_main = b.id_main GROUP BY a.id_main ORDER BY a.urutan asc";
        $hasil = $this->db->query($sql)->result();
        $menu = array();
        $no = 1;
        $total = count($hasil);
        foreach($hasil as $item){
            $row = array();
            $row['id_main'] = $item->id_main;
            $row['text'] = $item->nama_menu;
            $row['link'] = $item->link;
            $row['aktif'] = $item->aktif;
            $row['urutan'] = $item->urutan;
            $row['isChild'] = 0;
            $row['position'] = $no == 1 ? "first" : ($no == $total ? "last" : "");
            if($item->havesub > 0){
                $row['children'] = $this->getSubMenu($item->id_main);
            }
            $menu[] = $row;
            $no++;
        }
        return $menu;
    }

    public function getSubMenu($parent_id)
    {
        $sql = "select * from submenu where id_main = ? order by urutan asc";
        $hasil = $this->db->query($sql,array($parent_id))->result();
        $submenu = array();
        $no = 1;
        $total = count($hasil);
        foreach ($hasil as $item) {
            $row = array();
            $row['id_sub'] = $item->id_sub;
            $row['text'] = $item->nama_sub;
            $row['link'] = $item->link_sub;
            $row['aktif'] = $item->aktif;
            $row['urutan'] = $item->urutan;
            $row['id_main'] = $item->id_main;
            $row['isChild'] = 1;
            $row['position'] = $no == 1 ? "first" : ($no == $total ? "last" : "");
            $submenu[] = $row;
            $no++;
        }
        return $submenu;
    }

    public function getParrentMenu()
    {
        $sql = "Select * from mainmenu order by urutan";
        $hasil = $this->db->query($sql)->result_array();
        return $hasil;
    }

    public function getLink()
    {
        $sql = 'SELECT nama_kategori as name_page,concat("kat/",id_kategori,"/",kategori_seo) as url FROM kategori
        UNION ALL
        SELECT judul as name_page, concat("hal/",id_halaman,"/",judul_seo) as url FROM __halaman';
        $hasil = $this->db->query($sql)->result();
        return $hasil;
    }

    public function save_main_menu($data = null,$where = null,$isNew)
    {
        if($isNew == 0){
            $this->db->where($where);
            $hasil = $this->db->update("mainmenu",$data);
            return $hasil;
        }

        if($isNew == 1){
            $sql = "call last_row('urutan','mainmenu')";
            $hasil = $this->db->query($sql);
            if($hasil->num_rows()>0){
                $row = $hasil->row();
                $urutan = intval($row->urutan) + 1;
            }else{
                $urutan = 1;
            }
            $hasil->next_result(); 
            $hasil->free_result(); 
            $data['urutan'] = $urutan;
            $this->db->insert("mainmenu",$data);
            return $this->db->affected_rows();
        }
    }

    public function save_sub_menu($data = null, $where = null, $isNew)
    {
        if($isNew == 0){
            $this->db->where($where);
            $hasil = $this->db->update("submenu",$data);
        }else{
            $sql = "select urutan from submenu where id_main = ? order by urutan desc limit 1";
            $hasil = $this->db->query($sql,array($data['id_main']));
            if($hasil->num_rows()>0){
                $row = $hasil->row();
                $urutan = intval($row->urutan) + 1;
            }else{
                $urutan = 1;
            }
            $data['urutan'] = $urutan;
            $this->db->insert("submenu",$data);
            $hasil = $this->db->affected_rows();
        }
        return $hasil;
    }

    public function move_position_up_menu($id_menu,$isChild)
    {
        $this->db->select("urutan");
        if($isChild == "1"){
            $this->db->where(array("id_sub"=>$id_menu));
            $hasil = $this->db->get("submenu");
        }else{
            $this->db->where(array("id_main"=>$id_menu));
            $hasil = $this->db->get("mainmenu");
        }
        if($hasil->num_rows()>0){
            $data = $hasil->row();
            if($this->do_move_up_menu($data->urutan,$isChild)){
                $row = new myObject();
                $row->urutan = $data->urutan - 1;
                if($isChild == "0"){
                    return $this->save_main_menu($row,array("id_main"=>$id_menu),0);
                }else{
                    return $this->save_sub_menu($row,array("id_sub"=>$id_menu),0);
                }
            }
        }
    }

    public function do_move_up_menu($urutan,$isChild)
    {
        $this->db->where(array("urutan"=>$urutan-1));
        if($isChild == "1"){
            $this->db->select("id_sub,urutan");
            $hasil = $this->db->get("submenu");
        }else{
            $this->db->select("id_main,urutan");
            $hasil = $this->db->get("mainmenu");
        }
        if($hasil->num_rows() >0 ){
            $data = $hasil->row();
            $row = new myObject();
            $row->urutan = $data->urutan + 1;
            if($isChild == "0"){
                return $this->save_main_menu($row,array("id_main"=>$data->id_main),0);
            }else{
                return $this->save_sub_menu($row,array("id_sub"=>$data->id_sub),0);
            }
        }
    }

    public function move_position_slider_down_menu($id_menu,$isChild)
    {
        $this->db->select("urutan");
        if($isChild == "1"){
            $this->db->where(array("id_sub"=>$id_menu));
            $hasil = $this->db->get("submenu");
        }else{
            $this->db->where(array("id_main"=>$id_menu));
            $hasil = $this->db->get("mainmenu");
        }
        if($hasil->num_rows()>0){
            $data = $hasil->row();
            if($this->do_move_down_menu($data->urutan,$isChild)){
                $row = new myObject();
                $row->urutan = $data->urutan + 1;
                if($isChild == "0"){
                    return $this->save_main_menu($row,array("id_main"=>$id_menu),0);
                }else{
                    return $this->save_sub_menu($row,array("id_sub"=>$id_menu),0);
                }
            }
        }
    }

    public function do_move_down_menu($urutan,$isChild)
    {
        if($isChild == "1"){
            $this->db->select("id_sub,urutan");
            $hasil = $this->db->get("submenu");
        }else{
            $this->db->select("id_main,urutan");
            $hasil = $this->db->get("mainmenu");
        }
        $this->db->where(array("urutan"=>$urutan+1));
        if($hasil->num_rows() >0 ){
            $data = $hasil->row();
            $row = new myObject();
            $row->urutan = $data->urutan - 1;
            if($isChild == "0"){
                return $this->save_main_menu($row,array("id_main"=>$data->id_main),0);
            }else{
                return $this->save_sub_menu($row,array("id_sub"=>$data->id_sub),0);
            }
        }
    }

    public function remove_menu($id_main,$isChild)
    {
        if($isChild == 1){
            $sql = "select id_sub,urutan,id_main from submenu where id_sub = ?";
            $row = $this->db->query($sql,array($id_main))->row();

            $sql = "select ((urutan)-1) as urutan,id_sub,id_main from submenu where urutan > ? and id_main = ? order by urutan asc";
            $hasil = $this->db->query($sql,array($row->urutan,$row->id_main))->result();
            foreach($hasil as $item){
                $data = array("urutan"=>$item->urutan);
                $where = array("id_sub"=>$item->id_sub);
                $this->save_sub_menu($data,$where,0);
            }
            $this->db->delete("submenu",array("id_sub"=>$id_main));
        }else{
            $sql = "select id_main,((urutan)-1) as urutan from mainmenu where urutan > (select urutan from mainmenu where id_main = ?)";
            $hasil = $this->db->query($sql,array($id_main))->result();
            foreach($hasil as $row){
                $data = array("urutan"=>$row->urutan);
                $where = array("id_main"=>$row->id_main);
                $this->save_main_menu($data,$where,0);
            }
            $this->db->delete("mainmenu",array("id_main"=>$id_main));
        }
        return $this->db->affected_rows();
    }
    /* END SECTION MENU */


    /* SECTION HALAMAN STATIC */
    var $column_order_halaman = array(null,'judul','tanggal');
    var $column_search_halaman = array('judul');
    var $order_halaman = array('tanggal'=>'desc');

	public function _get_datatables_query_halaman()
	{
        $data = new myObject();
        $this->db->select("*");
        $this->db->from('__halaman');
        $i = 0;

        foreach ($this->column_search_halaman as $item) // loop column
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

                if(count($this->column_search_halaman) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_halaman[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order_halaman;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

    function count_filtered_halaman()
    {
        $this->_get_datatables_query_halaman();
        $this->_get_custom_field_halaman();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_halaman()
    {
        $this->_get_datatables_query_halaman();
        $this->_get_custom_field_halaman();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_halaman()
    {

    }

    public function save_halaman($data)
    {
        $this->db->insert("__halaman",$data);
        return $this->db->affected_rows();
    }

    public function update_halaman($data,$where)
    {
        $this->db->where($where);
        $this->db->update("__halaman",$data);
        return $this->db->affected_rows();
    }

    public function get_halaman_single($where)
    {
        $this->db->where($where);
        $hasil = $this->db->get("__halaman");
        return $hasil->row();
    }

    public function delete_halaman($where)
    {
        $this->db->where($where);
        $this->db->delete("__halaman");
        return $this->db->affected_rows();
    }
    
    /* END SECTION HALAMAN STATIC */
}