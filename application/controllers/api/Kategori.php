<?php 

class Kategori extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "kategori";
        
    }
    public function data(){
        $response['data'] = $this->db->get("kategori")->result_array();
        echo json_encode($response);
    }
}