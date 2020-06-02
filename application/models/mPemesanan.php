<?php
class MPemesanan extends CI_model {
    public function get (){
        $this->load->database();
        // return $this->db->get("artikel")->result();
    }
    public function dataPemesanan($date = []){
        $range = "";
        if (count($date) > 0) {
            
            $range .= "WHERE DATE(p.tanggal_pemesanan) BETWEEN '$date[0]' and '$date[1]'";
            if ($date[2] != "") {
                $range.=" AND p.status=$date[2] ";
            }
        }
        if(Account_Helper::get('level') == 2){
            $range.=" AND k.ditambahkan_oleh=".Account_Helper::get('id');
        }
        $q = $this->db->query("SELECT p.id, pg.nama_rekening, pg.nama_bank, pg.no_rekening, k.nama as nama_kos, p.status as status_code, dk.jumlah_kamar, dk.harga, pg.nama as nama_pemesan,p.tanggal_pemesanan, (CASE WHEN p.status = 0 THEN 'Ditolak' WHEN p.status = 1 THEN 'Pending' WHEN p.status = 2 THEN 'Dp' WHEN p.status = 3 THEN 'Lunas' END) as status from pemesanan p  JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k on dk.id_kos=k.id JOIN pengguna pg on p.id_pengguna=pg.id $range ORDER BY p.id DESC");
        return $q;
    }
    public function detailPemesanan($id){
        $q = $this->db->query("SELECT p.id,k.id as id_kos, pgg.nama_rekening, pgg.nama_bank, pgg.no_rekening, p.status as status_code, k.nama as nama_kos, dk.jumlah_kamar, dk.harga, pg.nama as nama, k.tanggal_diubah, pg.alamat, pg.no_hp, p.tanggal_pemesanan, pgg.nama as nama_pemilik, (CASE WHEN p.status = 0 THEN 'Ditolak' WHEN p.status = 1 THEN 'Pending' WHEN p.status = 2 THEN 'Dp' WHEN p.status = 3 THEN 'Lunas' END) as status , dk.id as id_detail FROM pemesanan p JOIN (Select * from detail_kos) dk on dk.id=p.id_kos JOIN kos k ON dk.id_kos=k.id JOIN pengguna pg on p.id_pengguna=pg.id JOIN pengguna pgg on k.ditambahkan_oleh=pgg.id WHERE p.id='$id'");
        // echo "SELECT p.id,k.id as id_kos, pgg.nama_rekening, pgg.nama_bank, pgg.no_rekening, p.status as status_code, k.nama as nama_kos, dk.jumlah_kamar, dk.harga, pg.nama as nama, k.tanggal_diubah, pg.alamat, pg.no_hp, p.tanggal_pemesanan, pgg.nama as nama_pemilik, (CASE WHEN p.status = 0 THEN 'Ditolak' WHEN p.status = 1 THEN 'Pending' WHEN p.status = 2 THEN 'Dp' WHEN p.status = 3 THEN 'Lunas' END) as status from pemesanan  p JOIN kos k ON p.id_kos=k.id JOIN pengguna pg on p.id_pengguna=pg.id JOIN pengguna pgg on k.ditambahkan_oleh=pgg.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos WHERE p.id='$id'";
        return $q;
    }
}