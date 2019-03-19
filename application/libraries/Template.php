<?php
class Template {
    protected $_ci;
    function __construct()
    {
        $this->_ci =&get_instance();

    }

    function display($template,$data=null)
    {
        /*$this->_ci->statistik->count();*/
        $this->_ci->load->model("model_data");
        $title = isset($data['title']) ? $data['title'] : '';
        $datamenu['menu'] = $this->_ci->model_data->menu();
        //$topnews['slider'] = $this->_ci->model_data->get_slider(null,1);
        /*$sidebar['captcha'] = $this->create_captcha();
        $sidebar['agenda'] = $this->_ci->model_data->get_agenda(0,5);
        $sidebar['statistik'] = $this->_ci->statistik->get_count();
        $sidebar['_segment'] = $this->_ci->uri->segment(1);*/
        $data['_title'] = $title;
        $data['_content']=$this->_ci->load->view($template,$data, true);
        //$data['_sidebar']=$this->_ci->load->view('template/sidebar',$sidebar,true);
        //$data['_topnews']=$this->_ci->load->view('template/topnews',$topnews,true);
        $data['_menu']=$this->_ci->load->view('template/menu',$datamenu,true);
        $data['_segment']=$this->_ci->uri->segment(1);
        $data['_statistik'] = $this->_ci->statistik;
        $this->_ci->load->view('template/frontend',$data);
    }

    function show($template,$data=null)
    {
        $data['content']=$this->_ci->load->view($template,$data, true);
        $this->_ci->load->view('template/landing',$data);
    }

    function create_captcha()
    {
        $this->_ci->load->helper('captcha');
        $cap_config = array(
            'img_path' => './' . $this->_ci->config->item('captcha_path'),
            'img_url' => base() . $this->_ci->config->item('captcha_path'),
            'font_path' => './assets/captcha/fonts/tes.otf',
            'font_size' => '18',
            'img_width' => $this->_ci->config->item('captcha_width'),
            'img_height' => 50,
            'expiration'    => 300,
            'word_length'   => 4,
            'font_size'     => 24,
            'ip_address'    => $this->_ci->input->ip_address(),
            'img_id'        => 'captcha_image',
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
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
        $this->_ci->session->set_tempdata('captcha',$data,300);
        return $data;
    }
}
?>