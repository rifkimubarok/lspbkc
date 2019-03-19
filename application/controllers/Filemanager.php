<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filemanager extends CI_Controller {
    private $user;
    function __construct(){
        parent::__construct();
        $this->load->library("Template");
        $this->user = get_session("user");
        if(!isset($this->user->islogin) && !$this->user->islogin){
            redirect("logout");
        }
    }

	public function upload($content)
    {  
            $config['upload_path']          = './assets/images/'.$content.'/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['file_name'] = $this->user->id.'_'.sha1(date("dMY H:i"));
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
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = 350;
                $this->load->library('image_lib', $config);
                if($this->image_lib->resize())echo json_encode(array("content"=>BASEURL."api/pictures/show_picture/".$content."/".$image_data['raw_name']));

            }
    }

    public function file_manager($content=null)
    {
    	$output['content_image'] = $content;
    	$output['images'] = glob('./assets/images/'.$content.'/'.$this->user->id.'_*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    	$output['site_url'] = BASEURL."api/pictures/show_picture/".$content."/";
    	$this->load->view("filemanager",$output);
    }

    public function delete_image($content)
    {
    	$img = get_post_text("image");
    	$image = glob('./assets/images/'.$content.'/'.$img.'.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    	$image_path = '';
    	foreach ($image as $imag) {
    		$image_path = $imag;
    		break;
    	}
    	if (file_exists($image_path)) 
		unlink($image_path);
		else echo $image_path;
    }

}