<?php 
class Kos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "kos";
    }
    public function index(){
        
    }
    public function all(){
        $q = $this->db->get($this->low)->result_array();
        echo json_encode(['data' => $q]);
    }
    public function edit($id){
        $q = $this->db->get_where($this->low, ['id' => $id])->row_array();
        echo json_encode(['data' => $q]);
    }
    public function update($id){
        $q = $this->db->get_where($this->low, ['id' => $id])->row_array();
        echo json_encode(['data' => $q]);
    }
    
    public function detail($id){
        $q = $this->db->get_where($this->low, ['id' => $id])->row_array();
        echo json_encode(['data' => $q]);
    }
    public function favorit(){
        $q = $this->db->query("SELECT * FROM kos k JOIN favorit w ON k.id=w.id_kos GROUP BY w.id_kos")->result_array();
        echo json_encode(['data' => $q]);
    }
}

?>