<?php 
class Auth extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "pengguna";
        // $this->load->library("../controllers/admin/Setting");
    }
    public function index(){

    }
    public function info(){
        $d = $this->authorization_token->userData();
        $response['data'] = $this->db->get_where("$this->low", ['id' => $d->id])->row_array();
        echo json_encode($response);
    }
    public function lupa_password(){
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $d = $_POST;
            $response['status'] = false;
            // $setting = new Setting();
            try {
                $cek = $this->db->get_where("pengguna", ['email' => $d['email']]);
                if($cek->num_rows() > 0){
                    $response['status'] = true;
                    $cek = $cek->row_array();
                    $kode = Input_Helper::randomString(5);
                    $this->db->update("pengguna", ['verification' => $kode]);
                    $data = [
                        'kode' => $kode
                    ];
                    // echo $cek['email'];
                    Response_Helper::send("dawiyahrubi@gmail.com", $cek['email'], "Papikos", $this->load->view("part/lupa_password", $data,TRUE));
                    $response['message'] = 'Silahkan Cek email untuk mengubah password anda';
                }else{
                    $response['message'] = 'Email yang anda masukan tidak terdaftar';
                }
            }
            catch(Exception $e) {
                // $this->login();
                $response['message'] = 'Kesalahan';
            }
        }else{
            $response['message'] = 'Method Not allowed';
        }
        echo json_encode($response);
    }
    public function update_password(){
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $d = $_POST;
            $response['status'] = false;
            try {
                if($d['password'] != $d['password_confirmation']) {
                    $response['message'] = ['danger', 'Password konfirmasi tidak sama'];
                }else{
                    $data = $this->db->get_where("pengguna", ['id' => $d['id']])->row_array();
                    if(!password_verify($d['old_password'], $data['password'])) {
                        $response['message'] = ['danger', 'Password lama tidak sama'];
                    }else{
                        $arr = ['password' => password_hash($d['password'], PASSWORD_DEFAULT)];
                        $d = $this->db->update("pengguna", $arr, ['id' => $d['id']]);
                        if($d){
                            $response['status'] = true;
                            $response['message'] = 'Ubah Password Berhasil';
                        }else{
                            $response['message'] = 'Ubah password gagal';
                        }
                    }
                }
            }
            catch(Exception $e) {
                // $this->login();
                $response['message'] = 'Kesalahan';
            }
        }else{
            $response['message'] = 'Method Not allowed';
        }
        echo json_encode($response);
    }
    public function update_profile(){
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $d = $_POST;
            $response['status'] = false;
            try {
    
                $arr = [
                    'nama'              => $d['nama'],
                    'email'             => $d['email'],
                    'jenis_kelamin'     => $d['jenis_kelamin'],
                    'no_hp'             => $d['no_hp'],
                    'tanggal_lahir'     => $d['tanggal_lahir'],
                    'alamat'            => $d['alamat']
                ];
                $d = $this->db->update("pengguna", $arr, ['id' => $d['id']]);
                if($d){
                    $response['status'] = true;
                    $response['message'] = 'Ubah Profil Berhasil';
                }else{
                    $response['message'] = 'Ubah Profil gagal';
                }
            }
            catch(Exception $e) {
                // $this->login();
                $response['message'] = 'Kesalahan';
            }
        }else{
            $response['message'] = 'Method Not allowed';
        }
        echo json_encode($response);
    }
    public function update_rekening(){
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $d = $_POST;
            $response['status'] = false;
            try {
    
                $arr = [
                    'nama_bank'         => $d['nama_bank'],
                    'nama_rekening'     => $d['nama_rekening'],
                    'no_rekening'       => $d['no_rekening'],
                ];
                $d = $this->db->update("pengguna", $arr, ['id' => $d['id']]);
                if($d){
                    $response['status'] = true;
                    $response['message'] = 'Ubah Rekening Berhasil';
                }else{
                    $response['message'] = 'Ubah Rekening gagal';
                }
            }
            catch(Exception $e) {
                // $this->login();
                $response['message'] = 'Kesalahan';
            }
        }else{
            $response['message'] = 'Method Not allowed';
        }
        echo json_encode($response);
    }
    public function update_foto(){
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $d = $_POST;
            $response['status'] = false;
            try {
    
                if(App::validateSizeUpload(20097152 , $f['foto'])){
                    if(App::validateTypeUpload(['image/png', 'image/jpg', 'image/jpeg'], $f['foto'])){
                        $name = App::RandomString(5);
                        $tipe = str_replace("image/", "", $f['foto']['type']);
                        $f['foto']['name'] = $name.".".$tipe;
                        App::UploadImage($f['foto'], "profil");
                        $d = $this->db->update("pengguna", ['profil' => $name.".".$tipe], ['email' => $d['email']]);
                        if($d){
                            $response['status'] = true;
                            $response['message'] = 'Ubah Foto Berhasil';
                        }else{
                            $response['message'] = 'Ubah Foto gagal';
                        }
                    }else{
                        $response['message'] = 'File yang di upload tidak sesuai';
                    }
                }else{
                    $response['message'] = 'File yang di upload melebihi 2 mb';
                }
                
            }
            catch(Exception $e) {
                // $this->login();
                $response['message'] = 'Kesalahan';
            }
        }else{
            $response['message'] = 'Method Not allowed';
        }
        echo json_encode($response);
    }
    public function sign_In(){
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $d = $_POST;
            $response['status'] = false;
            try {
                if($d){
                    $a = $this->db->get_where("pengguna", ['email' => $d['email']])->result_array();
                    if(count($a) < 1) {
                        $response['message'] = 'Login gagal, silahkan cek email anda kembali';
                    }else{
                        $a = $a[0];
                        if($a['status'] == 0) {
                            $response['message'] = 'Login gagal, Akun anda sedang dinonaktifkan';
                        }else{
                            if(!password_verify($d['password'], $a['password'])) {
                                $response['message'] = 'Login gagal, Password anda salah';
                            }else{
                                $response['message'] = 'Login Berhasil';
                                $response['status'] = true;
                                $token_data['nama'] = $a['nama'];
                                $token_data['email'] = $a['email'];
                                $token_data['id'] = $a['id'];
                                $response['token'] = $this->authorization_token->generateToken($token_data);
                                $response['data'] = $a;
                            }
                        }
                    }
                }
            }
            catch(Exception $e) {
                $response['message'] = 'Kesalahan';
            }
        }else{
            $response['message'] = 'Method Not allowed';
        }
        echo json_encode($response);
    }
    public function sign_up(){
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $d = $_POST;
            $response['status'] = false;
            try {
                if($d){
                    if($d['password'] != $d['password_konfirmasi']) {
                        $response['message'] = 'Password konfirmasi harus sama';
                    }else{
                        $kode = random_string('alnum',5);
                        $arr = ['nama' => $d['nama'], 'email' => $d['email'], 'password' => password_hash($d['password'], PASSWORD_DEFAULT), 'level' => 3, 'verification' => $kode];
                        $response['message'] = 'Berhasil Register';
                        $response['data'] = $arr;
                        $this->db->insert($this->low, $arr);
                    }
                    
                }
            }
            catch(Exception $e) {
                // $this->login();
                echo "gagal";
            }
        }else{

        }
        echo json_encode($response);
    }
}

?>