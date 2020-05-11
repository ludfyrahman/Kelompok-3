<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengguna extends CI_Controller {
	function __construct()
  	{
		parent::__construct();
		$this->low = "pengguna";
		$this->cap = "Pengguna";
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
        $data['lists'] = $this->db->get("$this->low")->result_array();
        $this->load->view('backend/index',$data);
    }
	
	public function add()
	{
		$data['title'] = "Tambah $this->cap";
		$data['content'] = "$this->low/_form";
		$data['data'] = null;
		$data['type'] = 'Tambah';
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
		$data['type'] = 'Ubah';
		$data['data'] = $this->db->get_where("$this->low", ['id' => $id])->row_array();		
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
    public function profil() {
        $data['title'] = 'Profil '.Account_Helper::Get('nama');
		$data['content'] = 'user/profil';
        $this->load->view('frontend/index',$data);
    }

    public function lupa_password() {
        $data['title'] = 'Lupa Password';
		$data['content'] = 'user/lupa_password';
        $this->load->view('frontend/index',$data);
    }
    public function ubah_password($kode) {
        $data['title'] = 'Ubah Password ';
		$data['content'] = 'user/password';
        $this->load->view('frontend/index',$data);
    }
    public function proses_ubah_password($kode){
        $d = $_POST;
        try {
            // echo "password lama "
            if($d['new_password'] != $d['password_confirmation']) {
                $_SESSION['alert'] = ['danger', 'Password konfirmasi tidak sama'];
                // echo "password konfirmasi tidak sama";
                return $this->ubah_password($kode);
            }

            $arr = ['password' => password_hash($d['new_password'], PASSWORD_DEFAULT)];

            $this->db->update("$this->low", $arr, ['verification' => $kode]);

            $this->session->set_flashdata("alert", ['success', "Password berhasil diubah", 'Berhasil']);
			redirect(base_url("$this->low/"));
        }
        catch(Exception $e) {
            $this->password();
        }
    }
    public function proses_forgot_password(){
        $d = $_POST;
        $c = $this->db->get_where($this->low, ['email' => $d['email']])->result_array();
        // $c = $this->pengguna->select("*", "WHERE email='$d[email]'");
        if(count($c) > 0 ){
            $this->setting->lupa_password_email("papikos@gmail.com", $c[0]['email']);
            // echo "ada cek email";
            $_SESSION['alert'] = ['info', 'Verifikasi Terkirim ke email '.$c[0]['email']];
            return $this->lupa_password();
        }else{
            $_SESSION['alert'] = ['info', 'Email anda tidak terdaftar di aplikasi'];
            return $this->lupa_password();
        }
    }
    
    public function proses_verifikasi($tipe = 'email'){
        $d = $_POST;
        try {
            $j = $this->db->get_where("$this->low", ['verification' => $d['verification_code']]);
            // print_r($j);
            if ($j[0] > 0) {
                if($tipe == 'email'){
                    $arr = ['stemail' => 1];
                    
                }else if($tipe == 'nohp'){
                    $arr = ['stnohp' => 1];
                }
                $q = $this->db->update("$this->low", $arr, ['verification' => $d['verification_code']]);
                if(!$q){
                    echo json_encode(['status' => true]);
                }else{
                    echo json_encode(['status' => false]);    
                }
                
            }else{
                echo json_encode(['status' => false]);
            }
        }
        catch(Exception $e) {
            print_r($e);
        }
    }
    public function proses_profile() {
        $d = $_POST;

        try {
            $arr = ['name' => $d['name'], 'email' => $d['email']];

            $this->db->update($this->low, $arr, ['id' => $_SESSION['userid']]);

            if($_SESSION['userlevel'] == 1){
                $this->session->set_flashdata("alert", ['success', "pengguna berhasil diedit", 'Berhasil']);
                redirect(base_url("$this->low/profil"));
            }else if($_SESSION['userlevel'] == 2){
                $this->session->set_flashdata("alert", ['success', "pengguna berhasil diedit", 'Berhasil']);
                redirect(base_url("$this->low/profil"));
            }
        }
        catch(Exception $e) {
            if($e->errorInfo[2] == "Duplicate entry '$d[email]' for key 'email'")
                $_SESSION['alert'] = ['danger', 'Email sudah terpakai'];

            return $this->profile();
        }
    }

    public function proses_password() {
        $d = $_POST;
        try {
            // echo "password lama "
            if(!password_verify($d['old_password'], Account_Helper::Get('password'))) {
                $_SESSION['alert'] = ['danger', 'Password lama tidak sama'];
                // echo "password lama tidak sama";
                return $this->profil();
            }
            if($d['new_password'] != $d['password_confirmation']) {
                $_SESSION['alert'] = ['danger', 'Password konfirmasi tidak sama'];
                // echo "password konfirmasi tidak sama";
                return $this->profil();
            }

            

            $arr = ['password' => password_hash($d['new_password'], PASSWORD_DEFAULT)];

            $this->db->update($this->low, $arr, ['id' => $_SESSION['userid']]);

            $this->session->set_flashdata("alert", ['success', "Password berhasil diubah", 'Berhasil']);
            redirect(base_url("$this->low/profil/"));
        }
        catch(Exception $e) {
            $this->password();
        }
    }

    public function login() {
        // echo CLIENT_REDIRECT_URL;
        $gmail_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
        $data['title'] = 'Login Papikos ';
		$data['content'] = 'user/login';
		$data['gmail'] = $gmail_url;
        $this->load->view('frontend/index',$data);
    }

    public function loginfb(){
        $fb = new Facebook\Facebook([
            'app_id' => APP_FACEBOOK_ID,
            'app_secret' => APP_FACEBOOK_SECRET,
            'default_graph_version' => 'v3.2',
            ]);
          
          $helper = $fb->getRedirectLoginHelper();
          
          $permissions = ['email']; // Optional permissions
          $loginUrl = $helper->getLoginUrl('http://localhost/papikos/helpers/facebook/fb-callback.php', $permissions);
          
          echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }

    public function register() {
        
        $data['title'] = 'Register Papikos ';
		$data['content'] = 'user/register';
		$data['gmail'] = $gmail_url;
        $this->load->view('frontend/index',$data);
    }

    public function proses_login() {
        $d = $_POST;

        try {
            // $a = $this->pengguna->Select('*', "WHERE email = '$d[email]'")[1];
            $a = $this->db->get_where($this->low, ['email' => $d['email']])->result_array();

            if(count($a) < 1) {
                $_SESSION['alert'] = ['danger', "Login gagal, email anda tidak terdaftar silahkan cek kembali"];
                return $this->login();
            }
            if($a[0]['status'] == 0) {
                $_SESSION['alert'] = ['danger', "Login gagal, akun anda belum diaktifasi"];
                return $this->login();
            }
            $a = $a[0];

            if(!password_verify($d['password'], $a['password'])) {
                $_SESSION['alert'] = ['danger', "Login gagal, password anda salah silahkan cek kembali"];
                return $this->login();
            }

            $_SESSION['userid'] = $a['id'];
            $_SESSION['userlevel'] = $a['level'];
            
            redirect(base_url(""));
        }
        catch(Exception $e) {
            $this->login();
        }
    }

    public function proses_register() {
        $d = $_POST;
        try {
            if($d['password'] != $d['password_confirmation']) {
                $_SESSION['alert'] = ['danger', "Password konfirmasi harus sama"];
                return $this->login();
            }
            $kode = Input_Helper::randomString(5);
            $arr = ['nama' => $d['nama'], 'email' => $d['email'], 'password' => password_hash($d['password'], PASSWORD_DEFAULT), 'level' => 3, 'verification' => $kode];
            $this->db->insert($this->low, $arr);
            $this->setting->send("rezamufti24@gmail.com", $arr['email'], 'Verifikasi Akun Papikos', 'Verifikasi Akun Papikos. klik <a href="'.BASEURL."verifikasi/$kode".'">'.$kode.'</a>');
            
            $this->session->set_flashdata("alert", ['success', "Register berhasil, verifikasi akun terlebih dahulu", 'Berhasil']);
            redirect(base_url("$this->low/login/"));
        }
        catch(Exception $e) {
            if($e->errorInfo[2] == "Duplicate entry '$d[email]' for key 'email'")
                $_SESSION['alert'] = ['danger', 'Email sudah terpakai'];
                print_r($e->errorInfo[2]);
            redirect(base_url("$this->low/login/"));
        }
    }
    public function simpanProfil(){
        $d = $_POST;
        try{
            $arr = [
                    'nama' => $d['nama'],
                    'email' => $d['email'],
                    'no_hp' => $d['no_hp'],
                    'jenis_kelamin' => $d['jenis_kelamin'],
                    'tanggal_lahir' => $d['tanggal_lahir'],
                    'alamat' => $d['alamat']
                ];
                $this->db->update($this->low, $arr, ['id' => Account_Helper::get('id')]);
                // $this->pengguna->update($arr, "WHERE id=1");
                return true;
                // print_r($arr);
        }catch(Exception $e){
            print_r($e);
        }
    }
    public function simpanRekening(){
        $d = $_POST;
        try{
            $arr = [
                    'nama_bank' => $d['nama_bank'],
                    'nama_rekening' => $d['nama_rekening'],
                    'no_rekening' => $d['no_rekening'],
                ];
                $this->db->update($this->low, $arr, ['id' => Account_Helper::get('id')]);
                // $this->pengguna->update($arr, "WHERE id=1");
                return true;
        }catch(Exception $e){
            print_r($e);
        }
    }
    public function uploadFotoProfil(){
        $f = $_FILES;
        if(Response_Helper::validateSizeUpload(20097152 , $f['foto'])){
            if(Response_Helper::validateTypeUpload(['image/png', 'image/jpg', 'image/jpeg'], $f['foto'])){
                $name = Input_Helper::RandomString(5);
                $tipe = str_replace("image/", "", $f['foto']['type']);
                $f['foto']['name'] = $name.".".$tipe;
                Response_Helper::UploadImage($f['foto'], "profil");
                $this->db->update($this->low, ['profil' => $name.".".$tipe], ['id' => Account_Helper::get('id')]);
            }else{
                echo json_encode(['danger', 'file yang anda upload tidak sesuai.']);
            }
        }else{
            $_SESSION['alert'] = ['danger', 'file yang anda upload melebihi batas upload.'];
            $this->add();
        }
    }
}
