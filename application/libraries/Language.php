<?php
class Language {
    protected $_ci;
    function __construct()
    {
        $this->_ci =&get_instance();
        $lang = $this->_ci->session->userdata('language');
        $this->_ci->config->set_item('language', $lang==null?"indonesia":$lang);
        $this->_ci->lang->load("menu");
        $this->_ci->lang->load("berita");
    }
}