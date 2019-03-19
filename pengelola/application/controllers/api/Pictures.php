<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pictures extends CI_Controller {

	function __construct(){
        parent::__construct();
    }

    public function show_picture()
    {
        $type = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $file_path = './assets/images/'.$type.'/' . $id . '.jpg';
        $nopics = './assets/images/noimages.jpg';
        if(file_exists($file_path)){
            $contents = file_get_contents($file_path);
        }else{
            $contents = file_get_contents($nopics);
        }
        $this->output
            ->set_status_header(200)
            ->set_content_type('image/jpeg')
            ->set_output($contents)
            ->_display();
        exit;
    }

    public function show_picture_thumb()
    {
    	$type = $this->uri->segment(4);
    	$id = $this->uri->segment(5);
        $file_path = './assets/images/'.$type.'/' . $id . '_thumb.jpg';
        $nopics = './assets/images/noimages.jpg';
        if(file_exists($file_path)){
            $contents = file_get_contents($file_path);
        }else{
            $contents = file_get_contents($nopics);
        }
        $this->output
            ->set_status_header(200)
            ->set_content_type('image/jpeg')
            ->set_output($contents)
            ->_display();
        exit;
    }

}