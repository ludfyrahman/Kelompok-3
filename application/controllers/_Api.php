<?php 
class Api extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function retensi($id){
        if($id != null){
            $q = $this->db->query("SELECT r.* FROM klasifikasi k JOIN retensi r ON k.id_retensi=r.id WHERE k.id='$id'")->row_array();
            echo json_encode($q);
        }
    }
}

?>