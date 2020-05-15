<?php

class Type extends CI_Controller{
    public function lengkap ()
    {
        $data ['lengkap'] = $this->model_type->data_lengkap()->result();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('admin/type/Lengkap', $data);
        $this->load->view('template/footer');
    }
    public function cukup ()
    {
        $data ['cukup'] = $this->model_type->data_cukup()->result();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('admin/type/cukup', $data);
        $this->load->view('template/footer');
    }
    public function kurang ()
    {
        $data ['kurang'] = $this->model_type->data_kurang()->result();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('admin/type/kurang', $data);
        $this->load->view('template/footer');
    }
}