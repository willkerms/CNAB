<?php
namespace CNAB;

class CNABField{
	/**
	 * @var number
	 */
	private $len = 1;

	/**
	 * @var string
	 */
	private $fill = ' ';

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var string
	 */
	private $pdType = STR_PAD_LEFT;

	public function __construct($value, $len = 1, $fill = ' ', $pdType = STR_PAD_LEFT){
		$this->value = $value;
		$this->len = $len;
		$this->fill = $fill;
		$this->pdType = $pdType;
	}

	/**
	 * @return number $len
	 */
	public function getLen() {
		return $this->len;
	}

	/**
	 * @return string $fill
	 */
	public function getFill() {
		return $this->fill;
	}

	/**
	 * @return string $value
	 */
	public function getValue() {

		if(strlen($this->value) > $this->len && defined("IS_DEVELOPMENT") && IS_DEVELOPMENT && defined("APP_DEBUG") && APP_DEBUG && defined("APP_DEBUG_CNAB") && APP_DEBUG_CNAB)
			throw new \Exception("Campo com mais caracteres do que pemitido para o layout! tamanho(" . $this->len . "), campo(" . $this->value . ")");

		$return = CNABUtil::fillString($this->value, $this->len, $this->fill, $this->pdType);

		//if($return != PHP_EOL)
		//	return str_pad(strlen($return), $this->len, " ", STR_PAD_LEFT);

		return $return;
	}

	/**
	 * @param number $len
	 */
	public function setLen($len) {
		$this->len = $len;
	}

	/**
	 * @param string $fill
	 */
	public function setFill($fill) {
		$this->fill = $fill;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @return the $pdType
	 */
	public function getPdType() {
		return $this->pdType;
	}
	/**
	 * @param string $pdType
	 */
	public function setPdType($pdType) {
		$this->pdType = $pdType;
	}
}