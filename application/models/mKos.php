<?php
class MKos extends CI_model {
    public function get (){
        $this->load->database();
        return $this->db->get("artikel")->result();
    }
    public function add_sub($id, $index) {
        $sub_fasilitas = Input_Helper::postOrOr('sub_fasilitas', []);
        $old_sub_fasilitas = Input_Helper::postOrOr('old_sub_fasilitas', []);
        // echo count($sub_fasilitas);
        // print_r($sub_fasilitas[$index]);
        // echo sizeof($sub_fasilitas);
        
        // foreach ($sub_fasilitas[$index] as $sb) {
            // print_r($sb);
            // echo "sub fasilitas bawah <br>";
            // print_r($old_sub_fasilitas);
            $ins = array_diff($sub_fasilitas[$index], $old_sub_fasilitas[$index]);
            $del = array_diff($old_sub_fasilitas[$index], $sub_fasilitas[$index]);
            // echo "batas <br>";
            $in = 0;
            foreach($ins as $i) {
                // print_r(['id_fasilitas' => $i, 'id_kos' => $id]);
                $this->db->insert('media', $arraymedia = [
                    'link_media' => $_FILES['file']['name'][$in],
                    'id_kos' => $id,
                    'type' => 1,
                ]);
                echo "<pre>";
                // print_r($_FILES['file']);
                Response_Helper::UploadMultiImage($_FILES['file'], "kos", $in);
                $this->db->insert("fasilitas_kos", ['id_fasilitas' => $i, 'id_kos' => $id]);
                $in++;
            }
            foreach($del as $i) {
                // echo "WHERE id_kos = $id AND id_fasilitas = $i ";
                if ($i !='') {
                    $this->db->delete("fasilitas_kos", ['id_kos' => $id, 'id_fasilitas' => $i]);
                }
            }
        // }
    }
    public function data($val = ""){
        return $this->db->query("SELECT k.nama, k.id, k.latitude, k.longitude, k.deskripsi,k.id_kategori, k.tanggal_ditambahkan, dk.harga, m.link_media FROM kos k JOIN (Select * from detail_kos) dk on k.id=dk.id_kos LEFT JOIN (Select * from media) m on dk.id=m.id_kos $val");
    }
}
?>