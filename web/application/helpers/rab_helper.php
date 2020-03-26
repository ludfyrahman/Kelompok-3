<?php
/**
*
*/
class Rab_helper
{

	public static function get_sisa_anggaran($kode_rab)
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where("rab", ['kode_rab' => $kode_rab])->row_array();
		return $cekData['sisa_anggaran'];
	}
	public static function get_total_anggaran($kode_rab)
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where("rab", ['kode_rab' => $kode_rab])->row_array();
		return $cekData['total_anggaran'];
	}
	public static function get_limit_bulanan($kode_rab)
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where("rab", ['kode_rab' => $kode_rab])->row_array();
		return $cekData['limit_bulanan'];
	}
	public static function get_nama_akunbank($kode_rab)
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where("akunbank", ['kode_akunbank' => $kode_rab])->row_array();
		return $cekData['nama_rekening'].' - '.$cekData['nama_bank'];
	}
	public static function cek_batas_limit_bulanan($kode_rab)
	{
		$ci = get_instance();
		$bulanini = date('Y-m');
		$kl = $ci->db->query("SELECT sum(jumlah_uang) as jmlkeluar from transaksi_keuangan where kode_sumber='$kode_rab' and tanggal like '%$bulanini%' and tipe='0' and status!='0'")->row_array();
		// $ms = $ci->db->query("SELECT sum(jumlah_uang) as jmlmasuk from transaksi_keuangan where kode_rab='$kode_rab' and tanggal like '%$bulanini%' and tipe='1'")->row_array();
		$cekData = $ci->db->get_where("rab", ['kode_rab' => $kode_rab])->row_array();
		$new = $cekData['limit_bulanan'] - $kl['jmlkeluar'];
		return $new;
	}
	public static function buat_transaksi_rab($datauang, $data_json)
	{
		$ci = get_instance();
		$arr = [
			'kode_keuangan' => $datauang['kodeuang'],
			'kode_usaha' => $datauang['kodeusaha'],
			'kode_sumber' => $datauang['kode_sumber'],
			'kode_transaksi' => $datauang['kodetrans'],
			'no_kwitansi' => $datauang['nokwi'],
			'metode_bayar' => $datauang['metode'],
			'create_by' => $datauang['creat_by'],
			'keterangan' => $datauang['keterangan'],
			'tanggal' => $datauang['tanggal'],
			'jumlah_uang' => $datauang['jmluang'],
			'tipe' => $datauang['tipe'],
			'tipe_transaksi' => $datauang['tipe_transaksi'],
			'data_json' => json_encode($data_json),
			'create_at' => date('Y-m-d H:i:s')
		];
		$kk = $ci->db->insert('transaksi_keuangan', $arr);

		$kode_sumber = $datauang['kode_sumber'];
		$tipe_transaksi = $datauang['tipe_transaksi'];
		$metode = $datauang['metode'];
		$jmluang = $datauang['jmluang'];
		$tipe = $datauang['tipe'];
		if($tipe_transaksi == "1"){
			$cekData = $ci->db->get_where("akunbank", ['kode_akunbank' => $kode_sumber])->row_array();
			$new = 0;
			if($tipe == 0){
				$new = $cekData['saldo'] - $jmluang;
			}else if($tipe == 1){
				$new = $cekData['saldo'] + $jmluang;			
			}else{
				$new = $cekData['saldo'];
			}
			$uu = [
				'saldo' => $new
			];
			$kk = $ci->db->update('akunbank', $uu, ['kode_akunbank' => $kode_sumber]);

		}else if($tipe_transaksi == "2"){
			$kode_rab = $kode_sumber;
			$cekData = $ci->db->get_where("rab", ['kode_rab' => $kode_rab])->row_array();
			$new = 0;
			$kasik = $cekData['saldo_diberikan'];
			if($tipe == 0){
				$new = $cekData['sisa_anggaran'] - $jmluang;
			}else if($tipe == 1){
				$new = $cekData['sisa_anggaran'] + $jmluang;
				$kasik = $kasik + $jmluang;
			}else{
				$new = $cekData['sisa_anggaran'];
			}
			$uu = [
				'sisa_anggaran' => $new,
				'saldo_diberikan' => $kasik
			];
			$kk = $ci->db->update('rab', $uu, ['kode_rab' => $kode_rab]);
			if($metode == "1"){
				$datbank = $ci->db->get_where("akunbank", ['kode_usaha' => $cekData['kode_usaha'], 'tipe_akun' => 3])->row_array();

			}else if($metode == "2"){
				$datbank = $ci->db->get_where("akunbank", ['kode_akunbank' => $cekData['kode_akunbank']])->row_array();
				
			}
			$arr = [
				'kode_keuangan' => $datauang['kodeuangdua'],
				'kode_usaha' => $datauang['kodeusaha'],
				'kode_sumber' => $datbank['kode_akunbank'],
				'kode_transaksi' => $datauang['kodetrans'],
				'no_kwitansi' => $datauang['nokwi'],
				'metode_bayar' => $datauang['metode'],
				'create_by' => $datauang['creat_by'],
				'keterangan' => $datauang['keterangan'],
				'tanggal' => $datauang['tanggal'],
				'jumlah_uang' => $datauang['jmluang'],
				'tipe' => $datauang['tipe'],
				'tipe_transaksi' => 1,
				'data_json' => json_encode($data_json),
				'create_at' => date('Y-m-d H:i:s')
			];
			$kk = $ci->db->insert('transaksi_keuangan', $arr);
			$new = 0;
			if($tipe == 0){
				$new = $datbank['saldo'] - $jmluang;
			}else if($tipe == 1){
				$new = $datbank['saldo'] + $jmluang;			
			}else{
				$new = $datbank['saldo'];
			}
			$uu = [
				'saldo' => $new
			];
			$kk = $ci->db->update('akunbank', $uu, ['kode_akunbank' => $datbank['kode_akunbank']]);

		}
		return $kk;
	}
	
	
}
