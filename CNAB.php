<?php
namespace CNAB;

/**
 * Classe para geração de CNAB Bancário
 *
 * @author Willker Moraes Silva
 * @since 2016-07-20
 */
class CNAB {

	/**
	 * @var array[CNABField]
	 */
	private $aFields = array();

	/**
	 *
	 * @param string $value
	 * @param number $len
	 * @param string $fill
	 * @param mixed $pdType
	 * @return self
	 */
	public function addField($value, $len = 1, $fill = ' ', $pdType = STR_PAD_LEFT){
		$this->aFields[] = new CNABField($value, $len, $fill, $pdType);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFile(){
		$file = "";

		foreach ($this->aFields as $oFiled)
			$file .= $oFiled->getValue();

		return $file;
	}
}
