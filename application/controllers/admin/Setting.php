<?php

include APPPATH."libraries/PHPMAILER/PHPMailerAutoload.php";
class Setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->low = "setting";
		$this->cap = "Setting";
        $this->load->model('mPengguna', 'pengguna');
        $this->load->model('mpemesanan', 'pemesanan');
    }
    public function index() {
        $gmail = null;
        $facebook = null;
        $data['title'] = "Setting";
		$data['content'] = "$this->low/index";
        $data['gmail'] = $gmail;
        $data['facebook'] = $facebook;
        $this->load->view('backend/index',$data);
    }
    
    public function verification_code($from, $to){
        $kode = Input_Helper::randomString(5);
        $this->db->update('pengguna', ["verification" => $kode], ['id'=> Account_Helper::get("id")]);
        $subject = "Verifikasi Email";
        $this->send("dawiyahrubi@gmail.com", $to, $subject, "<h1>Verifikasi Akun ".Account_Helper::get("nama")."</h1><p>masukkan kode <b>".$kode." untuk verifikasi akun anda<p>");
    }
    public function lupa_password_email($from, $to){
        $data = [
            'kode' => Input_Helper::randomString(5)
        ];
        $this->send("dawiyahrubi@gmail.com", $to, "Papikos", $this->load->view("part/lupa_password", $data));
    }
    public function email(){
        $this->send("dawiyahrubi@gmail.com", "ludfyr@gmail.com", "Subject", "<h1>Verifikasi Password ludfyr@gmail.com </h1>");
    }
    public function template(){
        $data = [
            'kode' => Input_Helper::randomString(5)
        ];
        $this->load->view("part/lupa_password", $data);
    }
    public function verifikasi($id){
        $q = $this->db->get_where("pengguna",  ['verification' => $id]);
        if($q->num_rows() > 0 ){
            $this->db->update('pengguna', ['status' => 1], ['verification'=> $id]);
            $this->session->set_flashdata("alert", ['success', 'Verifikasi Akun Berhasil', ' Berhasil']);
			redirect(base_url("pengguna/login"));
        }else{
            $this->session->set_flashdata("alert", ['danger', 'Verifikasi Akun Gagal', ' Berhasil']);
			redirect(base_url("pengguna/login"));
        }
    }
    public function notifikasi_pembayaran($from, $to, $kode){
        $d = $this->db->query("SELECT p.id, pg.nama, p.tanggal_pemesanan, k.nama,p.status, k.harga FROM pemesanan p JOIN pengguna pg on p.id_pengguna=pg.id JOIN kos k on p.id_kos=k.id", "WHERE p.id='$kode'")[1][0];
        $invoice = invoice_code."".$d['id'];
        $status = "DP";
        $tempo = date('Y-m-d H:i:s', strtotime($d['tanggal_pemesanan']."+1 day"));
        $harga = 25 * $d['harga'] / 100;
        if($d['status'] == 1){
            $status = "DP";
            $tempo = date('Y-m-d H:i:s', strtotime($d['tanggal_pemesanan']."+1 day"));
            $harga = 25 * $d['harga'] / 100;
        }else if($d['status'] == 3){
            $status = "Pelunasan";
            $tempo = date('Y-m-d H:i:s', strtotime($d['tanggal_pemesanan']."+4 day"));
            $harga = ($d['harga'] - (25 * $d['harga'] / 100));
        }
        $subject = "Pembayaran Kos";
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($from, "Pembayaran Pemesanan Kos ".$d['nama']);
        $email->setSubject($subject);
        $email->addTo($to, "Notifikasi Pembayaran $status");
        $email->addContent("text/html", 
        "<h1>Pembayaran Kos $d[nama] $invoice</h1>
        <p>Kami menginformasikan bahwa pembayaran kos hampir jatuh tempo $tempo sebesar<p>
        <h3>$harga</h3>");
        $sg = new \SendGrid(SENDGRID_API_KEY);

        $response = $sg->client->mail()->send()->post($email);
                
        if ($response->statusCode() == 202) {
            echo 'done';
        } else {
            echo 'false';
        }
    }
    public function verification_code_hp($to){
        // $kode = Input_Helper::randomString(5);
        // $this->pengguna->update(["verification" => $kode], "WHERE id=".Account_Helper::get("id"));
        // $sms = new NexmoMessage(NEXMO_API_KEY, NEXMO_API_SECRET);
        // $sms->sendText( $to, 'Papikos', 'Kode Verifikasi '.$kode." " );
        $basic  = new \Nexmo\Client\Credentials\Basic('68206d0a', 'H9nFINin9ytRgmeT');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '6282231425636',
            'from' => 'Vonage APIs',
            'text' => 'Hello from Vonage SMS API'
        ]);
    }
    public function notifikasi_pembayaran_noHp($to){
        $kode = Input_Helper::randomString(5);
        // $this->pengguna->update(["verification" => $kode], "WHERE id=".Account_Helper::get("id"));
        $sms = new NexmoMessage(NEXMO_API_KEY, NEXMO_API_SECRET);
        $sms->sendText( $to, 'Papikos', 'Kode Verifikasi '.$kode." " );
    }
    public function tampil(){
        echo "ada ada aja";
    }
    public function send($from, $to, $subject, $body){
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'dawiyahrubi@gmail.com';                 // SMTP username
        $mail->Password = 'rubilemupanda';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom($from, 'papikos');
        $mail->addAddress($to, 'User');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // $mail->isHTML(true);                                  // Set email format to HTML

        $mail->IsHTML(true); 
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = 'jangan lupa';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
}