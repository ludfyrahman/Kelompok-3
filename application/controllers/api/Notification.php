<?php 

class Notification extends CI_Controller
{
    public function __construct(){
      parent::__construct();
      $this->load->model("mPengguna", "pengguna");
    }
    public function sendnotif($kunci = "",$body, $title, $key, $pk){
      Auth_Helper::sendnotif($kunci,$body, $title, $key, $pk);
    }
}


?>

