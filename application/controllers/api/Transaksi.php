<?php 
class Transaksi extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "kos";
    }
    public function index(){
        $id = Account_Helper::Get('id');
        $response['dp'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id  WHERE id_pengguna='$id' and status='1' GROUP BY dk.id_kos")->result_array();
        $response['dibatalkan'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id", " WHERE id_pengguna='$id' and status='0' GROUP BY dk.id_kos")->result_array();
        $response['lunas'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id", " WHERE id_pengguna='$id' and status='2' GROUP BY dk.id_kos")->result_array();
        $response['selesai'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id", " WHERE id_pengguna='$id' and status='3' GROUP BY dk.id_kos")->result_array();
        // echo "<pre>";
        $now = date('Y-m-d');
        foreach ($response['dp'] as $d) {
            if (strtotime($now) > strtotime($d['tanggal_pemesanan']. ' +1 day')) {
                // $this->pemesanan->update(['status' => 0], "WHERE id='$d[id_pemesanan]'");
            }
        }
        foreach ($response['lunas'] as $l) {
            // print_r($l);
            if (strtotime($now) > strtotime($l['tanggal_pemesanan']. ' +4 day')) {
                // $this->pemesanan->update(['status' => 0], "WHERE id='$l[id_pemesanan]'");
            }
        }
        echo json_encode($response);
    }
    public function all(){
        $q = $this->db->get($this->low)->result_array();
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