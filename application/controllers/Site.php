<?php
class Site extends CI_Controller { //mengextends CI_Controller 
    public function __construct(){
        parent::__construct();
        // echo BASEPATH;
    }
    public function index () {
        $data['title'] = "Papikos Homepage";
        $data['content'] = 'site/home';
        $data['kos'] = $this->db->query('SELECT k.nama, k.id, k.deskripsi, m.link_media, p.nama as nama_pemilik, k.tanggal_ditambahkan, dk.harga from kos k LEFT JOIN pengguna p on k.ditambahkan_oleh=p.id LEFT JOIN (Select * from detail_kos) dk on k.id=dk.id_kos LEFT JOIN (Select * from media) m on dk.id=m.id_kos  GROUP BY m.id_kos ORDER BY id DESC LIMIT 0, 3')->result_array();
        $data['jumlahkategori'] = $this->db->get('kategori')->num_rows();
        $data['jumlahpengguna'] = $this->db->get('pengguna')->num_rows();
        $data['jumlahkos'] = $this->db->get('kos')->num_rows();
        // echo "<pre>";
        // print_r($kos);
		$this->load->view('frontend/index',$data);
    }
    public function wishlist(){
        $d = $_POST;
        $where = " where p.id= ".Account_Helper::Get('id');
        if(isset($d['search'])){
            $cari = $_POST['cari'];
            $where.=" and k.nama like '%$cari%' ";
        }
        $data['title'] = 'Profil '.Account_Helper::Get('nama');
        $data['content'] = 'user/wishlist';
        $data['data'] = $this->db->query("SELECT k.nama, dk.harga,k.id, k.deskripsi, m.link_media, k.tanggal_ditambahkan from favorit f 
        JOIN kos k ON f.id_kos=k.id JOIN pengguna p on f.id_pengguna=p.id 
        JOIN (Select * from detail_kos) dk on k.id=dk.id_kos
        JOIN (Select * from media) m on k.id=m.id_kos $where GROUP BY m.id_kos")->result_array();
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
                if($a['status'] == 0) {
                    $this->session->set_flashdata("message", ['danger', 'Login gagal, Akun anda sedang dinonaktifkan', ' Gagal']);
                    return $this->index();
                }
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
    public function database(){
        $data['title'] = "DataBase";
		$data['content'] = "database/index";
        $this->load->view('backend/index',$data);
    }
    public function backup(){
        $this->load->dbutil();
        $prefs = array(
            'format' => 'zip',
            'filename' => 'my_backup.zip'
        );
        $backup =& $this->dbutil->backup($prefs);
        $db_name = 'backup_on'.date('Y-m-d-H-i-s').".zip";
        $save = base_url('assets/').$db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);
        $this->session->set_flashdata("message", ['success', "Berhasil Backup File", ' Berhasil']);
        redirect(base_url("site/database"));
    }
    public function logout(){
        session_destroy();
        redirect(base_url());
    }
}
?>