<?php
class Dashboard extends CI_Controller { //mengextends CI_Controller 
    public function __construct(){
        parent::__construct();
    }
    public function index () {
        $data['title'] = "Dashboard";
        $data['content'] = "dashboard/index";
		$this->load->view('backend/index',$data);

    }
}
?>