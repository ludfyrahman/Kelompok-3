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
		if($this->uri->segment(3) == "add" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->store($this->uri->segment(4));
		}else if($this->uri->segment(3) == "edit" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->update($this->uri->segment(4), $this->uri->segment(5));
		}
    }
    public function logout() {
        // echo "keluar";
        unset($_SESSION['userid']);
        unset($_SESSION['userlevel']);
        $_SESSION['alert'] = ['info', 'Logout berhasil'];
        redirect(base_url("$this->low/login"));
    }
    public function index(){
		$data['title'] = "Data $this->cap";
        $data['content'] = "$this->low/index";
        $where = "";
        if(Account_Helper::get('level') == 2){
            $where = " WHERE p.id=".Account_Helper::get('id');
        }
        $data['lists'] = $this->db->query("SELECT k.id, k.nama,dk.harga, ka.nama as nama_kategori from kos k JOIN kategori ka ON k.id_kategori=ka.id JOIN pengguna p on k.ditambahkan_oleh=p.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos $where GROUP BY dk.id_kos ORDER BY k.id asc")->result_array();
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
        $data['d'] = null;
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
                'email' => $d['email'], 
                'password' => password_hash($d['password'], PASSWORD_DEFAULT), 
                'level' => $d['level'],
                'status' => $d['status'],
                'nik' => $d['nik'], 
                'no_hp' => $d['no_hp'], 
                'jenis_kelamin' => $d['jenis_kelamin'],
                'tanggal_lahir' => $d['tanggal_lahir'],
                'nama_rekening' => $d['nama_rekening'],
                'no_rekening' => $d['no_rekening'],
                'nama_bank' => $d['nama_bank'],
                'alamat' => "jalan pakisan desa bataan tenggarang bondowoso",
                'tanggal_ditambahkan' => date('Y-m-d'),
            ];
            if(Response_Helper::validateSizeUpload(20097152 , $f['ktp'])){
                if(Response_Helper::validateTypeUpload(['image/png', 'image/jpg', 'image/jpeg'], $f['ktp'])){
                    if(Response_Helper::validateSizeUpload(20097152 , $f['profil'])){
                        if(Response_Helper::validateTypeUpload(['image/png', 'image/jpg', 'image/jpeg'], $f['profil'])){
                            $f['profil']['name'] = $d['email'].".".str_replace("image/", "", $f['profil']['type']);
                            $f['ktp']['name'] = $d['email'].".".str_replace("image/", "", $f['ktp']['type']);
                            Response_Helper::UploadImage($f['profil'], "profil");
                            Response_Helper::UploadImage($f['ktp'], "ktp");
                            $arr['ktp'] = $f['ktp']['name'];
                            $arr['profil'] = $f['profil']['name'];
                            if($d['password'] != $d['password_konfirmasi']){
                                $_SESSION['alert'] = ['danger', 'Password konfirmasi dengan password tidak sama'];
                                $this->add();
                                 $this->session->set_flashdata("alert", ['success', "Berhasil Tambah $this->cap", ' Berhasil']);
                                redirect(base_url("$this->low/"));
                            }else{
                                $arr['password'] = password_hash($d['password'], PASSWORD_DEFAULT);
                            }
                            // $this->pengguna->Insert($arr);
                            $this->db->insert("$this->low", $arr);
                        }else{
                            $_SESSION['alert'] = ['danger', 'foto profile yang anda upload tidak sesuai.'];
                            $this->add();
                        }
                    }
                    // $this->karyawan->Insert($arr);
                }else{
                    $_SESSION['alert'] = ['danger', 'ktp yang anda upload tidak sesuai.'];
                    $this->add();
                }
            }else{
                $this->session->set_flashdata("alert", ['success', "File ktp melebihi kapasitas", ' Berhasil']);
                redirect(base_url("$this->low/"));
            }
            
        }
        catch(Exception $e) {
            // if($e->errorInfo[2] == "Duplicate entry '$d[email]' for key 'email'")
            $_SESSION['alert'] = ['danger', 'error'];
            $this->add();
        }

	}
		
	public function edit($id){
		$data['title'] = "Ubah $this->cap";
		$data['content'] = "$this->low/_form";
		$data['type'] = 'Edit';
        $data['data'] = $this->db->get_where("$this->low", ['id' => $id])->row_array();		
        $kategori = $this->db->get("kategori");
        $fasilitas = $this->db->get("fasilitas")->result_array();
        
        $detail = $this->db->query("SELECT * FROM detail_kos WHERE id_kos=$id")->result_array();
        $subfas = array();
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
        $data['detail'] = $detail;
		$this->load->view('backend/index',$data);
	}
	
	public function update($id){
		$d = $_POST;
		try{
            $arr = [
                'nama' => $d['nama'], 
                'email' => $d['email'], 
                'level' => $d['level'],
                'status' => $d['status'],
                'nik' => $d['nik'], 
                'no_hp' => $d['no_hp'], 
                'jenis_kelamin' => $d['jenis_kelamin'],
                'tanggal_lahir' => $d['tanggal_lahir'],
                'nama_rekening' => $d['nama_rekening'],
                'no_rekening' => $d['no_rekening'],
                'nama_bank' => $d['nama_bank'],
                'alamat' => $d['alamat'],
                'tanggal_ditambahkan' => date('Y-m-d'),
            ];
            if($f['ktp']['name'] !=''){
                if(Response_Helper::validateSizeUpload(20097152 , $f['ktp'])){
                    if(Response_Helper::validateTypeUpload(['image/png', 'image/jpg', 'image/jpeg'], $f['ktp'])){
                        $f['ktp']['name'] = $d['email'].".".str_replace("image/", "", $f['ktp']['type']);
                        Response_Helper::UploadImage($f['ktp'], "ktp");
                        $arr['ktp'] = $f['ktp']['name'];
                    }else{
                        $_SESSION['alert'] = ['danger', 'ktp yang anda upload tidak sesuai.'];
                        $this->add();
                    }
                }
            }
            if($f['profil']['name'] !=''){
                if(Response_Helper::validateSizeUpload(20097152 , $f['profil'])){
                    if(Response_Helper::validateTypeUpload(['image/png', 'image/jpg', 'image/jpeg'], $f['profil'])){
                        $f['profil']['name'] = $d['email'].".".str_replace("image/", "", $f['profil']['type']);
                        Response_Helper::UploadImage($f['profil'], "profil");
                        $arr['profil'] = $f['profil']['name'];
                    }else{
                        $_SESSION['alert'] = ['danger', 'foto profile yang anda upload tidak sesuai.'];
                        $this->add();
                    }
                }
            }
            if(Input_Helper::postOrOr('password') != ''){
                if($d['password'] != $d['password_konfirmasi']){
                    $this->session->set_flashdata("alert", ['info', "Password konfirmasi dengan password tidak sama"]);
                    redirect(base_url("$this->low/"));
                }else{
                    $arr['password'] = password_hash($d['password'], PASSWORD_DEFAULT);
                }
            }
            // $this->pengguna->Update($arr, "WHERE id = $id");
			$this->db->update("$this->low",$arr, ['id' => $id]);
			$this->session->set_flashdata("alert", ['success', "Ubah $this->cap Berhasil", ' Berhasil']);
			redirect(base_url("$this->low/"));
			
		}catch(Exception $e){
			$this->session->set_flashdata("alert", ['danger', "Gagal Edit Data $this->cap", ' Gagal']);
			redirect(base_url("$this->low/edit/".$id));
			// $this->add();
		}
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
}