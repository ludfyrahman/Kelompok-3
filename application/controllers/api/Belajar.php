<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

class Belajar extends RestController {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }
    function index_get() {
        $pengguna = $this->db->get("pengguna")->result();
        $this->response($mahasiswa, 200);
    }

}
?>