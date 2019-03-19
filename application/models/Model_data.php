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
	private $halaman_table = '__halaman';
	private $pengurus_table = '__pengurus_daerah';
	private $jabatan_table = '__ref_jabatan';
	private $struktur_table = '__ref_struktur';
	private $organisasi_table = '__struktur_organisasi';
	private $pesan_table = 'hubungi';
	private $komentar_table = 'komentar';
	private $reply_komentar_table = 'komentar_reply';
	private $refstatus_table = '__ref_status_krn';
	private $anggota_register = '__anggota_registrasi';
	private $forum_table = '__forum';
	private $forum_komentar_table = '__forum_komentar';
	private $forum_komentar_reply_table = '__forum_komentar_reply';

	function __construct()
	{
		parent::__construct();
	}

	public function get_sitemap()
	{
		$hasil = $this->db->get("v_sitemap")->result();
		return $hasil;
	}

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
	public function get_berita($ofset,$limit,$seo_judul = null,$id = null,$status = null,$kategori = null)
	{
		if($seo_judul != null){
			$sql = "call add_berita_baca(?)";
			$this->db->query($sql,array($seo_judul));
		}
		$this->db->select('a.*,ifnull(b.nama_kategori,"Unknown Category") as nama_kategori,ifnull(b.kategori_seo,"unknown-category") as kategori_seo,sha1(a.id_berita) as ref');
		$this->db->from($this->berita_table.' a');
		$this->db->join($this->kategori_table.' b','on a.id_kategori = b.id_kategori','left');
		$this->db->limit($limit,$ofset);
		if($status != null){
			$this->db->where(array("status"=>$status));
		}
		if($seo_judul != null){
			$this->db->where(array("a.judul_seo"=>$seo_judul));
		}
		if($id != null){
			$this->db->where(array("a.id_berita"=>$id));
		}
		if($kategori != null){
			$this->db->where(array("a.id_kategori"=>$kategori));
		}
		$this->db->order_by('a.tanggal','desc');
		return $this->db->get()->result();
	}

	public function count_berita($status = null,$kategori = null)
	{
		if($status != null){
			$this->db->where(array("status"=>$status));
		}
		if($kategori != null){
			$this->db->where(array("id_kategori"=>$kategori));
		}
		return $this->db->get($this->berita_table)->num_rows();
	}

	public function get_komentar_berita($seo_judul)
	{
		$this->db->select("a.*");
		$this->db->from($this->komentar_table.' a');
		$this->db->join($this->berita_table.' b','on a.id_berita = b.id_berita','inner');
		$this->db->where(array("b.judul_seo"=>$seo_judul));
		$hasil = $this->db->get();
		$data = array();
		$total = 0;
		if ($hasil->num_rows() > 0) {
			foreach ($hasil->result() as $item) {
				$total++;
				$row = array();
				$row['komentar'] = $item;
				$row['reply_komentar'] = $this->get_reply_komentar_berita($item->id_komentar);
				$total += $row['reply_komentar']->total_komentar;
				array_push($data, $row);
			}
		}
		$output = new myObject();
		$output->data = $data;
		$output->total_komentar = $total;
		return $output;
	}

	private function get_reply_komentar_berita($id_komentar)
	{
		$this->db->where(array("id_komentar"=>$id_komentar));
		$hasil = $this->db->get($this->reply_komentar_table);
		$reply_komentar = new myObject();
		if($hasil->num_rows() > 0){
			$reply_komentar->status = true;
			$reply_komentar->data = $hasil->result();
		}else{
			$reply_komentar->status = false;
		}
		$reply_komentar->total_komentar = $hasil->num_rows();
		return $reply_komentar;
	}

	public function post_komentar_berita($data)
	{
		$hasil = $this->db->insert($this->komentar_table,$data);
		return $hasil;
	}

	public function reply_comment_berita($data)
	{
		$hasil = $this->db->insert($this->reply_komentar_table,$data);
		return $hasil;
	}
	/*END SECTION BERITA*/

	/*SECTION AGENDA*/
	public function get_agenda($ofset,$limit,$status = null,$seo_judul = null,$id = null)
	{
		if($seo_judul != null){
			$this->db->where(array("tema_seo"=>$seo_judul));
		}
		if($status != null){
			$this->db->where(array("status"=>$status));
		}
		$this->db->select("*,sha1(id_agenda) as ref,DATEDIFF(tgl_mulai, CURDATE()) as date_diff ");
		$this->db->from("agenda");
		$this->db->limit($limit,$ofset);
		$this->db->order_by('(case when date_diff < 0 then 1 else 0 end), abs(date_diff) asc');
		return $this->db->get()->result();
		/*$sql = "SELECT   *,sha1(id_agenda) as ref,DATEDIFF(tgl_mulai, CURDATE()) as date_diff FROM agenda ORDER BY (case when date_diff < 0 then 1 else 0 end), abs(date_diff) asc LIMIT ?,?";*/
		/*return $this->db->query($sql,array($ofset,$limit))->result();*/
	}

	public function count_agenda()
	{
		$sql = "SELECT   *,sha1(id_agenda) as ref,DATEDIFF(tgl_mulai, CURDATE()) as date_diff FROM agenda ORDER BY (case when date_diff < 0 then 1 else 0 end), abs(date_diff) asc";
		$hasil = $this->db->query($sql);
		return $hasil->num_rows();
	}

	public function get_komentar_agenda($seo_judul)
	{
		$this->db->select("a.*");
		$this->db->from($this->komentar_table.' a');
		$this->db->join($this->agenda_table.' b','on a.id_agenda = b.id_agenda','inner');
		$this->db->where(array("b.tema_seo"=>$seo_judul));
		$hasil = $this->db->get();
		$data = array();
		$total = 0;
		if ($hasil->num_rows() > 0) {
			foreach ($hasil->result() as $item) {
				$total++;
				$row = array();
				$row['komentar'] = $item;
				$row['reply_komentar'] = $this->get_reply_komentar_agenda($item->id_komentar);
				$total += $row['reply_komentar']->total_komentar;
				array_push($data, $row);
			}
		}
		$output = new myObject();
		$output->data = $data;
		$output->total_komentar = $total;
		return $output;
	}

	private function get_reply_komentar_agenda($id_komentar)
	{
		$this->db->where(array("id_komentar"=>$id_komentar));
		$hasil = $this->db->get($this->reply_komentar_table);
		$reply_komentar = new myObject();
		if($hasil->num_rows() > 0){
			$reply_komentar->status = true;
			$reply_komentar->data = $hasil->result();
		}else{
			$reply_komentar->status = false;
		}
		$reply_komentar->total_komentar = $hasil->num_rows();
		return $reply_komentar;
	}
	/*END SECTION AGENDA*/

	/*SECTION SLIDESHOW*/
	function get_slider($limit = null,$status = null){
		$this->db->select('*,sha1(id) as ref');
		$this->db->order_by("urutan","asc");
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

	
	public function get_halaman($id_halaman)
	{
		$this->db->select("*,sha1(id_halaman) as ref");
		$this->db->where(array("id_halaman"=>$id_halaman));
		$hasil = $this->db->get($this->halaman_table);
		return $hasil->row();
	}

	public function get_struktur()
	{
		$this->db->order_by("urutan","asc");
		$hasil = $this->db->get($this->struktur_table);
		return $hasil->result();
	}

	public function get_anggota_struktur($id)
	{
		$this->db->select("a.*,concat(b.nama_jabatan,' ',ifnull(a.keterangan,' ')) as nama_jabatan,b.urutan,c.nama_struktur");
		$this->db->where(array("a.struktur"=>$id));
		$this->db->order_by("b.urutan,a.keterangan","asc");
		$this->db->from($this->organisasi_table.' a');
		$this->db->join($this->struktur_table.' c','on a.struktur = c.id','left');
		$this->db->join($this->jabatan_table.' b','on a.jabatan = b.id','left');
		$hasil = $this->db->get();
		return $hasil->result();
	}
	/*END SECTION PROFILE*/

	/*SECTION DPD*/
	public function get_provinsi()
	{
		return $this->db->get("ref_provinsi")->result();
	}

	var $column_order_dpd = array(null,'no_kta','nama', 'urutan','alamat');
    var $column_search_dpd = array('no_kta','nama', 'nama_jabatan','alamat');
    var $order = array('a.id_jabatan'=>'asc');

	public function _get_datatables_query_dpd()
	{
        $data = new myObject();
        $this->db->select("a.*,b.nama_jabatan,concat(b.nama_jabatan,' ',ifnull(a.keterangan,' ')) as jabatan");
        $this->db->from($this->pengurus_table.' a');
        $this->db->join($this->jabatan_table.' b','on a.id_jabatan = b.id', 'left');
        $i = 0;

        foreach ($this->column_search_dpd as $item) // loop column
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

                if(count($this->column_search_dpd) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_dpd[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

    function count_filtered_dpd()
    {
        $this->_get_datatables_query_dpd();
        $this->_get_custom_field_dpd();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_datatables_dpd()
    {
        $this->_get_datatables_query_dpd();
        $this->_get_custom_field_dpd();

        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function _get_custom_field_dpd()
    {
    	if (isset($_POST['provinsi']) && $_POST['provinsi'] != null) {
    		$provinsi = get_post("provinsi");
    		$this->db->where(array("a.kode_prov"=>$provinsi));
    	}
    }
	/*END SECTIOn DPD*/

	/*SECTION PESAN*/
	public function send_message($data)
	{
		$hasil = $this->db->insert($this->pesan_table,$data);
		return $hasil;
	}
	/*END SECTION PESAN*/

	/*SECTION REFERENSI STATUS KRN*/
	public function get_ref_status($where = null)
	{
		if($where != null){
			$this->db->where($where);
		}
		return $this->db->get($this->refstatus_table)->result();
	}
	/*END SECTION REFERENSI STATUS KRN*/


	/*SECTION USER*/
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
		$this->db->update($this->anggota_register,$data);
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
	/*END SECTION USER*/


	/*SECTION FORUM*/
	public function get_forum_user()
	{
		$user = get_session("user");
		$this->db->where(array("member_id"=>$user->id));
		$hasil = $this->db->get($this->forum_table);
		return $hasil->result();
	}

	public function get_forum($ofset,$limit,$seo_judul = null,$id = null,$status = null,$member_id=null)
	{
		if($seo_judul != null){
			$sql = "call add_forum_baca(?)";
			$this->db->query($sql,array($seo_judul));
		}
		$this->db->select('*');
		$this->db->from($this->forum_table);
		$this->db->limit($limit,$ofset);
		if($status != null){
			$this->db->where(array("status"=>$status));
		}
		if($seo_judul != null){
			$this->db->where(array("seo_judul"=>$seo_judul));
		}
		if($id != null){
			$this->db->where(array("id"=>$id));
		}
		$this->db->order_by('date_insert','desc');
		return $this->db->get()->result();
	}

	public function count_forum($status = null)
	{
		if($status != null){
			$this->db->where(array("status"=>$status));
		}
		return $this->db->get($this->forum_table)->num_rows();
	}

	public function post_komentar_forum($data)
	{
		$this->db->insert($this->forum_komentar_table,$data);
		return $this->db->affected_rows();
	}

	public function post_komentar_reply($data)
	{
		$this->db->insert($this->forum_komentar_reply_table,$data);
		return $this->db->affected_rows();
	}


	public function get_komentar_forum($seo_judul)
	{
		$this->db->select("b.*");
		$this->db->from($this->forum_table.' a');
		$this->db->join($this->forum_komentar_table.' b','on a.id = b.id_forum','inner');
		$this->db->where(array("a.seo_judul"=>$seo_judul));
		$hasil = $this->db->get();
		$data = array();
		$total = 0;
		if ($hasil->num_rows() > 0) {
			foreach ($hasil->result() as $item) {
				$total++;
				$row = array();
				$row['komentar'] = $item;
				$row['reply_komentar'] = $this->get_reply_komentar_forum($item->id_komentar);
				$total += $row['reply_komentar']->total_komentar;
				array_push($data, $row);
			}
		}
		$output = new myObject();
		$output->data = $data;
		$output->total_komentar = $total;
		return $output;
	}

	private function get_reply_komentar_forum($id_komentar)
	{
		$this->db->where(array("id_komentar"=>$id_komentar));
		$hasil = $this->db->get($this->forum_komentar_reply_table);
		$reply_komentar = new myObject();
		if($hasil->num_rows() > 0){
			$reply_komentar->status = true;
			$reply_komentar->data = $hasil->result();
		}else{
			$reply_komentar->status = false;
		}
		$reply_komentar->total_komentar = $hasil->num_rows();
		return $reply_komentar;
	}

	public function post_forum($data)
	{
		$this->db->insert($this->forum_table,$data);
		return $this->db->affected_rows();
	}

	public function update_forum($data,$where)
	{
		$this->db->where($where);
		$this->db->update($this->forum_table,$data);
		return $this->db->affected_rows();
	}

	public function hapus_forum($where)
	{
		$this->db->where($where);
		$this->db->delete($this->forum_table);
		return $this->db->affected_rows();
	}
	/*END SECTION FORUM*/


	/*SECTION POLLING*/
	public function get_was_polling()
	{
		$ip = $this->input->ip_address();
		$this->db->select("ifnull(count(*),0) as waspoll, kepuasan");
		$hasil = $this->db->get_where("__polling",array("ip_address"=>$ip));
		return $hasil->row();
	}
	public function save_polling($data)
	{
		$this->db->replace("__polling",$data);
		return $this->db->affected_rows();
	}
	/*END SECTION POLLING*/

	/*SECTION REFERENSI PROVINSI KABUPATEN KECAMATAN*/
	/*public  function get_provinsi(){
        $sql = 'select * from ref_provinsi order by name asc';
        $query = $this->database->query($sql);
        if($query->num_rows()>0){
            return $query->result();
        }
    }*/

    public  function get_kabupaten($kode_prov){
        $sql = 'select * from ref_kabupaten_kota where kode_prov = ? order by nama asc';
        $query = $this->db->query($sql,array($kode_prov));
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public  function get_kecamatan($kode_kab){
        $sql = 'select * from ref_kecamatan where kode_kab = ? order by nama asc';
        $query = $this->db->query($sql,array($kode_kab));
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public  function get_kelurahan($kode_kec){
        $sql = 'select * from ref_kelurahan_desa where kode_kec = ? order by nama asc';
        $query = $this->db->query($sql,array($kode_kec));
        if($query->num_rows()>0){
            return $query->result();
        }
    }
	/*END SECTION REFERENSI PROVINSI KABUPATEN KECAMATAN*/
}