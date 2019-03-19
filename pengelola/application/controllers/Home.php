<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    private $user;
	function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        $this->auth_user->check();
    }

	public function index()
	{
		$this->load->model("model_data","data");
        //$output['statistik'] = $this->data->get_statistik();
        $output['statistik1'] = $this->data->get_jml_pengunjung();
		$this->template->display("homepage/index",$output);	
	}

    public function get_notification()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->get_notification();
        echo json_encode($hasil);
    }

	public function test()
	{
		$this->load->helper("share");
		$facebook = share_url("facebook",array("url"=>"https://dev.mysql.com/doc/refman/8.0/en/commands-out-of-sync.html","text"=>"Berita"));
		$data = "MyWindow=window.open('".$facebook."',
            'MyWindow','width=600,height=300'); return false;"; 
        echo $data;
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

	public function check_element()
	{
		echo json_encode(get_session("user"));
	}

	public function testsummer()
	{
		$this->template->display("testsummer");
	}

	public function upload($content)
    {  
            $config['upload_path']          = './../assets/images/'.$content.'/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['encrypt_name'] = true;
            $image_data = array();
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file'))
            {
                    $error = array('error' => $this->upload->display_errors());

                    echo json_encode($error);
            }
            else
            {
                $image_data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image_data['full_path'];
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = 350;
                $this->load->library('image_lib', $config);
                if($this->image_lib->resize())echo json_encode(array("content"=>BASE."api/pictures/show_picture/".$content."/".$image_data['raw_name']));

            }
    }

    public function file_manager($content=null)
    {
    	$output['content_image'] = $content;
    	$output['images'] = glob('./../assets/images/'.$content.'/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    	$output['site_url'] = BASE."api/pictures/show_picture/".$content."/";
    	$this->load->view("filemanager",$output);
    }

    public function delete_image($content)
    {
    	$img = get_post_text("image");
    	$image = glob('./../assets/images/'.$content.'/'.$img.'.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    	$image_path = '';
    	foreach ($image as $imag) {
    		$image_path = $imag;
    		break;
    	}
    	if (file_exists($image_path)) 
		unlink($image_path);
		else echo $image_path;
    }

    public function explor()
    {
    	$data = glob('./../assets/images/berita/0ade7c2cf97f75d009975f4d720d1fa6c19f4897.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    	foreach ($data as $item) {
    		echo $item;

    	}
    }

    public function get_json_total_pengunjung()
    {
        $this->load->model("model_data","data");
        $hasil = $this->data->get_json_total_pengunjung();
        echo json_encode($hasil);
    }
}
