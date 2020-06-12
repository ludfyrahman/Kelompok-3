<?php 

class Kos extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->low = "kos";
        
    }
    public function data($limit = null){
        $where = " ";
        $urut = "";
        $lat = (isset($_GET['lat']) ? $_GET['lat'] :0 );
        $long = (isset($_GET['long']) ? $_GET['long'] : 0);
        // echo $lat;
        if($limit != null){
            $where.=" LIMIT $limit ";
        }
        // $urut = " HAVING distance < 14322 order by distance asc";    
        if (isset($d['jarak'])) {
            if($d['jarak'] != ''){
                $urut = " HAVING distance < $d[jarak] order by distance asc";    
            }
        }
        
        $pencarian = $urut;
        if(isset($d['search'])){
            $pencarian = "Where ";
            $cari = "";
            if(isset($d['cari']) != ""){
                $cari = (isset($d['cari']) ? " k.nama like  '%".$d['cari']."%'" : '');
            }
            $kategori = "";
            if(isset($d['kategori'])){
                if($d['kategori'] != ""){
                    $kategori = (isset($d['kategori']) ? " and k.id_kategori ='".$d['kategori']."'" : '');
                }
            }
            $tipe = "";
            if(isset($d['tipe']) != ""){
                if($d['tipe'] != ""){
                    $tipe = (isset($d['tipe']) ? " and k.jenis ='".$d['tipe']."'" : '');
                }
            }
            if (isset($d['urut'])) {
                if ($d['urut'] !='') {
                    $urut = "ORDER BY ";
                    if ($d['urut'] == 1) {
                        $urut .= " k.id desc";
                    }else if($d['urut'] == 2){
                        $urut .= " dk.harga asc";
                    }else if($d['urut'] == 3){
                        $urut .= " dk.harga desc";
                    }
                }
            }
            $harga = "";
            if(isset($d['harga_awal'])){
                if(($d['harga_awal'] !="" ) && ($d['harga_tertinggi'] != "")){
                    $harga = " AND dk.harga BETWEEN '$d[harga_awal]' AND '$d[harga_tertinggi]'";
                }
            }
            $pencarian.=" $cari $kategori $tipe $harga";
            // SELECT *, ( 3959 * acos ( cos ( radians($key) ) * cos( radians( latitude) ) * cos( radians( longitude ) - radians($user) ) + sin ( radians($key) ) * sin( radians( latitude ) ) ) ) AS distance FROM outlet HAVING distance < 500 order by distance asc
            // 1 mile = 1,609 
            //key latitude and $user longitude
        }
        // echo "SELECT k.nama, k.id, k.latitude, k.longitude, k.deskripsi,k.id_kategori, kk.nama as kategori, k.tanggal_ditambahkan, p.nama as nama_pemilik, dk.harga, m.link_media, ( 6371 * acos ( cos ( radians($lat) ) * cos( radians( latitude) ) * cos( radians( longitude ) - radians($lat) ) + sin ( radians($long) ) * sin( radians( latitude ) ) ) ) AS distance from $this->low
        // k LEFT JOIN pengguna p on k.ditambahkan_oleh=p.id LEFT JOIN kategori kk on k.id_kategori=kk.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos LEFT JOIN (Select * from media) m on dk.id=m.id_kos  $where GROUP BY  k.id  $urut";
        $q = $this->db->query("SELECT k.nama, k.id, k.latitude, k.longitude, k.deskripsi,k.id_kategori, kk.nama as kategori, k.tanggal_ditambahkan, p.nama as nama_pemilik, dk.harga, m.link_media, ( 6371 * acos ( cos ( radians($lat) ) * cos( radians( latitude) ) * cos( radians( longitude ) - radians($lat) ) + sin ( radians($long) ) * sin( radians( latitude ) ) ) ) AS distance from $this->low
        k LEFT JOIN pengguna p on k.ditambahkan_oleh=p.id LEFT JOIN kategori kk on k.id_kategori=kk.id JOIN (Select * from detail_kos) dk on k.id=dk.id_kos LEFT JOIN (Select * from media) m on dk.id=m.id_kos  $where GROUP BY  k.id  $urut")->result_array();
        echo json_encode(['data' => $q]);
    }
    public function kategori($id = null){
        $where = " ";
        if($id != null){
            $where.=" WHERE ka.id='$id' ";
        }
        $q = $this->db->query("SELECT k.*, k.nama as kategori FROM $this->low k JOIN kategori ka ON k.id_kategori=ka.id $where")->result_array();
        echo json_encode(['data' => $q]);
    }
    public function jenis($id = null){
        $where = " ";
        if($id != null){
            $where.=" WHERE k.jenis='$id' ";
        }
        $q = $this->db->query("SELECT k.*, k.nama as kategori FROM $this->low k JOIN kategori ka ON k.id_kategori=ka.id $where")->result_array();
        echo json_encode(['data' => $q]);
    }
    
    public function wishlist($id){
        $d = $_POST;
        $where = " where p.id= ".$id;
        if(isset($d['search'])){
            $cari = $_POST['cari'];
            $where.=" and k.nama like '%$cari%' ";
        }
        $data['data'] = $this->db->query("SELECT k.nama, k.latitude, k.longitude, dk.harga,k.id, k.deskripsi, m.link_media, k.tanggal_ditambahkan from favorit f 
        JOIN kos k ON f.id_kos=k.id JOIN pengguna p on f.id_pengguna=p.id 
        JOIN (Select * from detail_kos) dk on k.id=dk.id_kos
        JOIN (Select * from media) m on k.id=m.id_kos $where GROUP BY m.id_kos")->result_array();
        echo json_encode($data);
    }
    public function detail($id, $id_detail = null){
        // $q = $this->db->get_where($this->low, ['id' => $id])->row_array();
        $detail_kos = $this->db->get_where("detail_kos",  ['id_kos' => $id])->result_array();
        $id_detail_kos= ($id_detail == null ? $detail_kos[0]['id'] : $id_detail);
        $data = $this->db->query("SELECT k.id, k.nama as nama_kos, k.dilihat,k.jenis, kat.nama as kategori, k.tanggal_diubah, k.latitude, k.longitude, k.deskripsi, dk.jumlah_kamar, dk.harga, k.tanggal_ditambahkan, p.nama,  p.email, p.no_hp 
        from $this->low k JOIN pengguna p ON k.ditambahkan_oleh=p.id 
        JOIN kategori kat ON k.id_kategori=kat.id
        JOIN (Select * from detail_kos) dk on k.id=dk.id_kos WHERE k.id='$id' and dk.id=$id_detail_kos GROUP BY k.id")->row_array();
        $media = $this->db->query("SELECT m.*, dk.id as id_detail_kos from  media m JOIN detail_kos dk ON m.id_kos=dk.id JOIN kos k ON k.id=dk.id_kos WHERE k.id='$data[id]'")->result_array();
        $ulasan = $this->db->query("SELECT u.*, p.nama,p.profil from ulasan u JOIN pengguna p on u.id_pengguna=p.id WHERE id_kos=$id ")->result_array();   
        $this->db->query("UPDATE kos set dilihat = dilihat + 1 WHERE id='$id'");
        $fasilitas = $this->db->query(" SELECT f.id, f.nama from  fasilitas_kos fk JOIN sub_fasilitas sf ON fk.id_fasilitas=sf.id JOIN fasilitas f ON sf.id_fasilitas=f.id WHERE fk.id_kos='$id_detail_kos' GROUP by f.id")->result_array();
        $index = 0;
        $rate = $this->db->get_where("ulasan", ['id_kos' => $id])->result_array();
        $max = 0;
        foreach ($rate as $key) {
            $max+=$key['rating'];
        }
        $rate = $max / (count($rate) == 0 ? 1 : count($rate));
        $subfas = array();
        
        foreach($fasilitas as $f){
            $subfas[$index] = $f;
            $sub_fasilitas = $this->db->query("SELECT * FROM sub_fasilitas sb JOIN fasilitas_kos fk ON sb.id=fk.id_fasilitas WHERE sb.id_fasilitas='$f[id]' and fk.id_kos='$id_detail_kos'")->result_array();
            // print_r($sub_fasilitas);
            $in = 0;
            foreach($sub_fasilitas as $sub){
                // print_r($sub);
                $subfas[$index]['sub'][$in] = $sub;
                $in++;
            }
            // print_r($sub_fasilitas);
            
            $index++;
        }
        // $data['kos'] = $kos;	
        $data['subfas'] = $subfas;
        $data['rate'] = $rate;
        $data['media'] = $media;
        $data['subfas'] = $subfas;
        $data['ulasan'] = $ulasan;
        $data['dk'] = $detail_kos;
        echo json_encode(['data' => $data]);
    }
    public function favorit(){
        print_r($this->authorization_token->userData());
        // $q = $this->db->query("SELECT * FROM kos k JOIN favorit w ON k.id=w.id_kos GROUP BY w.id_kos")->result_array();
        // echo json_encode(['data' => $q]);
    }
}

?>