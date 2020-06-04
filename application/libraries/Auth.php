<?php 

class Auth{
    public function __construct()
	{
        $this->CI =& get_instance();

        /** 
         * jwt config file load
         */
        $this->CI->load->library('Authorization_Token');

    }
    public function test(){
        echo "berhasil";
        $response['data'] = $this->authorization_token->userData();
        echo json_encode($response);
    }
}

?>