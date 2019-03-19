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
        if(count(explode(".",$id)) > 1){
            $file_path = './assets/images/'.$type.'/' . $id ;
            $file_path_png = './assets/images/'.$type.'/' . $id ;
        }else{
            $file_path = './assets/images/'.$type.'/' . $id . '.jpg';
            $file_path_png = './assets/images/'.$type.'/' . $id . '.png';
        }
        $nopics = './assets/images/noimages.jpg';
        if(file_exists($file_path)){
            $contents = file_get_contents($file_path);
            $this->output
            ->set_status_header(200)
            ->set_content_type('image/jpeg')
            ->set_output($contents)
            ->_display();
        }else if(file_exists($file_path_png)){
            $mime = mime_content_type($file_path_png); //<-- detect file type
          header('Content-Length: '.filesize($file_path_png)); //<-- sends filesize header
          header("Content-Type: $mime"); //<-- send mime-type header
          header('Content-Disposition: inline; filename="'.$file_path_png.'";'); //<-- sends filename header
          readfile($file_path_png); //<--reads and outputs the file onto the output buffer
          die(); //<--cleanup
        }else{
            $contents = file_get_contents($nopics);
            $this->output
            ->set_status_header(200)
            ->set_content_type('image/jpeg')
            ->set_output($contents)
            ->_display();
        }
        exit;
    }

    public function show_picture_thumb()
    {
    	$type = $this->uri->segment(4);
    	$id = $this->uri->segment(5);
        $file_path = './assets/images/'.$type.'/' . $id . '_thumb.jpg';
        $file_path_png = './assets/images/'.$type.'/' . $id . '_thumb.png';
        $nopics = './assets/images/noimages.jpg';
        if(file_exists($file_path)){
            $contents = file_get_contents($file_path);
            $this->output
            ->set_status_header(200)
            ->set_content_type('image/jpeg')
            ->set_output($contents)
            ->_display();
        }else if(file_exists($file_path_png)){
            $mime = mime_content_type($file_path_png); //<-- detect file type
          header('Content-Length: '.filesize($file_path_png)); //<-- sends filesize header
          header("Content-Type: $mime"); //<-- send mime-type header
          header('Content-Disposition: inline; filename="'.$file_path_png.'";'); //<-- sends filename header
          readfile($file_path_png); //<--reads and outputs the file onto the output buffer
          die(); //<--cleanup
        }else{
            $contents = file_get_contents($nopics);
            $this->output
            ->set_status_header(200)
            ->set_content_type('image/jpeg')
            ->set_output($contents)
            ->_display();
        }
        exit;
    }

}