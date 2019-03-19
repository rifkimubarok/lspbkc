<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library("Template");
    }

	public function index()
	{
		$this->load->model("model_data","data");
		$this->template->display("homepage/index");	
	}

	public function test()
	{
		$this->lang->load("rest_controller");
		$oops = $this->lang->line('text_rest_invalid_api_key');
		echo $oops==null ? "Beranda":$oops;
	}
	
	public function kategori(){
		$kategori = $this->uri->segment("2");
		$this->load->model("Model_kategori","kategori");
		$data['pos'] = $this->kategori->get_data($kategori);
		$this->template->display("homepage/kategori");
	}
	
	function show(){
		$seo_title = $this->uri->segment("2");
		$this->load->model("Model_kategori","kategori");
		$data['pos'] = $this->kategori->get_data($seo_title);
		$this->template->display("homepage/pos");
	}

	public function get_slider()
	{
		$this->load->model("model_data","data");
		$output['slider'] = $this->data->get_slider(5,1);
		$this->load->view('homepage/slider',$output);
	}

	public function not_found()
	{
		$data['title'] = "404 Not Found";
		$this->template->display("not_found",$data);
	}

	public function save_polling()
	{
		$kepuasan = get_post("kepuasan");
		$this->load->model("model_data","data");
		$data = array("ip_address"=>$this->input->ip_address(),"kepuasan"=>$kepuasan);
		$hasil = $this->data->save_polling($data);
		if($hasil){
			echo json_encode(array("status"=>true));
		}
	}

	public function get_modul()
	{
		$section = get_post("name");
		$this->load->model("model_data","data");
		switch ($section) {
			case '_topnews':
				$hasil['slider'] = $this->data->get_slider(null,1);
				$output = $this->load->view('template/topnews',$hasil,true);
				break;
			case '_sidebar':
				$user = get_session("user");
				if(!isset($user->islogin)){
					$sidebar['captcha'] = $this->create_captcha();
				}
		        $sidebar['agenda'] = $this->data->get_agenda(0,5);
		        $sidebar['statistik'] = $this->statistik->get_count();
		        $sidebar['_segment'] = $this->uri->segment(1);
		        //$sidebar['status_poll'] = $this->data->get_was_polling();
		        $output = $this->load->view('template/sidebar',$sidebar,true);
				break;
			case '_berita':
				$berita['berita'] = $this->data->get_berita(0,8,null,null,1);
				$output = $this->load->view("content/berita.php",$berita,true);
				break;
			case '_forum':
				$forum['forum'] = $this->data->get_forum(0,8,null,null,1);
				$output = $this->load->view("forum/index",$forum,true);
				break;
		}
		echo $output;
	}

	public function get_status_poll()
	{
		$this->load->model("model_data","data");
		$output = $this->data->get_was_polling();
		echo json_encode($output);
	}

	function create_captcha()
    {
        $this->load->helper('captcha');
        $cap_config = array(
            'img_path' => './' . $this->config->item('captcha_path'),
            'img_url' => base() . $this->config->item('captcha_path'),
            'font_path' => './assets/captcha/fonts/tes.otf',
            'font_size' => '18',
            'img_width' => $this->config->item('captcha_width'),
            'img_height' => 50,
            'expiration'    => 3000,
            'word_length'   => 4,
            'font_size'     => 24,
            'ip_address'    => $this->input->ip_address(),
            'img_id'        => 'captcha_image',
            'pool'          => '0123456789',
            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(79, 135, 36)
            )
        );
        $cap = create_captcha($cap_config);
        // Save captcha params in session
        $data = new myObject();
        $data->word = $cap['word'];
        $data->image = $cap['image'];
        set_session('captcha_login',$data);
        return $data;
    }

    public function check_chaptca()
    {
    	$data = get_session('captcha_login');
    	echo json_encode($data);
    }

    function sendmail(){
$this->load->library('email');
      $this->email->initialize(array(
  'protocol' => 'smtp',
  'smtp_host' => 'ssl://smtp.googlemail.com',
  'smtp_user' => '177006078@student.unsil.ac.id',
  'smtp_pass' => 'bojong11',
  'smtp_port' => 465,
  'crlf' => "\r\n",
  'newline' => "\r\n"
));

$this->email->from('tefa@webapps.my.id', 'Tefa SMKN 1 CIAMIS');
$this->email->to('rifkimubarok1410@gmail.com');
$this->email->cc('another@another-example.com');
$this->email->bcc('kiki.tasik@gmail.com');
$this->email->subject('Email Test');
$this->email->message('Testing the email class.');
$this->email->send();

echo $this->email->print_debugger();
    }
}
