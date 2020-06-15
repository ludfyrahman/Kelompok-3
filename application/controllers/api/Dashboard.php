<?php 
class Dashboard extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "pengguna";
        $this->load->model("mKos", "kos");
    }
    public function index(){
        echo "index";
    }
    public function data(){
        $data['rekomended'] = $this->kos->data("LIMIT 3")->result();
        $data['terbaru'] = $this->kos->data("ORDER BY k.id desc LIMIT 3")->result();
        echo json_encode($data);
    }
}