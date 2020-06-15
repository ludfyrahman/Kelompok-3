<?php 

class Notification extends CI_Controller
{
    public function __construct(){

    }
    public function sendnotif($kunci = "",$body, $title, $key, $pk){
      
        $tokens = ["dDmNGmwAFeY:APA91bFh2QU4mFiRgA02Bi_8SQNt6ARH3wl3uLLFholVpxjMNON0s3uOkxYROsJ-UUHBez6eHLOkZrEaN419qW5RXNkfsyz7-wI90Mv5vUQ8yLDWJ0UU2oWAnPFA4aJbkigzZ8Ypa9ip"];
        $message = [];
        // $datauser = $this->Maksi->getDataApi("user",$pk,$key);	
        // foreach($datauser as $du){
        //   $tokens[] = $du['last_token'];
  
        // }
  
          $message = ["pesan" => $title,
                      "body" => $body];
        $message_status = $this->send_notification($tokens, $message, $body, $title, $kunci);
        // echo json_encode($message_status);
        return $message_status;
      }
  
      public function send_notification ($tokens, $message, $body, $title, $kunci = "")
        {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = array(
              'registration_ids' => $tokens,
              'data' => array(
                        "message" => $message,
                        "title" => $title,
                        "body" => $body,
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


?>

