<?php
class Template {
    protected $_ci;
    function __construct()
    {
        $this->_ci =&get_instance();
    }

    function display($template,$data=null)
    {
        $this->_ci->load->model("model_data");
        $user = get_session("user");
        $topnews['user'] = $user;
        $menu['user'] = $user;
        //$datamenu['menu'] = $this->_ci->model_data->menu();
        //$topnews['slider'] = $this->_ci->model_data->get_slider(5,1);
        $data['_content']=$this->_ci->load->view($template,$data, true);
        $data['_topnews']=$this->_ci->load->view('template/topnews',$topnews,true);
        $data['_menu']=$this->_ci->load->view('template/menu',$menu,true);
        $data['_segment']=$this->_ci->uri->segment(1);
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
            'font_path' => './assets/captcha/fonts/test.otf',
            'font_size' => '25',
            'img_width' => $this->_ci->config->item('captcha_width'),
            'img_height' => $this->_ci->config->item('captcha_height'),
            'expiration'    => 300,
            'word_length'   => 4,
            'font_size'     => 24,
            'ip_address' => $this->_ci->input->ip_address(),
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
        set_flash('captcha',$data);
        return $data;
    }
}
?>