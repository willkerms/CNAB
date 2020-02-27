<?php
namespace CNAB;

use PQD\PQDUtil;

/**
 * Classe para geração de CNAB Bancário
 *
 * @author Willker Moraes Silva
 * @since 2016-07-21
 */
class CNABUtil {

	/**
	 * Retorna uma data no padrão cnab ddmmaa
	 *
	 * @param string $date
	 * @return string
	 */
	public static function retDate($date, $format = 'dmy'){
		if(!empty($date))
			return date($format, strtotime($date));
		else
			return $date;
	}

	/**
	 * Retorna um valor no padrão cnab
	 *
	 * @param number $value
	 * @return string
	 */
	public static function retNumber($value){
		return number_format((double)$value, 2, ',', '');
	}

	/**
	 * Retorna um float para a string dada
	 *
	 * @param string $value
	 * @return number
	 */
	public static function retFloat($value, $precision = 2){

		if (!empty($value)){
			$decimal = substr($value, $precision * -1);
			$value = substr($value, 0, strlen($value) - $precision);

			return (double)($value . '.' . $decimal);
		}
		else
			return 0.0;
	}

	/**
	 * Retorna int
	 *
	 * @param string $value
	 * @return int
	 */
	public static function retInt($value){
		return (int)$value;
	}

	/**
	 * Retorna uma data no formato americano
	 *
	 * @param string $value
	 * @return string
	 */
	public static function retDateUS($date, $format = 'dmy'){

		$repeat = str_repeat('0', strlen(date($format)));

		if(!empty($date) && $date != $repeat){
			$date = \DateTime::createFromFormat($format, $date);

			if($date instanceof \DateTime)
				return $date->format('Y-m-d');
		}

		return null;
	}

	/**
	 * Retira zeros a esquerda
	 *
	 * @param string $value
	 * @return string
	 */
	public static function retiraZeros($value){
		return preg_replace("/^0*/", "", $value);
	}

	/**
	 * Retira espaços e zeros
	 *
	 * @param string $value
	 * @return string
	 */
	public static function retiraEspacosEZeros($value){
		return trim(self::retiraZeros($value));
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
	 * Retorna somente os números contidos em uma string
	 *
	 * @param string $string
	 * @return mixed
	 */
	public static function onlyNumbers($string){
		return PQDUtil::onlyNumbers($string);
	}
}