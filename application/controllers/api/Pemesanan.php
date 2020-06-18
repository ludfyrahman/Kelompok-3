<?php 
class Pemesanan extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model("mPemesanan", "pemesanan");
    }
    public function tagihan($id){
        $response['data'] = $this->pemesanan->detailPemesanan($id)->row_array();
        // echo "<pre>";
        // print_r($data);
        $id_detail = $response['data']['id_detail'];
        $response['media'] = $this->db->query("SELECT * from media WHERE id_kos='$id_detail' LIMIT 1")->row_array();;
        // Response::render('front/index', ['title' => "Pembayaran", 'data' => $data, 'content' => 'pembayaran/bayar', 'media' => $media]);
        echo json_encode($response);
    }
}


?>