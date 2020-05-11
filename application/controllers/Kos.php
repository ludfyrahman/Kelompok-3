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
    public function index(){
		$data['title'] = "Data $this->cap";
        $data['content'] = "$this->low/index";
        $where = "";
        if(Account_Helper::get('level') == 2){
            $where = " WHERE p.id=".Account_Helper::get('id');
        }
        $data['lists'] = $this->db->query("SELECT k.id, k.nama,dk.harga, ka.nama as nama_kategori from $this->low k JOIN kategori ka ON k.id_kategori=ka.id JOIN pengguna p on k.ditambahkan_oleh=p.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos $where GROUP BY dk.id_kos ORDER BY k.id asc ")->result_array();
        $this->load->view('backend/index',$data);
    }
	
	public function add()
	{
		$data['title'] = "Tambah $this->cap";
		$data['content'] = "$this->low/_form";
		$data['data'] = null;
        $data['type'] = 'Tambah';
        $kategori = $this->db->get("kategori")->result_array();
        $fasilitas = $this->db->get("fasilitas")->result_array();
        $index = 0;
        $index = 0;
        $subfas = array();
        foreach($fasilitas as $f){
            $subfas[$index] = $f;
            $sub_fasilitas = $this->db->get_where("sub_fasilitas", ['id_fasilitas' => $f['id']])->result_array();
            $in = 0;
            $subfas[$index]['sub'][$in] = '';
            foreach($sub_fasilitas as $sub){
                $subfas[$index]['sub'][$in] = $sub;
                $subfas[$index]['old_sub'][$in] = null;
                $in++;
            }
            $index++;
        }
        $data['subfas'] = $subfas;
        $data['kategori'] = $kategori;
		$this->load->view('backend/index',$data);
	}

	public function store(){
        $d = $_POST;
        $d = $_POST;
        $f = $_FILES;

        try {
            $arr = [
                'nama' => $d['nama'], 
                'deskripsi' => $d['deskripsi'], 
                'id_kategori' => $d['kategori'],
                'jenis' => $d['jenis'],
                'latitude' => $_COOKIE['lat'],
                'longitude' => $_COOKIE['long'],
                'ditambahkan_oleh' =>  Account_Helper::Get('id')
            ];
            $this->db->insert($this->low, $arr);
            $id = $this->db->insert_id();
            foreach ($d['type'] as $index => $t) {
                $arraytype = [
                    'id_kos' => $id,
                    'type' => $t,
                    'jumlah_kamar' => $d['jumlah_kamar'][$index],
                    'harga' => $d['harga'][$index],
                ];
                $this->db->insert('detail_kos', $arraytype);
                
                $id_detail =  $this->db->insert_id();
                $this->kos->add_sub($id_detail, $index);
                // print_r($arraytype);
            }
            $this->session->set_flashdata("alert", ['success', "Berhasil Tambah $this->cap", ' Berhasil']);
            redirect(base_url("$this->low/"));
            
        }
        catch(Exception $e) {
            // if($e->errorInfo[2] == "Duplicate entry '$d[email]' for key 'email'")
            $_SESSION['alert'] = ['danger', 'error'];
            $this->add();
        }

	}
		
	public function edit($id){
        $kategori = $this->db->get("kategori")->result_array();
        $fasilitas = $this->db->get("fasilitas")->result_array();
        $detail = $this->sb->get_where("detail_kos ", ['id_kos' => $id])->result_array();
        $index = 0;
            foreach($fasilitas as $f){
                $subfas[$index] = $f;
                $sub_fasilitas = $this->db->get_where("sub_fasilitas", ['id_fasilitas' => $f['id']])->result_array();
                $in = 0;
                $subfas[$index]['sub'][$in] = '';
                foreach($sub_fasilitas as $sub){
                    $subfas[$index]['sub'][$in] = $sub;
                    $in++;
                }
                $i = 0;
                foreach ($detail as $d) {
                    $inde = 0;
                    $subfas[$i][$index]['old_sub'][$inde] = '';
                    $sf = $this->db->query("SELECT sf.id FROM fasilitas_kos fk JOIN sub_fasilitas sf ON fk.id_fasilitas=sf.id WHERE id_kos=$d[id] and sf.id_fasilitas=$f[id]")->result_array();
                    foreach ($sf as $sfv) {
                        $subfas[$i][$index]['old_sub'][$inde] = $sfv['id'];
                        $inde++;
                    }
                    $i++;
                }
                $index++;
            }
        $subfas = array();
		$data['title'] = "Ubah $this->cap";
		$data['content'] = "$this->low/_form";
		$data['type'] = 'Ubah';
        $data['data'] = $this->db->get_where("$this->low", ['id' => $id])->row_array();	
        $data['subfas'] = $subfas;
        $data['kategori'] = $kategori;
        $data['detail'] = $detail;	
		$this->load->view('backend/index',$data);
	}
    public function storeFile($id){
        $f = $_FILES;
        print_r($f);
        $index = 0;
        foreach ($f["file"] as $key => $arrDetail) 
        {
            echo "berhasil";
            // foreach ($arrDetail as $index => $detail) {
                $targetDir = FCPATH."assets/images/upload/kos/";
                $type = explode('/', $f['file']['type'][$index]);
                $fileName = date('YmdHis').".".$type[1];
                $targetFile = $targetDir.$fileName;

                if(move_uploaded_file($_FILES["file"]['tmp_name'][$index],$targetFile))
                {
                    // $this->media->insert(['link_media' => $fileName, 'id_kos' => $id]);
                    $this->db->insert("media", ['link_media' => $fileName, 'id_kos' => $id]);
                    return "file uploaded"; 
                }else{
                    return "File not uploaded.";
                }
                $index++;
            // }
        }
    }
	public function update($id){
		$d = $_POST;
		try{
            $arr = [
                'nama' => $d['nama'], 
                'deskripsi' => $d['deskripsi'], 
                'jenis' => $d['jenis'],
                'id_kategori' => $d['kategori'],
            ];
            foreach ($d['type'] as $index => $t) {
                $arraytype = [
                    'type' => $t,
                    'jumlah_kamar' => $d['jumlah_kamar'][$index],
                    'harga' => $d['harga'][$index],
                ];
                $kode = $d['id'][$index];
                $this->db->update('detail_kos', $arraytype, "WHERE id='$kode'");
            }
			$this->db->update("$this->low",$arr, ['id' => $id]);
			$this->session->set_flashdata("alert", ['success', "Ubah $this->cap Berhasil", ' Berhasil']);
			redirect(base_url("$this->low/"));
			
		}catch(Exception $e){
			$this->session->set_flashdata("alert", ['danger', "Gagal Edit Data $this->cap", ' Gagal']);
			redirect(base_url("$this->low/edit/".$id));
			// $this->add();
		}
	}
	public function adminkos(){
        echo "admin/kos";
    }
	public function delete($id){
		try{
			$this->db->delete("$this->low", ['id' => $id]);
			$this->session->set_flashdata("alert", ['success', "Berhasil Hapus Data $this->cap", 'Berhasil']);
			redirect(base_url("$this->low/"));
			
		}catch(Exception $e){
			$this->session->set_flashdata("alert", ['danger', "Gagal Hapus Data $this->cap", 'Gagal']);
			redirect(base_url("$this->low/"));
		}
    }
    public function detail($id, $id_detail = null){ 
        $detail_kos = $this->db->get_where("detail_kos",  ['id_kos' => $id])->result_array();
        $id_detail_kos= ($id_detail == null ? $detail_kos[0]['id'] : $id_detail);
        $data = $this->db->query("SELECT k.id, k.nama as nama_kos, k.dilihat,k.jenis, k.tanggal_diubah, k.latitude, k.longitude, k.deskripsi, dk.jumlah_kamar, dk.harga, k.tanggal_ditambahkan, p.nama from $this->low k JOIN pengguna p ON k.ditambahkan_oleh=p.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos ", "WHERE k.id='$id' and dk.id=$id_detail_kos GROUP BY k.id")->row_array();
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
        // print_r($subfas);
        // echo "</pre>";
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
        $data = $this->db->query("SELECT k.id, k.nama as nama_kos,k.tanggal_diubah, k.latitude, k.longitude, k.deskripsi, dk.jumlah_kamar, dk.harga, k.tanggal_ditambahkan, p.nama $this->low k JOIN pengguna p ON k.ditambahkan_oleh=p.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos WHERE k.id='$id' and dk.id=$id_detail ")->row_array();
        $media = $this->media->Select("*", "WHERE id_kos='$data[id]' LIMIT 1")[1][0];
        $media = $this->db->query("SELECT * FROM media WHERE id_kos='$data[id]' LIMIT 1")->row_array();
        $data = ['title' => 'Login Papikos', 'content' => 'user/login'];
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
    
}