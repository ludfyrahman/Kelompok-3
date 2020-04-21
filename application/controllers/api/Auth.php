<?php 
class Auth extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "pengguna";
    }
    public function index(){

    }
    public function info(){
        $response['data'] = $this->db->get_where($this->low)->row_array();
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
                                $response['data'] = $this->authorization_token->userData();
                            }
                        }
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