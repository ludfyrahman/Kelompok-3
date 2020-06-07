<?php 
class Transaksi extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "kos";
        $this->load->model('mpemesanan', 'pemesanan');
        $this->load->model('mpembayaran', 'pembayaran');
    }
    public function data($id){
        // $id = Account_Helper::Get('id');
        $response['dibatalkan'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id WHERE p.id_pengguna='$id' and status='0' GROUP BY dk.id_kos")->result_array();
        $response['dp'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id  WHERE id_pengguna='$id' and status='1' GROUP BY dk.id_kos")->result_array();
        $response['lunas'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id  WHERE id_pengguna='$id' and status='2' GROUP BY dk.id_kos")->result_array();
        $response['selesai'] = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id  WHERE id_pengguna='$id' and status='3' GROUP BY dk.id_kos")->result_array();
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
    public function detail($id){
        $response['data'] = $this->pemesanan->detailPemesanan($id)->row_array();
        // echo "<pre>";
        // print_r($data);
        $response['pembayaran'] = $this->db->get_where("pembayaran", ['id_pemesanan' => $response['data']['id']])->result_array();
        // print_r($pembayaran); 
        echo json_encode($response);
    }
    public function pesan($id, $id_detail = null){
        // $data = $this->kos->Select("k.id, k.nama as nama_kos,k.tanggal_diubah, k.latitude, k.longitude, k.deskripsi, dk.jumlah_kamar, dk.harga, k.tanggal_ditambahkan, p.nama", " k JOIN pengguna p ON k.ditambahkan_oleh=p.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos", "WHERE k.id='$id' and dk.id=$id_detail ")[1][0];
        $data = $this->db->query("SELECT k.id, k.nama as nama_kos,k.tanggal_diubah, k.latitude, k.longitude, k.deskripsi, dk.jumlah_kamar, dk.harga, k.tanggal_ditambahkan, p.nama from $this->low k JOIN pengguna p ON k.ditambahkan_oleh=p.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos WHERE k.id='$id' and dk.id=$id_detail ")->row_array();
        $media = $this->db->query("SELECT * from media WHERE id_kos='$data[id]' LIMIT 1")->row_array();
        // $data = ['title' => 'Login Papikos', 'content' => 'user/login'];
        if(!isset($_SESSION['userid'])){
            $this->load->view('frontend/index',$data);
        }else{
            $data = ['title' => "Pesan ".$data['nama_kos'], 'content' => 'kos/pesan', 'type' => 'Tambah', 'data' => $data, 'media' => $media];
            $this->load->view('frontend/index',$data);
        }
    }
    
}

?>