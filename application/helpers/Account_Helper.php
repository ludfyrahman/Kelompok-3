<?php
class Account_Helper {
    public static function Get($index) {
        $ci = get_instance();
		$d = $ci->db->get_where("pengguna", ['id' => $_SESSION['userid']])->row_array();
		// $d = $ci->db->get_where("pengguna", ['id' => $_SESSION['userid']])->row_array();

        return $d[$index];
    }
}