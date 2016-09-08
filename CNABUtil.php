<?php
namespace CNAB;

/**
 * Classe para geraзгo de CNAB Bancбrio
 *
 * @author Willker Moraes Silva
 * @since 2016-07-21
 */
class CNABUtil {

	/**
	 * Retorna uma data no padrгo cnab ddmmaa
	 *
	 * @param string $date
	 * @return string
	 */
	public static function retDate($date){
		if(!empty($date))
			return date('dmy', strtotime($date));
		else
			return $date;
	}

	/**
	 * Retorna um valor no padrгo cnab
	 *
	 * @param number $value
	 * @return string
	 */
	public static function retNumber($value){
		return number_format((double)$value, 2, ',', '');
	}

	/**
	 * Preenche com o caracter informado em $fill de acordo com o len passado
	 *
	 * @param string $value
	 * @return string
	 */
	public static function fillString($value, $len, $fill = " ", $pdType = STR_PAD_LEFT){
		return str_pad(substr($value, 0, $len), $len, $fill, $pdType);
	}

	/**
	 * Retorna somente os nъmeros contidos em uma string
	 *
	 * @param string $string
	 * @return mixed
	 */
	public static function onlyNumbers($string){
		return preg_replace("/[^0-9]/", "", $string);
	}
}