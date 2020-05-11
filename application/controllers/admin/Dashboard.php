<?php
include "Report.php";
class Dashboard extends CI_Controller { //mengextends CI_Controller 
    private $report;
    public function __construct(){
        parent::__construct();
        $this->report = new Report;
    }
    public function index () {
        $data['title'] = "Dashboard";
        $data['content'] = "dashboard/index";
        $now = date("Y-m");
        $next_month = date('Y-m', strtotime($now. ' +1 month'));
        $data_pesanan = [0, 0, 0, 0];
        foreach ($this->report->data($now, $next_month) as $k) {
            $data_pesanan[0]+=$k['ditolak'];
            $data_pesanan[1]+=$k['pending'];
            $data_pesanan[2]+=$k['dp'];
            $data_pesanan[3]+=$k['lunas'];
        }
        $wherefirst = "";
        $wherelast = "";
        if (Account_Helper::get('level') !=1) {
            $wherelast = " AND pg.id =".Account_Helper::get('id');
            $wherefirst = " WHERE pg.id =".Account_Helper::get('id');
        }
        $data['kategori']   = $this->kategori->Select("*", "");
        $data['pengguna']   = $this->pengguna->Select("*", "");
        $data['pemesanan']  = $this->pemesanan->Select("*", "p JOIN kos k ON p.id_kos=k.id JOIN pengguna pg ON k.ditambahkan_oleh=pg.id $wherefirst");
        $pesanan_bulan_ini  = $this->pemesanan->Select("*", "p JOIN kos k ON p.id_kos=k.id JOIN pengguna pg ON k.ditambahkan_oleh=pg.id WHERE p.tanggal_pemesanan BETWEEN '$now-01' and '$next_month-01' $wherelast");
        $data['fasilitas']  = $this->fasilitas->Select("*", "");
        $pemesanan_lunas  = $this->pemesanan->Select("p.*, SUM(pp.jumlah) as jumlah, pg.nama, pg.no_hp", "p JOIN pembayaran pp on pp.id_pemesanan=p.id JOIN pengguna pg on p.id_pengguna=pg.id ", "where p.status=3 and pp.status=1 $wherelast GROUP BY p.id");
        $pemesanan_pembayaran_lunas  = $this->pemesanan->Select("SUM(pp.jumlah) as jumlah", "p JOIN pembayaran pp on pp.id_pemesanan=p.id JOIN kos k ON k.id=p.id_kos JOIN pengguna pg ON k.ditambahkan_oleh=pg.id where p.status=3 and pp.status=1 $wherelast");
        // echo "SELECT SUM(pp.jumlah) as jumlah FROM pemesanan p JOIN pembayaran pp on pp.id_pemesanan=p.id JOIN kos k ON k.id=p.id_kos JOIN pengguna pg ON k.ditambahkan_oleh=pg.id where p.status=3 and pp.status=1 $wherelast";
        $data['pembayaran'] = $this->pembayaran->Select("*", "");
        $data['kos']        = $this->kos->Select("*", "");
        $tahun = date('Y');
        $pemesanan_chart  = $this->pemesanan->Select("COUNT(*) as jumlah, DATE_FORMAT(p.tanggal_pemesanan, '%m') as tanggal", "p JOIN kos k ON p.id_kos=k.id JOIN pengguna pg ON k.ditambahkan_oleh=pg.id WHERE YEAR(tanggal_pemesanan) = $tahun $wherelast", "GROUP BY tanggal")[1];
        $jumlah_pemesanan = [];
        $bulan_pemesanan = [];
        foreach ($pemesanan_chart as $p) {
            array_push($jumlah_pemesanan, $p['jumlah']);
            array_push($bulan_pemesanan, $p['tanggal']);
        }
        $data['jumlah_pemesanan']  = json_encode($jumlah_pemesanan);
        $data['bulan_pemesanan']  = json_encode($bulan_pemesanan);
        $presentase_pemesanan = (100  * count($pemesanan_lunas[1]) / $pemesanan[0]);
        $label_pesanan = status_pemesanan;
        $data['label_pesanan'] =  json_encode($label_pesanan);
        $data['data_pesanan'] =  json_encode($data_pesanan);
        $data['jumlah_pesanan_bulan'] = count($pesanan_bulan_ini);
        $data['pemesanan_lunas'] = $pemesanan_pembayaran_lunas[1][0];
        $data['data_pemesanan_lunas'] = $pemesanan_lunas;
        $data['presentase_pemesanan'] = number_format($presentase_pemesanan);
		$this->load->view('backend/index',$data);

    }
}
?>