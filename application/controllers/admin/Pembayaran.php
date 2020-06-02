<?php
// include "SettingController.php";
defined('BASEPATH') OR exit('No direct script access allowed');
class Pembayaran extends CI_Controller {

    function __construct()
  	{
		parent::__construct();
		$this->low = "pembayaran";
		$this->cap = "Pembayaran";
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('mpembayaran', 'pembayaran');
		if($this->uri->segment(3) == "add" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->store($this->uri->segment(4));
		}else if($this->uri->segment(3) == "edit" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->update($this->uri->segment(4), $this->uri->segment(5));
		}
    }
    public function index() {
        $start_date = Input_Helper::postOrOr('start_date');
        if ($start_date != "") {
            $start_date = date("Y-m-d", strtotime(Input_Helper::postOrOr('start_date')));
            $end_date = date("Y-m-d", strtotime(Input_Helper::postOrOr('end_date')));
            $st = Input_Helper::postOrOr('tipe');
            $send = [
                $start_date, $end_date, $st
            ];
            // print_r($send);
            // echo $this->pembayaran->datapembayaran($send);
            $lists = $this->pembayaran->datapembayaran($send)->result_array();
        }else{
            $lists = $this->pembayaran->datapembayaran()->result_array();
        }
        $data['title'] = "Daftar $this->cap";
		$data['content'] = "$this->low/index";
        $data['list'] = $lists;
        $this->load->view('backend/index',$data);

    }

    public function update($id) {
        $d = $_POST;

        try {
            $arr = [
                'nama' => $d['nama'], 
            ];


            $this->db->update($this->low, $arr, ['id' => $id]);
            $this->session->set_flashdata("alert", ['success', 'Pembayaran dengan kode '.invoice_code."".$id." berhasil diedit", ' Berhasil']);
			redirect(base_url("admin/pembayaran"));
        }
        catch(Exception $e) {

            $this->edit($id);
        }
    }
    public function doPay($id){
        $d = $_POST;
        $f = $_FILES;
        try {
            $status = 1;
            if ($d['status'] == 1) {
                $status = 2;
            }else if($d['status'] == 2){
                $status = 3;
            }
            Response_Helper::UploadImage($f['file'], 'bukti');
            $q = $this->pembayaran->Insert(['id_pemesanan' => $id,  'tipe' => $d['status'], 'jumlah' => $d['bayar'], 'bukti_bayar' => $f['file']['name']]);
            $this->pemesanan->update(['status' => $status], "WHERE id=$id");
            if(!$q){
                echo json_encode(['status' => true]);
            }else{
                echo json_encode(['status' => false]);
            }
        }
        catch(Exception $e) {

            echo $e->getMessage();
        }
    }
    public function aksi($type, $id){
        $d = $_POST;
        try {
            if ($type == 2) {
                $r = $this->pembayaran->select("*", "p JOIN pemesanan pm ON p.id_pemesanan=pm.id JOIN kos k ON pm.id_kos=k.id WHERE p.id='$id'")->row_array();
                $this->db->update('kos', ['jumlah_kamar' => $r['jumlah_kamar'] - 1], ['id' => $id]);
            }
            $arr = [
                'status' => 1, 
            ];
            $this->db->update($this->low, $arr, ['id' => $id]);
            $this->session->set_flashdata("alert", ['success', 'Pembayaran dengan kode '.invoice_code."".$id." berhasil di Update", ' Berhasil']);
			redirect(base_url("admin/pembayaran"));
        }
        catch(Exception $e) {
            print_r($e->errorInfo[2]);
        }
    }
    public function bayar($id){
        $data = $this->pemesanan->detailPemesanan($id)->row_array();
        // echo "<pre>";
        // print_r($data);
        $media = $this->db->query("SELECT * FROM media WHERE id_kos='$data[id_kos]' LIMIT 1")->row_array();
        $data['title'] = "$this->cap";
		$data['content'] = "$this->low/bayar";
        $data['data'] = $data;
        $data['media'] = $media;
        $this->load->view('backend/index',$data);
    }
    public function notifikasi(){
        $now = date('Y-m-d');
        $d = $this->db->query("SELECT p.id, id_kos, stnotif, id_pengguna, tanggal_pemesanan,p. status, (CASE WHEN p.status = 1 then DATE(tanggal_pemesanan) when p.status = 2 then DATE(tanggal_pemesanan)  when p.status = 3 then DATE(tanggal_pemesanan) end ) as tanggal_tempo, pg.email FROM pemesanan p JOIN pengguna pg ON p.id_pengguna=pg.id ORDER BY tanggal_pemesanan asc")->result_array();
        echo "<pre>";
        // print_r($d);
        foreach ($d as $key ) {
            if($key['status'] != 0){
                $notif = date('Y-m-d', strtotime($key['tanggal_tempo']. "-1 day"));
                if($now == $notif){
                    if($key['stnotif'] == 0){
                        // echo "tanggal tempo ".$key['tanggal_tempo']." tanggal notifikasi nya ".$notif."<br>";
                        $this->setting->notifikasi_pembayaran("papikos@gmail.com", $key['email'], $key['id']);
                    }
                }
            }
        }
    }

}