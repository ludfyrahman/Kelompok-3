<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kos extends CI_Controller {
	function __construct()
  	{
		parent::__construct();
		$this->low = "kos";
		$this->cap = "Kos";
		date_default_timezone_set('Asia/Jakarta');
		// if(!isset($_SESSION['kode_user'])){
		// 	redirect(base_url());
        // }
        $this->load->model("mkos");
		if($this->uri->segment(3) == "add" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->store($this->uri->segment(4));
		}else if($this->uri->segment(3) == "edit" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->update($this->uri->segment(4), $this->uri->segment(5));
		}
    }
    
    public function detail($id, $id_detail = null){ 
        $detail_kos = $this->db->get_where("detail_kos",  ['id_kos' => $id])->result_array();
        $id_detail_kos= ($id_detail == null ? $detail_kos[0]['id'] : $id_detail);
        $data = $this->db->query("SELECT k.id, k.nama as nama_kos, k.dilihat,k.jenis, k.tanggal_diubah, k.latitude, k.longitude, k.deskripsi, dk.jumlah_kamar, dk.harga, k.tanggal_ditambahkan, p.nama from $this->low k JOIN pengguna p ON k.ditambahkan_oleh=p.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos WHERE k.id='$id' and dk.id=$id_detail_kos GROUP BY k.id")->row_array();
        $media = $this->db->query("SELECT m.*, dk.id as id_detail_kos from  media m JOIN detail_kos dk ON m.id_kos=dk.id JOIN kos k ON k.id=dk.id_kos WHERE k.id='$data[id]'")->result_array();
        $ulasan = $this->db->query("SELECT u.*, p.nama from ulasan u JOIN pengguna p on u.id_pengguna=p.id WHERE id_kos=$id ")->result_array();   
        $this->db->query("UPDATE kos set dilihat = dilihat + 1 WHERE id='$id'");
        $fasilitas = $this->db->query(" SELECT f.id, f.nama from  fasilitas_kos fk JOIN sub_fasilitas sf ON fk.id_fasilitas=sf.id JOIN fasilitas f ON sf.id_fasilitas=f.id WHERE fk.id_kos='$id_detail_kos' GROUP by f.id")->result_array();
        $index = 0;
        $rate = $this->db->get_where("ulasan", ['id_kos' => $id])->result_array();
        $max = 0;
        foreach ($rate as $key) {
            $max+=$key['rating'];
        }
        $rate = $max / (count($rate) == 0 ? 1 : count($rate));
        $subfas = array();
        
        foreach($fasilitas as $f){
            $subfas[$index] = $f;
            $sub_fasilitas = $this->db->query("SELECT * FROM sub_fasilitas sb JOIN fasilitas_kos fk ON sb.id=fk.id_fasilitas WHERE sb.id_fasilitas='$f[id]' and fk.id_kos='$id_detail_kos'")->result_array();
            // print_r($sub_fasilitas);
            $in = 0;
            foreach($sub_fasilitas as $sub){
                // print_r($sub);
                $subfas[$index]['sub'][$in] = $sub;
                $in++;
            }
            // print_r($sub_fasilitas);
            
            $index++;
        }
        // echo "</pre>";
        // print_r($data);
        $data['title'] =$data['nama_kos'];
		$data['content'] = "$this->low/detail";
		$data['type'] = 'Ubah';
        $data['data'] = $data;	
        $data['subfas'] = $subfas;
        $data['rate'] = $rate;
        $data['media'] = $media;
        $data['subfas'] = $subfas;
        $data['ulasan'] = $ulasan;
        $data['dk'] = $detail_kos;
		$this->load->view('frontend/index',$data);
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
    public function semua(){
        $d = $_POST;
        $pencarian = " ";
        $lat = (isset($_COOKIE['lat']) ? $_COOKIE['lat'] :0 );
        $long = (isset($_COOKIE['long']) ? $_COOKIE['long'] : 0);
        $urut = "";
        if (isset($d['jarak'])) {
            if($d['jarak'] != ''){
                $urut = " HAVING distance < $d[jarak] order by distance asc";    
            }
        }
        
        $pencarian = $urut;
        if(isset($d['search'])){
            $pencarian = "Where ";
            $cari = "";
            if(isset($d['cari']) != ""){
                $cari = (isset($d['cari']) ? " k.nama like  '%".$d['cari']."%'" : '');
            }
            $kategori = "";
            if(isset($d['kategori'])){
                if($d['kategori'] != ""){
                    $kategori = (isset($d['kategori']) ? " and k.id_kategori ='".$d['kategori']."'" : '');
                }
            }
            $tipe = "";
            if(isset($d['tipe']) != ""){
                if($d['tipe'] != ""){
                    $tipe = (isset($d['tipe']) ? " and k.jenis ='".$d['tipe']."'" : '');
                }
            }
            if (isset($d['urut'])) {
                if ($d['urut'] !='') {
                    $urut = "ORDER BY ";
                    if ($d['urut'] == 1) {
                        $urut .= " k.id desc";
                    }else if($d['urut'] == 2){
                        $urut .= " dk.harga asc";
                    }else if($d['urut'] == 3){
                        $urut .= " dk.harga desc";
                    }
                }
            }
            $harga = "";
            if(isset($d['harga_awal'])){
                if(($d['harga_awal'] !="" ) && ($d['harga_tertinggi'] != "")){
                    $harga = " AND dk.harga BETWEEN '$d[harga_awal]' AND '$d[harga_tertinggi]'";
                }
            }
            $pencarian.=" $cari $kategori $tipe $harga";
            // SELECT *, ( 3959 * acos ( cos ( radians($key) ) * cos( radians( latitude) ) * cos( radians( longitude ) - radians($user) ) + sin ( radians($key) ) * sin( radians( latitude ) ) ) ) AS distance FROM outlet HAVING distance < 500 order by distance asc
            // 1 mile = 1,609 
            //key latitude and $user longitude
        }
        
        $kos = $this->db->query("SELECT k.nama, k.id, k.deskripsi,k.id_kategori, kk.nama as kategori, k.tanggal_ditambahkan, p.nama as nama_pemilik, dk.harga, m.link_media from $this->low
         k LEFT JOIN pengguna p on k.ditambahkan_oleh=p.id LEFT JOIN kategori kk on k.id_kategori=kk.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos LEFT JOIN (Select * from media) m on dk.id=m.id_kos  $pencarian GROUP BY  k.id  $urut")->result_array();
        // echo "k.nama, k.id, k.deskripsi, k.tanggal_ditambahkan, p.nama as nama_pemilik, dk.harga, m.link_media, ( 6371 * acos ( cos ( radians($lat) ) * cos( radians( latitude) ) * cos( radians( longitude ) - radians($lat) ) + sin ( radians($long) ) * sin( radians( latitude ) ) ) ) AS distance k LEFT JOIN pengguna p on k.ditambahkan_oleh=p.id LEFT JOIN (Select * from media) m on k.id=m.id_kos JOIN (Select * from detail_kos) dk on k.id=dk.id_kos $pencarian GROUP BY m.id_kos AND k.id  $urut";
        $kategori = $this->db->get("kategori")->result_array();
        // echo "<pre>";
        // print_r($kos);
        // echo "</pre>";
        $data = ['title' => 'Semua Kos', 'content' => 'kos/semua','data' => $kos, 'kategori' => $kategori];
        $this->load->view('frontend/index',$data);
        // echo "</pre>";
        // print_r($kos);
    }
    public function favorit($id){
        // $count = $this->favorit->select("*", "WHERE id_kos=$id and id_pengguna=".Account_Helper::get('id'))[0];
        $count = $this->db->query("SELECT * FROM favorit WHERE id_kos=$id and id_pengguna=".Account_Helper::get('id'))->num_rows();
        // echo $count;
        if($count < 1){
            $this->db->insert('favorit', ['id_kos' => $id, 'id_pengguna' => Account_Helper::get('id')]);
        }else{
            $this->db->delete('favorit', ['id_kos' => $id, 'id_pengguna' => Account_Helper::get('id')]);
        }
    }
    
    public function ulasan(){
        $d = $_POST;

        try {
            $arr = [
                'ulasan' => $d['ulasan'], 
                'id_pengguna' => Account_Helper::Get('id'), 
                'rating' => $d['rating'], 
                'id_kos' => $d['id_kos'], 
            ];

            $q = $this->db->insert('ulasan', $arr);
            // $q = $this->ulasan->Insert($arr);
            // echo json_encode($arr);
            echo json_encode(['status' => true]);
            
        }
        catch(Exception $e) {
            // if($e->errorInfo[2] == "Duplicate entry '$d[email]' for key 'email'")
            //     $_SESSION['alert'] = ['danger', 'Email sudah terpakai'];
            print_r($e->errorInfo);
            // $this->add();
        }
    }
    public function reviewExist($id){
        $d = $this->db->query("SELECT k.nama, u.* from ulasan u JOIN kos k on u.id_kos=k.id WHERE u.id_kos='$id' and u.id_pengguna=".Account_Helper::get('id'))->result_array(); 
        // $d = $this->ulasan->select("k.nama, u.*", "u JOIN kos k on u.id_kos=k.id WHERE u.id_kos='$id' and u.id_pengguna=".Account_Helper::get('id')); 
        echo json_encode($d);
    }
    public function pesanAction($id, $id_detail = null){
        $arr = [
            'id_kos' => $id_detail,
            'id_pengguna' => Account_Helper::Get("id"),
        ];
        $this->db->insert("pemesanan", $arr);
        $id = $this->db->insert_id();
        // Response::redirectWithAlert('akun/pemesanan/detail/'.$id, ['info', 'pemesanan berhasil diedit']);
        $this->session->set_flashdata("message", ['success', "pemesanan berhasil", ' Berhasil']);
        redirect(base_url("akun/pemesanan/detail/".$id));
    }
}