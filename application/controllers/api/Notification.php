<?php 

class Notification extends CI_Controller
{
    public function __construct(){

    }
    public function sendnotif($kunci = "",$body, $title, $key, $pk){
      
        $tokens = ["dyrXh5mEqkE:APA91bHF9Xb-sLDkIU4A-hSdaWJR6W7QS1eZw03nRoNwBt2utB3Chk5M41Ack4j40v6lkOOxGWOlaBdCa7NCQ_3PtfDFvzh8AFcaH2cjcK6OsDnXa0_8uHAU4S0b6g61nEzDLDqCMdaY"];
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

