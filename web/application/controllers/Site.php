<?php
class Site extends CI_Controller { //mengextends CI_Controller 
    public function __construct(){
        parent::__construct();
    }
    public function index () {
        $data['title'] = "Login";
        $data['content'] = "login/index";
		$this->load->view('frontend/index',$data);
    }
    public function doLogin(){
        $d = $_POST;
        if(!$d){
            redirect(base_url(""));
        }
        try {
            if($d){
                $a = $this->db->get_where("pengguna", ['email' => $d['email']])->result_array();
                // print_r($a);
                // echo count($a);
                // $a = $this->akun->Select('*', "WHERE email = '$d[email]'")[1];

                if(count($a) < 1) {
                    $this->session->set_flashdata("message", ['danger', 'Login gagal, silahkan cek email anda kembali', ' Gagal']);
                    return $this->index();
                }

                $a = $a[0];

                if(!password_verify($d['password'], $a['password'])) {
                    $this->session->set_flashdata("message", ['danger', 'Login gagal, Password anda salah', ' Gagal']);
                    return $this->index();
                }

                $_SESSION['userid'] = $a['id'];
                $_SESSION['userlevel'] = $a['level'];
                redirect(base_url("admin/dashboard"));
            }
        }
        catch(Exception $e) {
            // $this->login();
            echo "gagal";
        }
    }
}
?>