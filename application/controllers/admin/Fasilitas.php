<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fasilitas extends CI_Controller {
	function __construct()
  	{
		parent::__construct();
		$this->low = "fasilitas";
		$this->cap = "Fasilitas";
		date_default_timezone_set('Asia/Jakarta');
		// if(!isset($_SESSION['kode_user'])){
		// 	redirect(base_url());
		// }
		if($this->uri->segment(3) == "add" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->store($this->uri->segment(4));
		}else if($this->uri->segment(3) == "edit" && $_SERVER['REQUEST_METHOD'] == "POST"){
		  $this->update($this->uri->segment(4));
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
        $data['list'] = $this->db->get("$this->low")->result_array();
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
                'tanggal_ditambahkan' => date("Y-m-d H:i:s"),
                'ditambahkan_oleh' => Account_Helper::Get('id')
            ];
            $this->db->insert("$this->low", $arr);
            $this->session->set_flashdata("alert", ['success', "Berhasil Tambah $this->cap", ' Berhasil']);
            redirect(base_url("admin/$this->low/"));
            
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
            ];
            // $this->pengguna->Update($arr, "WHERE id = $id");
			$this->db->update("$this->low",$arr, ['id' => $id]);
			$this->session->set_flashdata("alert", ['success', "Ubah $this->cap Berhasil", ' Berhasil']);
			redirect(base_url("admin/$this->low/"));
			
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
			redirect(base_url("admin/$this->low/"));
			
		}catch(Exception $e){
			$this->session->set_flashdata("alert", ['danger', "Gagal Hapus Data $this->cap", 'Gagal']);
			redirect(base_url("admin/$this->low/"));
		}
    }
}
