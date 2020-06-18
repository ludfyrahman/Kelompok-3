<?php
/**
*
*/
class Auth_helper{

    public static function secure(){
        if(!isset($_SESSION['userid'])){
            redirect(base_url());
        }
    }
    public static function Get($index) {
        $ci = get_instance();
        // $d = $a->Select($index, "WHERE id = $_SESSION[userid]");
        $d = $ci->db->get_where("pengguna", ['id' => "$_SESSION[userid]"])->row_array();
        // $ci->db->get_where("akunbank", ['kode_akunbank' => $kode_sumber])->row_array();
        return $d[$index];
    }
    public static function sendnotif($kunci = "",$body, $title, $key, $pk){
      
        $tokens = [];
        $message = [];
        $ci = get_instance();
        // echo $kunci;
        // $d = $a->Select($index, "WHERE id = $_SESSION[userid]");
        // $d = $ci->db->get_where("pengguna", ['id' => "$_SESSION[userid]"])->row_array();
        $datauser = $ci->db->get_where("pengguna",[$key => $pk])->result_array();
        foreach($datauser as $du){
          $tokens[] = $du['last_token'];
  
        }
  
          $message = ["pesan" => $title,
                      "body" => $body];
        $message_status = Auth_Helper::send_notification($tokens, $message, $body, $title, $kunci);
        // echo json_encode($message_status);
        return $message_status;
      }
  
      public static function send_notification ($tokens, $message, $body, $title, $kunci = "")
        {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = array(
              'registration_ids' => $tokens,
              'data' => array(
                        "message" => $message,
                        "title" => str_replace("%20", " ", $title),
                        "body" => str_replace("%20", " ", $body),
                        "kunci" => $kunci
              )
            );
            $headers = array(
              'Authorization:key = AAAAWLeSUVQ:APA91bEBOtasRBpJfZSfYrsnvbo6u27Vy1qG0cmOoq94XG1bKAS8cPpHxm8GJ8kTYgKOaSJ0xGZCnlQQv0TX_EuHRd2JSFBleSZc4N69YvnGBY0dqOGlUCV9xFt7sfUm8b9tPCus6zvr',
              'Content-Type: application/json'
              );
            $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
              $result = curl_exec($ch);           
              if ($result === FALSE) {
                  die('Curl failed: ' . curl_error($ch));
              }
              curl_close($ch);
              return $result;
          }
}