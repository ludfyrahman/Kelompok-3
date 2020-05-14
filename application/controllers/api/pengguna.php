<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pengguna extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get(){
        $this->response([
            'status' => true,
            'message' => 'User berhasil login'
        ], 200);
    }
}