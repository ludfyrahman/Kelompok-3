<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pemesanan extends CI_Controller {
	function __construct()
  	{
		parent::__construct();
		$this->low = "pemesanan";
		$this->cap = "Pemesanan";
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('mpemesanan');
		if($this->uri->segment(3) == "add" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->store($this->uri->segment(4));
		}else if($this->uri->segment(3) == "edit" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->update($this->uri->segment(4), $this->uri->segment(5));
		}
    }
    public function index() {
        $start_date = Input::getOr('start_date');
        if ($start_date != "") {
            $start_date = date("Y-m-d", strtotime(Input::getOr('start_date')));
            $end_date = date("Y-m-d", strtotime(Input::getOr('end_date')));
            $st = Input::getOr('status');
            $send = [
                $start_date, $end_date, $st
            ];
            $lists = $this->pemesanan->dataPemesanan($send)[1];
        }else{
            $lists = $this->pemesanan->dataPemesanan()[1];
        }
        // echo "<pre>";
        // print_r($lists);
        Response::render ('back/index', ['title' => 'Daftar pemesanan', 'content' => 'pemesanan/index', 'list' => $lists]);

    }
    public function pdf(){
        // Response::render('partials/pdfPemesanan');
        $dompdf = new Dompdf();
        $html   = Response::render('partials/pdfPemesanan');
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream('laporan_'.$nama.'.pdf');
    }
    public function excel(){
        
    }
    public function aksi($status, $id){
        $d = $_POST;

        try {
            $arr = [
                'status' => $status, 
            ];

            $this->pembayaran->update($arr, "WHERE id=$id");
            // echo "berhasil";
            Response::redirectWithAlert('admin/pembayaran/', ['info', 'Status Pembayaran dengan kode '.invoice_code."".$id]);
        }
        catch(Exception $e) {
            print_r($e->errorInfo[2]);
        }
    }
    public function doOrder($id, $id_detail = null){
        $arr = [
            'id_kos' => $id_detail,
            'id_pengguna' => Account_Helper::Get("id"),
        ];
        $this->pemesanan->insert($arr);
        $id = $this->pemesanan->lastInsertId();
        Response::redirectWithAlert('akun/pemesanan/detail/'.$id, ['info', 'pemesanan berhasil diedit']);
    }
    public function detailPemesananUser($id){
        $data = $this->mpemesanan->detailPemesanan($id)->row_array();
        // print_r($data);
        $media = $this->db->query("SELECT * from media WHERE id_kos='$data[id_detail]' LIMIT 1")->row_array();;
        // echo "<pre>";
        // print_r($data);
        $data = ['title' => 'Detail pemesanan', 'content' => 'pemesanan/detail', 'data' => $data, 'media' => $media];
        $this->load->view('frontend/index',$data);
    }
    public function invoice($id){
        $data = $this->pemesanan->detailPemesanan($id)[1][0];
        Response::render('partials/invoice', ['title' => "invoice", 'data' => $data]);
    }
    public function transaction(){
        $id = Account_Helper::Get('id');
        $dp = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* FROM $this->low p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id WHERE id_pengguna='$id' and status='1' GROUP BY dk.id_kos")->result_array();
        $dibatalkan =$this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* FROM $this->low p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id WHERE id_pengguna='$id' and status='0' GROUP BY dk.id_kos")->result_array();
        $lunas = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* FROM $this->low p JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id WHERE id_pengguna='$id' and status='2' GROUP BY dk.id_kos")->result_array();
        $selesai = $this->db->query("SELECT p.id as id_pemesanan, p.*, k.*, dk.* FROM $this->low p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id WHERE id_pengguna='$id' and status='3' GROUP BY dk.id_kos")->result_array();
        // echo "<pre>";
        $now = date('Y-m-d');
        foreach ($dp as $d) {
            if (strtotime($now) > strtotime($d['tanggal_pemesanan']. ' +1 day')) {
                // $this->pemesanan->update(['status' => 0], "WHERE id='$d[id_pemesanan]'");
                $this->db->update($this->low, ['status' => 0], ['id' => $d['id_pemesanan']]);
            }
        }
        foreach ($lunas as $l) {
            // print_r($l);
            if (strtotime($now) > strtotime($l['tanggal_pemesanan']. ' +4 day')) {
                // $this->pemesanan->update(['status' => 0], "WHERE id='$l[id_pemesanan]'");
                $this->db->update($this->low, ['status' => 0], ['id' => $l['id_pemesanan']]);
            }
        }
        $data = ['title' => 'Daftar Transaksi', 'content' => 'pemesanan/index', 'dp' => $dp, 'lunas' => $lunas, 'dibatalkan' => $dibatalkan, 'selesai' => $selesai];
        $this->load->view('frontend/index',$data);
    }
    public function detail($id){
        $data = $this->pemesanan->detailPemesanan($id);
        // echo "<pre>";
        // print_r($data);
        $pembayaran = $this->db->get_where("pembayaran", ['id_pemesanan' => $data['id']])->result_array();
        // print_r($pembayaran); 
        $data = ['title' => 'Detail pemesanan', 'content' => 'pemesanan/detail', 'data' => $data, 'pembayaran' => $pembayaran];
        $this->load->view('frontend/index',$data);
        // Response::render ('back/index', ['title' => 'Detail pemesanan', 'content' => 'pemesanan/detail', 'data' => $data, 'pembayaran' => $pembayaran]);
    }
}
?>