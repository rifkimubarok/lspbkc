<?php
class Statistik {
    protected $_ci;
    function __construct()
    {
        $this->_ci =&get_instance();
    }

    public function count()
    {
    	$ip = $this->_ci->input->ip_address();
    	$date = date("Y-m-d");
    	$sql = "CALL add_statistik(?,?)";
    	$this->_ci->db->query($sql,array($ip,$date));
    }

    public function get_count()
    {
        $sql = "call get_statistik";
        return $this->_ci->db->query($sql)->row();
    }
}