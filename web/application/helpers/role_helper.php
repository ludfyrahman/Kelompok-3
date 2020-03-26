<?php
/**
*
*/
class Role_helper
{

	public static function cek_atur_role($koderole, $kodemenu, $akses)
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where("akses_user", ['kode_role' => $koderole, 'kode_menu' => $kodemenu, 'aksesnya' => $akses])->row_array();
		if($cekData > 1){
			return "checked='checked'";
		}
	}
	public static function cek_role($koderole, $kodemenu, $akses)
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where("akses_user", ['kode_role' => $koderole, 'kode_menu' => $kodemenu, 'aksesnya' => $akses])->row_array();
		if($cekData > 1){
			return true;
		}else{
			return false;
		}
	}
	public static function buatlog($tipe, $deskripsi, $cretaeat, $createby="")
	{
		$ci = get_instance();
		$cekData = $ci->db->insert("log_system", ['type_log' => $tipe, 'deskripsi' => $deskripsi, 'create_at' => $cretaeat, 'create_by' => $createby]);
		if($cekData){
			return true;
		}else{
			return false;
		}
	}
	public static function buatnotif($kodemenu, $deskripsi, $cretaeat, $kodebantu="", $link="")
	{
		$ci = get_instance();
		$cekData = $ci->db->insert("notifikasi", ['kode_menu' => $kodemenu, 'deskripsi' => $deskripsi, 'create_at' => $cretaeat, 'kode_bantu' => $kodebantu, 'link' => $link]);
		if($cekData){
			return true;
		}else{
			return false;
		}
	}
	public static function get_setting()
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where("pengaturan_app", ['kode' => 1])->row_array();
		return $cekData;
		
	}
	public static function getdata($tabel, $kolom, $isi, $kolomreturn)
	{
		$ci = get_instance();
		$cekData = $ci->db->get_where($tabel, [$kolom => $isi])->row_array();
		if($cekData){
			return $cekData[$kolomreturn];
		}else{
			return null;
		}
	}
	
}
