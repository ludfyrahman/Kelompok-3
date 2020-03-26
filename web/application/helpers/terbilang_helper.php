<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('number_to_words'))
{
	function number_to_words($number)
	{
		$before_comma = trim(to_word($number));
		// $after_comma = trim(comma($number));
		return ucwords($results = $before_comma.' Rupiah ');
	}

	function number_to_words_noprice($number)
	{
		$before_comma = trim(to_word($number));
		// $after_comma = trim(comma($number));
		return ucwords($results = $before_comma.' ');
	}

	function to_word($number)
	{
		$words = "";
		$arr_number = array(
		"",
		"satu",
		"dua",
		"tiga",
		"empat",
		"lima",
		"enam",
		"tujuh",
		"delapan",
		"sembilan",
		"sepuluh",
		"sebelas");

		if($number<12)
		{
			$words = " ".$arr_number[$number];
		}
		else if($number<20)
		{
			$words = to_word($number-10)." belas";
		}
		else if($number<100)
		{
			$words = to_word($number/10)." puluh ".to_word($number%10);
		}
		else if($number<200)
		{
			$words = "seratus ".to_word($number-100);
		}
		else if($number<1000)
		{
			$words = to_word($number/100)." ratus ".to_word($number%100);
		}
		else if($number<2000)
		{
			$words = "seribu ".to_word($number-1000);
		}
		else if($number<1000000)
		{
			$words = to_word($number/1000)." ribu ".to_word($number%1000);
		}
		else if($number<1000000000)
		{
			$words = to_word($number/1000000)." juta ".to_word($number%1000000);
		}
		else
		{
			$words = "undefined";
		}
		return $words;
	}

	function comma($number)
	{
		$after_comma = stristr($number,',');
		$arr_number = array(
		"nol",
		"satu",
		"dua",
		"tiga",
		"empat",
		"lima",
		"enam",
		"tujuh",
		"delapan",
		"sembilan");

		$results = "";
		$length = strlen($after_comma);
		$i = 1;
		while($i<$length)
		{
			$get = substr($after_comma,$i,1);
			$results .= " ".$arr_number[$get];
			$i++;
		}
		return $results;
	}

	
	 
	function buat_sidebar($items,$class = 'sidebarnav', $clasparent="waves-effect waves-dark") {

		$html = "<ul id=\"".$class."\" class=\"".$class."\">";
		$arro = "";
		foreach($items as $value) {
			if(array_key_exists('child',$value)) {
				$arro = "has-arrow ";
				
			}else{
				$arro  = "";
			}
			$html.= '<li><a class="'.$arro.$clasparent.'" href="'.base_url().$value['link'].'" aria-expanded="false"><i style="margin-right:5px;" class="fa '.$value['icon'].'"></i><span class="hide-menu">'.$value['nama_menu'].'</span></a>';
			if(array_key_exists('child',$value)) {
				$html .= buat_sidebar($value['child'],'collapse',"");
			}
				$html .= "</li>";
		}
		$html .= "</ul>";

		return $html;

	}
}